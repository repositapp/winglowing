@extends('layouts.master')
@section('title')
    Laporan
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Laporan
        @endslot
        @slot('li_2')
            Laporan
        @endslot
        @slot('title')
            Laporan
        @endslot
    @endcomponent

    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">Jenis Laporan</h3>
                    </div>
                    <div class="box-body">
                        <ul class="list-group">
                            <li class="list-group-item"><a href="{{ route('laporan.products') }}">Laporan Produk</a>
                            </li>
                            <li class="list-group-item"><a href="{{ route('laporan.low_stock') }}">Laporan Stok
                                    Menipis (< 20)</a>
                            </li>
                            <li class="list-group-item"><a href="{{ route('laporan.sales') }}">Laporan Penjualan</a>
                            </li>
                            <li class="list-group-item"><a href="{{ route('laporan.financial') }}">Laporan
                                    Keuangan</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
