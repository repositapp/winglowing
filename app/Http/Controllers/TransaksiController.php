<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Keranjang;
use App\Models\Ongkir;
use App\Models\Produk;
use App\Models\Rekening;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index(Request $request, $status)
    {
        $allowedStatuses = ['baru', 'packing', 'pengiriman', 'diterima', 'dibatalkan'];

        if (!in_array($status, $allowedStatuses)) {
            abort(404);
        }

        $search = $request->input('search');

        $transaksis = Transaksi::with('biodata')
            ->where('status', $status)
            ->when($search, function ($query) use ($search, $status) {
                $query->where(function ($q) use ($search) {
                    $q->where('kode_transaksi', 'like', "%$search%")
                        ->orWhereHas('biodata', function ($q2) use ($search) {
                            $q2->where('nama_lengkap', 'like', "%$search%");
                        });
                });
            })
            ->latest()
            ->paginate(10)
            ->appends(['search' => $search]);

        $titleMap = [
            'baru' => 'Pesanan Baru',
            'packing' => 'Pesanan Packing',
            'pengiriman' => 'Pesanan Pengiriman',
            'diterima' => 'Pesanan Diterima',
            'dibatalkan' => 'Pesanan Dibatalkan',
        ];

        $title = $titleMap[$status] ?? 'Manajemen Transaksi';

        return view("transaksi.$status.index", compact('transaksis', 'title', 'search', 'status'));
    }

    public function show($kode_transaksi)
    {
        $transaksi = Transaksi::with(['details.produk', 'biodata', 'rekening'])
            ->where('kode_transaksi', $kode_transaksi)
            ->firstOrFail();
        return view('transaksi.show', compact('transaksi'));
    }

    public function updateStatus(Request $request, $kode_transaksi)
    {
        $transaksi = Transaksi::where('kode_transaksi', $kode_transaksi)->firstOrFail();

        $request->validate([
            'status' => 'required|in:baru,packing,pengiriman,diterima,dibatalkan'
        ]);

        $transaksi->update(['status' => $request->status]);

        return redirect()->route('transaksi.index', $request->status)
            ->with('success', 'Status transaksi berhasil diperbarui.');
    }

    public function cancel($kode_transaksi)
    {
        $transaksi = Transaksi::where('kode_transaksi', $kode_transaksi)->firstOrFail();
        $transaksi->update(['status' => 'dibatalkan']);

        return redirect()->route('transaksi.index', 'dibatalkan')
            ->with('success', 'Transaksi berhasil dibatalkan.');
    }

    public function cetakInvoice($kode_transaksi)
    {
        $transaksi = Transaksi::with(['details.produk', 'biodata', 'rekening'])
            ->where('kode_transaksi', $kode_transaksi)
            ->firstOrFail();

        return view('transaksi.invoice', compact('transaksi'));
    }

    public function checkout()
    {
        $user = auth()->user();
        $keranjangs = Keranjang::with('produk')->where('user_id', $user->id)->get();
        $rekenings = Rekening::all();

        $user = auth()->user();
        $villageId = optional($user->biodataOne)->village_id;

        $ongkir = Ongkir::where('village_id', $villageId)->value('biaya') ?? 0;

        $total = 0;
        foreach ($keranjangs as $item) {
            $harga = $item->produk->diskon ? ($item->produk->price - $item->produk->diskon) : $item->produk->price;
            $total += $harga * $item->qty;
        }

        return view('customer.checkout', compact('keranjangs', 'rekenings', 'ongkir', 'total'));
    }

    public function checkoutStore(Request $request)
    {
        $request->validate([
            'metode_pembayaran' => 'required|in:cod,transfer',
            'rekening_id' => 'required_if:metode_pembayaran,transfer',
        ]);

        $user = auth()->user();
        $keranjangs = Keranjang::where('user_id', $user->id)->with('produk')->get();
        if ($keranjangs->isEmpty()) return back()->with('error', 'Keranjang Anda kosong!');

        $tanggal = now()->format('dmy');
        // Cek jumlah transaksi keseluruhan
        $count = Transaksi::count() + 1;

        $kodeUrut = str_pad($count, 4, '0', STR_PAD_LEFT); // jadikan 00001, 00002, dst
        $kode_transaksi = 'TRX-' . $tanggal . '-' .  $kodeUrut;

        $total = $keranjangs->sum(function ($item) {
            $harga = $item->produk->price;
            if ($item->produk->discount) {
                $harga -= ($harga * $item->produk->discount / 100);
            }
            return $harga * $item->qty;
        });

        $user = auth()->user();
        $villageId = optional($user->biodataOne)->village_id;

        $ongkir = Ongkir::where('village_id', $villageId)->value('biaya') ?? 0;

        $grand_total = $total + $ongkir;

        if ($request->rekening_id == 'Pilih Rekening') {
            $rekening = null;
        } else {
            $rekening = $request->rekening_id;
        }

        Transaksi::create([
            'user_id' => $user->id,
            'rekening_id' => $rekening,
            'metode_pembayaran' => $request->metode_pembayaran,
            'kode_transaksi' => $kode_transaksi,
            'total' => $total,
            'ongkir' => $ongkir,
            'grand_total' => $grand_total,
        ]);

        foreach ($keranjangs as $item) {
            $harga = $item->produk->price;
            if ($item->produk->discount) {
                $harga -= ($harga * $item->produk->discount / 100);
            }

            TransaksiDetail::create([
                'produk_id' => $item->produk_id,
                'kode_transaksi' => $kode_transaksi,
                'qty' => $item->qty,
                'subtotal' => $harga * $item->qty,
            ]);
        }

        Keranjang::where('user_id', $user->id)->delete();

        if ($request->metode_pembayaran == 'cod') {
            return redirect()->route('transaksi.list')->with('success', 'Transaksi berhasil!');
        } else {
            return redirect()->route('checkout.pay', $kode_transaksi)->with('success', 'Silahkan kirim bukti transfer anda!');
        }
    }

    public function checkoutPay($kode_transaksi)
    {
        $transaksi = Transaksi::with(['details.produk', 'biodata', 'rekening'])
            ->where('kode_transaksi', $kode_transaksi)
            ->firstOrFail();

        return view('customer.checkout_pay', compact('transaksi'));
    }

    public function checkoutPayStore(Request $request, $kode_transaksi)
    {
        $transaksi = Transaksi::where('kode_transaksi', $kode_transaksi)->firstOrFail(); // PERBAIKI LINE INI

        $validatedData = $request->validate([
            'image_transfer' => 'nullable|image|file|mimes:png,jpg,jpeg,webp|max:1024',
        ]);

        if ($request->file('image_transfer')) {
            $file = $request->file('image_transfer');
            $fileName = $kode_transaksi . '.' . $file->getClientOriginalExtension();
            $file->storeAs('transfer-images', $fileName);
            $validatedData['image_transfer'] = 'transfer-images/' . $fileName;
        }

        $transaksi->update($validatedData);

        return redirect()->route('transaksi.list')->with('success', 'Bukti transfer berhasil dikirim!');
    }

    public function transaksiIndex()
    {
        $transaksis = Transaksi::with(['biodata', 'rekening'])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        $produkAcak = Produk::with('gambarUtama')->inRandomOrder()->limit(10)->get();

        return view('customer.transaksi', compact('transaksis', 'produkAcak'));
    }

    public function transaksiDetail($kode_transaksi)
    {
        $transaksi = Transaksi::with(['details.produk', 'biodata', 'rekening'])
            ->where('kode_transaksi', $kode_transaksi)
            ->firstOrFail();

        $produkAcak = Produk::with('gambarUtama')->inRandomOrder()->limit(10)->get();

        return view('customer.transaksi_detail', compact('transaksi', 'produkAcak'));
    }
}
