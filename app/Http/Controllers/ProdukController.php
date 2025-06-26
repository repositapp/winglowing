<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\Keranjang;
use App\Models\Produk;
use App\Models\ProdukGambar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    public function index()
    {
        $produks = Produk::with(['kategori']);

        $search = request('search');
        if (request('search')) {
            $produks->when($search, function ($query, $search) {
                $query->where('kode_produk', 'like', '%' . $search . '%')
                    ->orWhere('nama_produk', 'like', '%' . $search . '%')
                    ->orWhere('brand', 'like', '%' . $search . '%')
                    ->orWhere('price', 'like', '%' . $search . '%')
                    ->orWhere('cost_price', 'like', '%' . $search . '%')
                    ->orWhere('stock', 'like', '%' . $search . '%')

                    // Relasi ke kategori
                    ->orWhereHas('kategori', function ($q) use ($search) {
                        $q->where('name', 'like', '%' . $search . '%')
                            ->orWhere('slug', 'like', '%' . $search . '%');
                    });
            })
                ->latest();
        }

        $produks = $produks->paginate(10)->appends(['search' => $search]);

        return view('produk.index', compact('produks', 'search'));
    }

    public function create()
    {
        $kategoris = Kategori::all();
        return view('produk.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'kategori_id' => 'required',
            'nama_produk' => 'required',
            'brand' => 'nullable',
            'price' => 'required|integer',
            'cost_price' => 'required|integer',
            'stock' => 'required|integer',
            'description' => 'nullable',
            'discount' => 'nullable|numeric',
            'gambar.*' => 'image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $produk = Produk::create($validatedData);

        if ($request->hasFile('gambar')) {
            foreach ($request->file('gambar') as $img) {
                $path = $img->store('produk-images', 'public');
                ProdukGambar::create([
                    'kode_produk' => $produk->kode_produk,
                    'gambar' => $path
                ]);
            }
        }

        return redirect()->route('produk.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    public function edit(Produk $produk)
    {
        $kategoris = Kategori::all();
        $gambars = $produk->gambar; // relasi gambar

        return view('produk.edit', compact('produk', 'kategoris', 'gambars'));
    }

    public function destroyGambar($id)
    {
        $gambar = ProdukGambar::findOrFail($id);

        // Hapus file dari storage
        Storage::disk('public')->delete($gambar->gambar);

        // Hapus record dari database
        $gambar->delete();

        return response()->json(['success' => true]);
    }

    public function update(Request $request, Produk $produk)
    {
        $validatedData = $request->validate([
            'kategori_id' => 'required',
            'nama_produk' => 'required',
            'brand' => 'nullable',
            'price' => 'required|integer',
            'cost_price' => 'required|integer',
            'stock' => 'required|integer',
            'description' => 'nullable',
            'discount' => 'nullable|numeric',
            'gambar.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $produk->update($validatedData);

        // Proses gambar baru
        if ($request->hasFile('gambar')) {
            foreach ($request->file('gambar') as $img) {
                $path = $img->store('produk-images', 'public');
                ProdukGambar::create([
                    'kode_produk' => $produk->kode_produk,
                    'gambar' => $path
                ]);
            }
        }

        return redirect()->route('produk.index')->with('success', 'Data Produk berhasil diperbarui.');
    }

    public function destroy(Produk $produk)
    {
        // Ambil semua gambar terkait
        $gambars = $produk->gambar;

        // Hapus file gambar dari storage
        foreach ($gambars as $gambar) {
            Storage::disk('public')->delete($gambar->gambar);
        }

        // Hapus data gambar dari tabel produk_gambar
        ProdukGambar::where('kode_produk', $produk->kode_produk)->delete();

        // Hapus produk
        $produk->delete();

        if ($produk->transaksis()->count() > 0) {
            return redirect()->route('produk.index')->with('error', 'Produk tidak dapat dihapus karena masih terhubung ke transaksi!');
        } else {
            return redirect()->route('produk.index')->with('success', 'Produk dan semua gambar berhasil dihapus!');
        }
    }

    public function produkAll(Request $request)
    {
        $query = Produk::query();

        if ($request->search) {
            $query->where('nama_produk', 'like', '%' . $request->search . '%');
        }

        $produks = $query->paginate(12);
        $kategoris = Kategori::all();

        return view('customer.produk_keseluruhan', compact('produks', 'kategoris'));
    }

    public function byKategori(Request $request, $id)
    {
        $kategori = Kategori::where('id', $id)->firstOrFail();
        $query = $kategori->produk();

        if ($request->search) {
            $query->where('nama_produk', 'like', '%' . $request->search . '%');
        }

        $produks = $query->paginate(12);
        $kategoris = Kategori::all();

        return view('customer.produk_kategori', compact('produks', 'kategoris', 'kategori'));
    }

    public function diskon(Request $request)
    {
        $produks = Produk::where('discount', '>', 0)
            ->when($request->search, function ($query, $search) {
                $query->where('nama_produk', 'like', '%' . $search . '%');
            })
            ->paginate(12);

        $kategoris = Kategori::all();
        return view('customer.produk_diskon', compact('produks', 'kategoris'));
    }

    public function populer(Request $request)
    {
        $search = $request->input('search');

        $produks = Produk::select('produks.id', 'produks.nama_produk', 'produks.kode_produk', 'produks.price', 'produks.discount', 'produks.kategori_id', DB::raw('SUM(transaksi_details.qty) as total_terjual'))
            ->join('transaksi_details', 'produks.id', '=', 'transaksi_details.produk_id')
            ->join('transaksis', 'transaksi_details.kode_transaksi', '=', 'transaksis.kode_transaksi') // sesuaikan
            ->where('transaksis.status', 'diterima')
            ->when($request->search, function ($query, $search) {
                $query->where('produks.nama_produk', 'like', "%$search%");
            })
            ->groupBy('produks.id', 'produks.nama_produk', 'produks.kode_produk', 'produks.price', 'produks.discount', 'produks.kategori_id')
            ->orderByDesc('total_terjual')
            ->paginate(12);

        $kategoris = Kategori::all();
        return view('customer.produk_populer', compact('produks', 'kategoris', 'search'));
    }

    public function show($kode_produk)
    {
        $produk = Produk::with('kategori', 'gambar')->where('kode_produk', $kode_produk)->firstOrFail();
        // Produk berdasarkan kategori
        $produkKategori = Produk::with('kategori', 'gambarUtama')->where('kategori_id', $produk->kategori_id)->inRandomOrder()->limit(10)->get();

        return view('customer.produk_detail', compact('produk', 'produkKategori'));
    }

    public function addToCart(Request $request)
    {
        // dd($request);
        // Jika user belum login, middleware akan otomatis redirect
        $request->validate([
            'produk_id' => 'required',
            'qty' => 'required|integer|min:1'
        ]);

        Keranjang::create([
            'user_id' => auth()->id(),
            'produk_id' => $request->produk_id,
            'qty' => $request->qty,
        ]);

        return redirect()->route('keranjang.index')->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    public function keranjangIndex()
    {
        $items = Keranjang::with('produk')
            ->where('user_id', auth()->id())
            ->get();

        $produkAcak = Produk::with('gambarUtama')->inRandomOrder()->limit(10)->get();

        return view('customer.keranjang', compact('items', 'produkAcak'));
    }

    public function hapusKeranjang($id)
    {
        $item = Keranjang::findOrFail($id);

        if ($item->user_id != auth()->id()) {
            abort(403); // Forbidden
        }

        $item->delete();

        return redirect()->route('keranjang.index')->with('success', 'Produk dihapus dari keranjang.');
    }
}
