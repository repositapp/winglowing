<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;

class TransaksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat 20 transaksi
        Transaksi::factory()->count(100)->create()->each(function ($transaksi) {
            // Untuk setiap transaksi, buat 1–4 detail produk
            $jumlah_detail = rand(1, 4);

            for ($i = 0; $i < $jumlah_detail; $i++) {
                TransaksiDetail::factory()->create([
                    'kode_transaksi' => $transaksi->kode_transaksi,
                ]);
            }

            // Hitung ulang total & grand total
            $total = $transaksi->details->sum('subtotal');
            $transaksi->update([
                'total' => $total,
                'grand_total' => $total + $transaksi->ongkir,
            ]);
        });
    }
}
