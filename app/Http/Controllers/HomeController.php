<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\Produk;
use App\Models\TransaksiDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        // Daftar kategori dengan jumlah produk
        $kategoris = Kategori::withCount('produk')->get();

        // Produk acak
        $produkAcak = Produk::with('gambarUtama')->inRandomOrder()->limit(10)->get();

        // Produk diskon (diskon > 0)
        $produkDiskon = Produk::with('gambarUtama')->where('discount', '>', 0)->limit(10)->get();

        // Produk populer berdasarkan jumlah dibeli dari transaksi diterima
        $produkPopuler = Produk::select('produks.id', 'produks.nama_produk', 'produks.kode_produk', 'produks.price', 'produks.discount', 'produks.kategori_id', DB::raw('SUM(transaksi_details.qty) as total_dibeli'))
            ->join('transaksi_details', 'produks.id', '=', 'transaksi_details.produk_id')
            ->join('transaksis', 'transaksi_details.kode_transaksi', '=', 'transaksis.kode_transaksi')
            ->where('transaksis.status', 'diterima')
            ->groupBy('produks.id', 'produks.nama_produk', 'produks.kode_produk', 'produks.price', 'produks.discount', 'produks.kategori_id')
            ->orderByDesc('total_dibeli')
            ->with('gambarUtama')
            ->limit(10)
            ->get();

        return view('customer.beranda', compact('kategoris', 'produkAcak', 'produkDiskon', 'produkPopuler'));
    }
}
