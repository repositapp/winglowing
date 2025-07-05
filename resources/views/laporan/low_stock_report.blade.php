@extends('layouts.master')
@section('title')
    Laporan Stok Menipis
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Laporan
        @endslot
        @slot('li_2')
            Laporan Stok Menipis
        @endslot
        @slot('title')
            Laporan Stok Menipis
        @endslot
    @endcomponent

    <section class="content">
        <div class="box box-success">
            <div class="box-header with-border">
                <div class="row align-items-center">
                    <div class="col-md-6 align-items-center">
                        <form action="{{ route('laporan.low_stock') }}" method="GET">
                            <div class="input-group input-group-sm hidden-xs" style="width: 250px;">
                                <input type="text" name="search" class="form-control pull-right"
                                    placeholder="Cari Produk..." value="{{ request('search') }}">
                                <div class="input-group-btn">
                                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-6 text-right no-print">
                        <a href="{{ route('laporan.low_stock.print', ['search' => request('search')]) }}" target="_blank"
                            class="btn btn-success btn-sm">
                            <i class="fa fa-print"></i> Cetak Laporan
                        </a>
                    </div>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 40px">No.</th>
                                <th>Kode Produk</th>
                                <th>Nama Produk</th>
                                <th>Brand</th>
                                <th>Kategori</th>
                                <th>Stok</th>
                                <th>Harga Jual</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($lowStockProducts as $product)
                                <tr>
                                    <td class="text-center">{{ $lowStockProducts->firstItem() + $loop->index }}</td>
                                    <td>{{ $product->kode_produk }}</td>
                                    <td>{{ $product->nama_produk }}</td>
                                    <td>{{ $product->brand ?? '-' }}</td>
                                    <td>{{ $product->kategori->name ?? 'N/A' }}</td>
                                    <td>{{ $product->stock }}</td>
                                    <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Tidak ada produk dengan stok menipis.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix no-print">
                <div class="row align-items-center">
                    <div class="col-md-6 align-items-center">
                        Menampilkan
                        {{ $lowStockProducts->firstItem() }}
                        hingga
                        {{ $lowStockProducts->lastItem() }}
                        dari
                        {{ $lowStockProducts->total() }} entri
                    </div>
                    <div class="col-md-6">
                        <div class="pull-right">
                            {{ $lowStockProducts->links() }}
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
            .box-footer {
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
