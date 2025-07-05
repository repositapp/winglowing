<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Penjualan</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            font-size: 11px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h4 {
            text-align: center;
            margin: 0;
        }

        .header p {
            margin: 5px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .total-row {
            font-weight: bold;
            background-color: #e0e0e0;
        }

        .no-print {
            text-align: center;
            margin-top: 30px;
        }

        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="header">
        <h4>Laporan Penjualan Winglowing</h4>
        <p>Periode:
            @if ($startDate && $endDate)
                {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} -
                {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}
            @else
                Semua Periode
            @endif
        </p>
        <p>Dicetak pada: {{ \Carbon\Carbon::now()->format('d M Y H:i:s') }}</p>
    </div>

    @if ($sales->isEmpty())
        <p class="text-center">Tidak ada data penjualan dalam periode ini.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
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
                    $totalOverallSales = 0; // Ini akan menghitung total semua data di laporan cetak
                @endphp
                @foreach ($sales as $transaction)
                    @php
                        $firstDetail = true;
                        $totalOverallSales += $transaction->grand_total;
                    @endphp
                    @foreach ($transaction->details as $detail)
                        <tr>
                            @if ($firstDetail)
                                {{-- Nomor urut di halaman cetak akan terus berlanjut --}}
                                <td rowspan="{{ $transaction->details->count() }}">
                                    {{ $loop->parent->iteration }}</td>
                                <td rowspan="{{ $transaction->details->count() }}">
                                    {{ $transaction->kode_transaksi }}</td>
                                <td rowspan="{{ $transaction->details->count() }}">
                                    {{ \Carbon\Carbon::parse($transaction->created_at)->format('d M Y H:i') }}</td>
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
                <tr class="total-row">
                    <td colspan="9" class="text-right">Total Keseluruhan Penjualan:</td>
                    <td>Rp {{ number_format($totalOverallSales, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>
    @endif

    <script>
        window.onload = function() {
            const beforePrint = () => {};
            const afterPrint = () => {
                window.close(); // Tutup tab setelah selesai (jika cetak atau batal)
            };

            if (window.matchMedia) {
                const mediaQueryList = window.matchMedia('print');

                mediaQueryList.addListener(function(mql) {
                    if (!mql.matches) {
                        afterPrint();
                    }
                });
            }

            window.onafterprint = afterPrint;
            window.print();
        };
    </script>
</body>

</html>
