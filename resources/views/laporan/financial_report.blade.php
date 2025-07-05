@extends('layouts.master')
@section('title')
    Laporan Keuangan
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Laporan
        @endslot
        @slot('li_2')
            Laporan Keuangan
        @endslot
        @slot('title')
            Laporan Keuangan
        @endslot
    @endcomponent

    <section class="content">
        <div class="box box-success no-print">
            <div class="box-header with-border">
                <h3 class="box-title">Filter Laporan Keuangan Berdasarkan Periode dan Pencarian</h3>
            </div>
            <form action="{{ route('laporan.financial') }}" method="GET">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="start_date">Tanggal Mulai:</label>
                                <input type="date" name="start_date" id="start_date" class="form-control"
                                    value="{{ $startDate }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="end_date">Tanggal Akhir:</label>
                                <input type="date" name="end_date" id="end_date" class="form-control"
                                    value="{{ $endDate }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="search">Cari Transaksi:</label>
                                <div class="input-group input-group-sm">
                                    <input type="text" name="search" class="form-control pull-right"
                                        placeholder="Cari Kode Transaksi, Pelanggan, Metode..."
                                        value="{{ request('search') }}">
                                    <div class="input-group-btn">
                                        <button type="submit" class="btn btn-success"><i class="fa fa-filter"></i>
                                            Filter</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Ringkasan Keuangan @if ($startDate && $endDate)
                        ({{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} -
                        {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }})
                    @endif
                </h3>
                <div class="box-tools pull-right no-print">
                    <a href="{{ route('laporan.financial.print', [
                        'start_date' => request('start_date'),
                        'end_date' => request('end_date'),
                        'search' => request('search'),
                    ]) }}"
                        target="_blank" class="btn btn-success btn-sm">
                        <i class="fa fa-print"></i> Cetak Laporan
                    </a>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="info-box bg-green">
                            <span class="info-box-icon"><i class="fa fa-dollar"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Total Pendapatan (Penjualan Diterima)</span>
                                <span class="info-box-number">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="info-box bg-red">
                            <span class="info-box-icon"><i class="fa fa-shopping-cart"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Total Biaya Produk (HPP)</span>
                                <span class="info-box-number">Rp
                                    {{ number_format($totalCostOfGoodsSold, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="info-box bg-blue">
                            <span class="info-box-icon"><i class="fa fa-money"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Keuntungan Bersih (Gross Profit)</span>
                                <span class="info-box-number">Rp {{ number_format($profit, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <h4>Detail Transaksi Diterima</h4>
                @if ($transactions->isEmpty())
                    <p class="text-center">Tidak ada transaksi yang diterima dalam periode ini.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 40px">No.</th>
                                    <th>Kode Transaksi</th>
                                    <th>Tanggal</th>
                                    <th>Pelanggan</th>
                                    <th>Metode Pembayaran</th>
                                    <th>Grand Total</th>
                                    <th>Ongkir</th>
                                    <th>Produk Terjual</th>
                                    <th>Total Modal Produk</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transactions as $transaction)
                                    <tr>
                                        <td class="text-center">{{ $transactions->firstItem() + $loop->index }}</td>
                                        <td>{{ $transaction->kode_transaksi }}</td>
                                        <td>{{ \Carbon\Carbon::parse($transaction->created_at)->format('d M Y H:i') }}</td>
                                        <td>{{ $transaction->user->name ?? 'N/A' }}</td>
                                        <td>{{ ucfirst($transaction->metode_pembayaran) }}</td>
                                        <td>Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}</td>
                                        <td>Rp {{ number_format($transaction->ongkir, 0, ',', '.') }}</td>
                                        <td>
                                            <ul>
                                                @foreach ($transaction->details as $detail)
                                                    <li>{{ $detail->produk->nama_produk ?? 'Produk Dihapus' }}
                                                        ({{ $detail->qty }} pcs)
                                                        - Rp
                                                        {{ number_format($detail->subtotal, 0, ',', '.') }}</li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td>
                                            @php
                                                $transactionCost = 0;
                                                foreach ($transaction->details as $detail) {
                                                    if ($detail->produk) {
                                                        $transactionCost += $detail->qty * $detail->produk->cost_price;
                                                    }
                                                }
                                            @endphp
                                            Rp {{ number_format($transactionCost, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix no-print">
                <div class="row align-items-center">
                    <div class="col-md-6 align-items-center">
                        Menampilkan
                        {{ $transactions->firstItem() }}
                        hingga
                        {{ $transactions->lastItem() }}
                        dari
                        {{ $transactions->total() }} entri
                    </div>
                    <div class="col-md-6">
                        <div class="pull-right">
                            {{ $transactions->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('css')
    <style>
        @media print {

            .main-header,
            .main-sidebar,
            .left-side,
            .control-sidebar,
            .btn,
            .no-print,
            .box-footer,
            .form-group {
                display: none !important;
            }

            .content-wrapper,
            .wrapper {
                margin-left: 0 !important;
                padding-top: 0 !important;
            }

            .content {
                padding: 0 !important;
            }

            .box-header {
                border-bottom: none;
                padding-bottom: 0;
            }

            table {
                width: 100%;
                border-collapse: collapse;
            }

            th,
            td {
                border: 1px solid #000 !important;
                padding: 8px;
                font-size: 10px;
            }

            h1 {
                text-align: center;
                margin-top: 0;
                margin-bottom: 20px;
            }

            .box-title {
                display: none;
            }

            .info-box {
                border: 1px solid #ccc;
                margin-bottom: 15px;
                padding: 10px;
                background-color: #f9f9f9;
            }

            .info-box-text {
                font-size: 12px;
            }

            .info-box-number {
                font-size: 16px;
                font-weight: bold;
            }

            .no-print {
                display: none;
            }

            footer {
                display: none !important;
            }
        }
    </style>
@endpush
