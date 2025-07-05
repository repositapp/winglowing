<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Keuangan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
        }

        h2,
        h4 {
            text-align: center;
            margin: 0;
        }

        .summary {
            margin: 15px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }

        ul {
            margin: 0;
            padding-left: 15px;
        }
    </style>
</head>

<body>
    <h2>Laporan Keuangan</h2>
    <p style="text-align: center;">
        Periode:
        @empty($startDate)
            Semua Pendapatan
        @else
            {{ $startDate ? \Carbon\Carbon::parse($startDate)->format('d-m-Y') : '-' }}
            s/d
            {{ $endDate ? \Carbon\Carbon::parse($endDate)->format('d-m-Y') : '-' }}
        @endempty
    </p>

    <div class="summary">
        <h4>Total Pendapatan: Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h4>
        <h4>Total Biaya Produk (HPP): Rp {{ number_format($totalCostOfGoodsSold, 0, ',', '.') }}</h4>
        <h4>Keuntungan Bersih: Rp {{ number_format($profit, 0, ',', '.') }}</h4>
    </div>

    <h4 style="text-align: left;">Detail Transaksi</h4>

    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Tanggal</th>
                <th>Kode Transaksi</th>
                <th>Pelanggan</th>
                <th>Metode</th>
                <th>Total</th>
                <th>Ongkir</th>
                <th>Produk</th>
                <th>HPP Transaksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($transactions as $index => $trx)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($trx->created_at)->format('d-m-Y H:i') }}</td>
                    <td>{{ $trx->kode_transaksi }}</td>
                    <td>{{ $trx->user->name ?? '-' }}</td>
                    <td>{{ ucfirst($trx->metode_pembayaran) }}</td>
                    <td>Rp {{ number_format($trx->grand_total, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($trx->ongkir, 0, ',', '.') }}</td>
                    <td>
                        <ul>
                            @foreach ($trx->details as $detail)
                                <li>{{ $detail->produk->nama_produk ?? 'Produk Dihapus' }}
                                    ({{ $detail->qty }} pcs)
                                    - Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                                </li>
                            @endforeach
                        </ul>
                    </td>
                    <td>
                        @php
                            $transactionCost = 0;
                            foreach ($trx->details as $detail) {
                                if ($detail->produk) {
                                    $transactionCost += $detail->qty * $detail->produk->cost_price;
                                }
                            }
                        @endphp
                        Rp {{ number_format($transactionCost, 0, ',', '.') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" style="text-align:center;">Tidak ada transaksi ditemukan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

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
