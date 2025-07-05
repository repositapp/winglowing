@extends('layouts.master')
@section('title')
    Dashboard
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Dashboard
        @endslot
        @slot('li_2')
            Halaman Utama
        @endslot
        @slot('title')
            Dashboard
        @endslot
    @endcomponent

    <section class="content">
        <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-aqua"><i class="fa fa-money"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Pendapatan</span>
                        <span class="info-box-number">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-green"><i class="fa fa-cubes"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Data Produk</span>
                        <span class="info-box-number">{{ number_format($totalProduk, 0, ',', '.') }}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-red"><i class="fa fa-caret-square-o-down"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Data Stok Berkurang</span>
                        <span class="info-box-number">{{ number_format($stokBerkurang, 0, ',', '.') }}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-yellow"><i class="fa fa-random"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Data Penjualan</span>
                        <span class="info-box-number">{{ number_format($totalPenjualan, 0, ',', '.') }}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
        </div>

        <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-aqua"><i class="fa fa-shopping-cart"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Pesanan Baru</span>
                        <span class="info-box-number">{{ number_format($pesananBaru, 0, ',', '.') }}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-green"><i class="fa fa-dropbox"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Pesanan Proses</span>
                        <span class="info-box-number">{{ number_format($pesananProses, 0, ',', '.') }}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-red"><i class="fa fa-truck"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Pesanan Pengiriman</span>
                        <span class="info-box-number">{{ number_format($pesananPengiriman, 0, ',', '.') }}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-yellow"><i class="fa fa-check-square-o"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Pesanan Selesai</span>
                        <span class="info-box-number">{{ number_format($pesananSelesai, 0, ',', '.') }}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
        </div>

        <div class="callout callout-success">
            <h4>Selamat Datang <span class="text-green">{{ Auth::user()->name }}</span></h4>

            <p>Anda Sedang Mengakses Sistem Informasi Penjualan Arumi Galery.
                Anda Login
                Sebagai <span class="badge bg-green"><i class="fa fa-user" style="margin-right: 5px;"></i>
                    {{ Auth::user()->role }} </span></p>
        </div>
    </section>
@endsection
