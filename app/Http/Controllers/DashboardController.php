<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $totalPendapatan = Transaksi::where('status', 'diterima')->sum('grand_total');

        $totalProduk = Produk::count();

        $stokBerkurang = Produk::where('stock', '<', 20)->count();

        $totalPenjualan = Transaksi::where('status', 'diterima')->count();

        $pesananBaru = Transaksi::where('status', 'baru')->count();
        $pesananProses = Transaksi::where('status', 'packing')->count();
        $pesananPengiriman = Transaksi::where('status', 'pengiriman')->count();
        $pesananSelesai = Transaksi::where('status', 'diterima')->count();

        return view('dashboard.index', compact('totalPendapatan', 'totalProduk', 'stokBerkurang', 'totalPenjualan', 'pesananBaru', 'pesananProses', 'pesananPengiriman', 'pesananSelesai'));
    }
}
