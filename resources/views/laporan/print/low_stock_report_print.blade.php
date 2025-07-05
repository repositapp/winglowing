<!DOCTYPE html>
<html>

<head>
    <title>Laporan Stok Rendah</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
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
            font-size: 12px;
        }

        th {
            background-color: #f2f2f2;
        }

        @media print {
            table {
                width: 100%;
                border-collapse: collapse;
            }

            th,
            td {
                border: 1px solid #000;
                padding: 6px;
                font-size: 11px;
            }

            body {
                font-family: Arial, sans-serif;
            }

            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>
    <h2 style="text-align:center;">Laporan Produk Stok Rendah</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Produk</th>
                <th>Nama Produk</th>
                <th>Brand</th>
                <th>Kategori</th>
                <th>Stok</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($lowStockProducts as $index => $product)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $product->kode_produk }}</td>
                    <td>{{ $product->nama_produk }}</td>
                    <td>{{ $product->brand ?? '-' }}</td>
                    <td>{{ $product->kategori->name ?? '-' }}</td>
                    <td>{{ $product->stock }}</td>
                </tr>
            @endforeach
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
