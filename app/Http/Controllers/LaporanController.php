<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use App\Models\TransaksiDetail;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function productReport(Request $request)
    {
        $search = $request->input('search');

        $products = Produk::with('kategori'); // Load relasi kategori

        if ($search) {
            $products->where(function ($query) use ($search) {
                $query->where('kode_produk', 'like', '%' . $search . '%')
                    ->orWhere('nama_produk', 'like', '%' . $search . '%')
                    ->orWhere('brand', 'like', '%' . $search . '%')
                    ->orWhere('price', 'like', '%' . $search . '%')
                    ->orWhere('cost_price', 'like', '%' . $search . '%')
                    ->orWhere('stock', 'like', '%' . $search . '%')
                    ->orWhereHas('kategori', function ($q) use ($search) {
                        $q->where('name', 'like', '%' . $search . '%'); // Asumsi kolom nama kategori adalah 'name'
                    });
            });
        }

        $products = $products->orderBy('nama_produk')->paginate(10)->appends(['search' => $search]);

        return view('laporan.product_report', compact('products', 'search'));
    }

    public function printProductReport(Request $request)
    {
        $search = $request->input('search');

        $products = Produk::with('kategori');

        if ($search) {
            $products->where(function ($query) use ($search) {
                $query->where('kode_produk', 'like', '%' . $search . '%')
                    ->orWhere('nama_produk', 'like', '%' . $search . '%')
                    ->orWhere('brand', 'like', '%' . $search . '%')
                    ->orWhere('price', 'like', '%' . $search . '%')
                    ->orWhere('cost_price', 'like', '%' . $search . '%')
                    ->orWhere('stock', 'like', '%' . $search . '%')
                    ->orWhereHas('kategori', function ($q) use ($search) {
                        $q->where('name', 'like', '%' . $search . '%');
                    });
            });
        }

        // Ambil semua data tanpa pagination
        $products = $products->orderBy('nama_produk')->get();

        return view('laporan.print.product_print', compact('products', 'search'));
    }

    public function lowStockReport(Request $request)
    {
        $search = $request->input('search');

        $lowStockProducts = Produk::with('kategori')->where('stock', '<', 200);

        if ($search) {
            $lowStockProducts->where(function ($query) use ($search) {
                $query->where('kode_produk', 'like', '%' . $search . '%')
                    ->orWhere('nama_produk', 'like', '%' . $search . '%')
                    ->orWhere('brand', 'like', '%' . $search . '%')
                    ->orWhere('stock', 'like', '%' . $search . '%')
                    ->orWhereHas('kategori', function ($q) use ($search) {
                        $q->where('name', 'like', '%' . $search . '%');
                    });
            });
        }

        $lowStockProducts = $lowStockProducts->orderBy('stock')->paginate(10)->appends(['search' => $search]);

        return view('laporan.low_stock_report', compact('lowStockProducts', 'search'));
    }

    public function printLowStockReport(Request $request)
    {
        $search = $request->input('search');

        $lowStockProducts = Produk::with('kategori')->where('stock', '<', 200);

        if ($search) {
            $lowStockProducts->where(function ($query) use ($search) {
                $query->where('kode_produk', 'like', '%' . $search . '%')
                    ->orWhere('nama_produk', 'like', '%' . $search . '%')
                    ->orWhere('brand', 'like', '%' . $search . '%')
                    ->orWhere('stock', 'like', '%' . $search . '%')
                    ->orWhereHas('kategori', function ($q) use ($search) {
                        $q->where('name', 'like', '%' . $search . '%');
                    });
            });
        }

        $lowStockProducts = $lowStockProducts->orderBy('stock')->get();

        return view('laporan.print.low_stock_report_print', compact('lowStockProducts', 'search'));
    }

    public function salesReport(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = Transaksi::query()->where('status', 'diterima');

        if ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        // --- Perubahan: Tambahkan Paginasi di sini ---
        $sales = $query->with('details.produk', 'user')
            ->orderBy('created_at', 'desc')
            ->paginate(10) // Paginasi 10 item per halaman
            ->appends(['start_date' => $startDate, 'end_date' => $endDate]); // Pertahankan filter tanggal saat paginasi
        // --- Akhir Perubahan ---

        return view('laporan.sales_report', compact('sales', 'startDate', 'endDate'));
    }

    public function printSalesReport(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = Transaksi::query()->where('status', 'diterima');

        if ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        $sales = $query->with('details.produk', 'user')->orderBy('created_at', 'asc')->get();

        return view('laporan.print.sales_print', compact('sales', 'startDate', 'endDate'));
    }

    public function financialReport(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $search = $request->input('search');

        $query = Transaksi::query()->where('status', 'diterima');

        if ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('kode_transaksi', 'like', '%' . $search . '%')
                    ->orWhere('metode_pembayaran', 'like', '%' . $search . '%')
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', '%' . $search . '%');
                    });
            });
        }

        // Get all filtered transactions for total calculations before pagination
        $allFilteredTransactions = clone $query->with('details.produk')->get();

        // Calculate totals based on all filtered transactions
        $totalRevenue = $allFilteredTransactions->sum('grand_total');
        $totalCostOfGoodsSold = 0;
        foreach ($allFilteredTransactions as $transaction) {
            foreach ($transaction->details as $detail) {
                if ($detail->produk) {
                    $totalCostOfGoodsSold += $detail->qty * $detail->produk->cost_price;
                }
            }
        }
        $profit = $totalRevenue - $totalCostOfGoodsSold;

        // Apply pagination for the displayed table
        $transactions = $query->with('details.produk', 'user')->paginate(10)->appends(['start_date' => $startDate, 'end_date' => $endDate, 'search' => $search]);

        return view('laporan.financial_report', compact('transactions', 'totalRevenue', 'totalCostOfGoodsSold', 'profit', 'startDate', 'endDate', 'search'));
    }

    public function printFinancialReport(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $search = $request->input('search');

        $query = Transaksi::query()->where('status', 'diterima');

        if ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('kode_transaksi', 'like', '%' . $search . '%')
                    ->orWhere('metode_pembayaran', 'like', '%' . $search . '%')
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', '%' . $search . '%');
                    });
            });
        }

        $transactions = $query->with('details.produk', 'user')->get();

        $totalRevenue = $transactions->sum('grand_total');
        $totalCostOfGoodsSold = 0;

        foreach ($transactions as $transaction) {
            foreach ($transaction->details as $detail) {
                if ($detail->produk) {
                    $totalCostOfGoodsSold += $detail->qty * $detail->produk->cost_price;
                }
            }
        }

        $profit = $totalRevenue - $totalCostOfGoodsSold;

        return view('laporan.print.financial_print', compact(
            'transactions',
            'totalRevenue',
            'totalCostOfGoodsSold',
            'profit',
            'startDate',
            'endDate',
            'search'
        ));
    }
}
