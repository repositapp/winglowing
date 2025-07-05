@extends('layouts.master')
@section('title')
    Laporan Penjualan
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Laporan
        @endslot
        @slot('li_2')
            Laporan Penjualan
        @endslot
        @slot('title')
            Laporan Penjualan
        @endslot
    @endcomponent
    <section class="content">
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Filter Laporan Penjualan Berdasarkan Periode</h3>
            </div>
            <form action="{{ route('laporan.sales') }}" method="GET">
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
                            <div class="form-group" style="margin-top: 25px;">
                                <button type="submit" class="btn btn-success"><i class="fa fa-filter"></i> Filter</button>
                                @if ($startDate && $endDate)
                                    {{-- Tombol cetak mengarahkan ke rute print dengan parameter --}}
                                    <a href="{{ route('laporan.sales.print', ['start_date' => $startDate, 'end_date' => $endDate]) }}"
                                        target="_blank" class="btn btn-success no-print"><i class="fa fa-print"></i>
                                        Cetak</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Detail Penjualan @if ($startDate && $endDate)
                        ({{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} -
                        {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }})
                    @endif
                </h3>
            </div>
            <div class="box-body no-padding"> {{-- Tambahkan no-padding karena kita tidak pakai DataTables --}}
                @if ($sales->isEmpty())
                    <p class="text-center">Tidak ada data penjualan dalam periode ini.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 40px">No.</th>
                                    <th>Kode Transaksi</th>
                                    <th>Tanggal</th>
                                    <th>Pelanggan</th>
                                    <th>Metode Pembayaran</th>
                                    <th>Produk</th>
                                    <th>Qty</th>
                                    <th>Subtotal Produk</th>
                                    <th>Ongkir</th>
                                    <th>Grand Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    // Total penjualan hanya untuk halaman yang sedang aktif
                                    $totalOverallSalesOnPage = 0;
                                @endphp
                                @foreach ($sales as $transaction)
                                    @php
                                        $firstDetail = true;
                                        $totalOverallSalesOnPage += $transaction->grand_total;
                                    @endphp
                                    @foreach ($transaction->details as $detail)
                                        <tr>
                                            @if ($firstDetail)
                                                <td rowspan="{{ $transaction->details->count() }}" class="text-center">
                                                    {{ $sales->firstItem() + $loop->parent->index }}</td>
                                                <td rowspan="{{ $transaction->details->count() }}">
                                                    {{ $transaction->kode_transaksi }}</td>
                                                <td rowspan="{{ $transaction->details->count() }}">
                                                    {{ \Carbon\Carbon::parse($transaction->created_at)->format('d M Y H:i') }}
                                                </td>
                                                <td rowspan="{{ $transaction->details->count() }}">
                                                    {{ $transaction->user->name ?? 'N/A' }}</td>
                                                <td rowspan="{{ $transaction->details->count() }}">
                                                    {{ ucfirst($transaction->metode_pembayaran) }}</td>
                                                @php $firstDetail = false; @endphp
                                            @endif
                                            <td>{{ $detail->produk->nama_produk ?? 'Produk Dihapus' }}</td>
                                            <td>{{ $detail->qty }}</td>
                                            <td>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                                            @if ($loop->first)
                                                <td rowspan="{{ $transaction->details->count() }}">Rp
                                                    {{ number_format($transaction->ongkir, 0, ',', '.') }}</td>
                                                <td rowspan="{{ $transaction->details->count() }}">Rp
                                                    {{ number_format($transaction->grand_total, 0, ',', '.') }}</td>
                                            @endif
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="9" class="text-right">Total Penjualan (Halaman Ini):</th>
                                    <th>Rp {{ number_format($totalOverallSalesOnPage, 0, ',', '.') }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                @endif
            </div>
            <div class="box-footer clearfix no-print"> {{-- Tambahkan class no-print di sini --}}
                <div class="row align-items-center">
                    <div class="col-md-6 align-items-center">
                        Menampilkan
                        {{ $sales->firstItem() }}
                        hingga
                        {{ $sales->lastItem() }}
                        dari
                        {{ $sales->total() }} entri
                    </div>
                    <div class="col-md-6">
                        <div class="pull-right">
                            {{ $sales->links() }} {{-- Tampilkan tautan paginasi --}}
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

            footer {
                display: none !important;
            }
        }
    </style>
@endpush
