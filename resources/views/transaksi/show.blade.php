@extends('layouts.master')
@section('title')
    Detail Transaksi
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Transaksi
        @endslot
        @slot('li_2')
            Detail Transaksi
        @endslot
        @slot('title')
            Detail Transaksi
        @endslot
    @endcomponent

    <section class="invoice">
        <div class="row">
            <div class="col-xs-12">
                <h2 class="page-header">
                    <a href="{{ url()->previous() }}" class="btn btn-social btn-sm btn-default">
                        <i class="fa fa-reply"></i> Kembali
                    </a>
                    <i class="fa fa-credit-card"></i> Invoice
                    <small class="pull-right">Tanggal: {{ $transaksi->created_at->format('d M Y, H:i') }}</small>

                </h2>
            </div>
        </div>

        <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">
                Dari
                <address>
                    <strong>{{ $aplikasi->nama_toko }}</strong><br>
                    {{ $aplikasi->alamat }}<br>
                    Telepon: {{ $aplikasi->telepon }}<br>
                    Email: {{ $aplikasi->email }}
                </address>
            </div>
            <div class="col-sm-5 invoice-col">
                Kepada
                <address>
                    <strong>{{ $transaksi->biodata->nama_lengkap }}</strong><br>
                    {{ $transaksi->biodata->alamat }}<br>
                    Telepon: {{ $transaksi->biodata->telepon ?? '-' }}<br>
                    Email: {{ $transaksi->biodata->email ?? '-' }}
                </address>
            </div>
            <div class="col-sm-3 invoice-col">
                <b>Invoice #{{ $transaksi->kode_transaksi }}</b><br><br>
                <b>Status:</b> {{ ucfirst($transaksi->status) }}<br>
                <b>Ongkos Kirim:</b> Rp{{ number_format($transaksi->ongkir, 0, ',', '.') }}<br>
                <b>Total Bayar:</b> Rp{{ number_format($transaksi->grand_total, 0, ',', '.') }}
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Produk</th>
                            <th>Diskon</th>
                            <th>Qty</th>
                            <th>Harga</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transaksi->details as $index => $detail)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $detail->produk->nama_produk }}</td>
                                <td>{{ $detail->produk->discount }}%</td>
                                <td>{{ $detail->qty }}</td>
                                <td>Rp{{ number_format($detail->produk->price, 0, ',', '.') }}</td>
                                <td>Rp{{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row">
            <!-- Metode dan Rekening -->
            <div class="col-xs-6">
                <p class="lead">Metode Pembayaran:</p>
                <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                    Transfer Bank
                </p>

                @if ($transaksi->rekening)
                    <strong>Bank Tujuan:</strong><br>
                    <p class="text-muted well well-sm no-shadow">
                        {{ $transaksi->rekening->nama_bank }}<br>
                        No. Rekening: {{ $transaksi->rekening->rekening }}<br>
                        Atas Nama: {{ $transaksi->rekening->pemilik }}
                    </p>
                @endif
            </div>

            <!-- Ringkasan -->
            <div class="col-xs-6">
                <p class="lead">Ringkasan Pembayaran</p>
                <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <th style="width:50%">Total Produk:</th>
                            <td>Rp{{ number_format($transaksi->total, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Ongkos Kirim:</th>
                            <td>Rp{{ number_format($transaksi->ongkir, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Total Bayar:</th>
                            <td>Rp{{ number_format($transaksi->grand_total, 0, ',', '.') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <a href="{{ route('transaksi.invoice', $transaksi->kode_transaksi) }}" target="_blank"
            class="btn btn-social btn-sm btn-default">
            <i class="fa fa-print"></i> Cetak Invoice
        </a>
    </section>
@endsection
