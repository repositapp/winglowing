<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Invoice {{ $transaksi->kode_transaksi }}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ URL::asset('build/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ URL::asset('build/bower_components/font-awesome/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ URL::asset('build/bower_components/Ionicons/css/ionicons.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ URL::asset('build/dist/css/AdminLTE.min.css') }}">

    <!-- Google Font -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body onload="window.print();">
    <div class="wrapper">
        <!-- Main content -->
        <section class="invoice">
            <!-- title row -->
            <div class="row">
                <div class="col-xs-12">
                    <h2 class="page-header">
                        🧾 Invoice
                        <small class="pull-right">Tanggal: {{ $transaksi->created_at->format('d M Y, H:i') }}</small>
                    </h2>
                </div>
                <!-- /.col -->
            </div>
            <!-- info row -->
            <div class="row invoice-info">
                <div class="col-sm-5 invoice-col">
                    Dari
                    <address>
                        <strong>{{ $aplikasi->nama_toko }}</strong><br>
                        {{ $aplikasi->alamat }}<br>
                        Telepon: {{ $aplikasi->telepon }}<br>
                        Email: {{ $aplikasi->email }}
                    </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                    Kepada
                    <address>
                        <strong>{{ $transaksi->biodata->nama_lengkap }}</strong><br>
                        {{ $transaksi->biodata->alamat }}<br>
                        Telepon: {{ $transaksi->biodata->telepon ?? '-' }}<br>
                        Email: {{ $transaksi->biodata->email ?? '-' }}
                    </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-3 invoice-col">
                    <b>Invoice #{{ $transaksi->kode_transaksi }}</b><br><br>
                    <b>Status:</b> {{ ucfirst($transaksi->status) }}<br>
                    <b>Ongkos Kirim:</b> Rp{{ number_format($transaksi->ongkir, 0, ',', '.') }}<br>
                    <b>Total Bayar:</b> Rp{{ number_format($transaksi->grand_total, 0, ',', '.') }}
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <!-- Table row -->
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
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <div class="row">
                <!-- accepted payments column -->
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
                <!-- /.col -->
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
        </section>
    </div>
</body>

</html>
