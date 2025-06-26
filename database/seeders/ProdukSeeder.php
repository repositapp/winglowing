<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
use App\Models\Produk;
use App\Models\ProdukGambar;
use App\Models\Kategori;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // pastikan ada kategori terlebih dahulu
        $kategoriIds = Kategori::pluck('id')->toArray();
        if (empty($kategoriIds)) {
            $this->command->info('Kategori belum tersedia. Silakan buat kategori dulu.');
            return;
        }

        for ($i = 1; $i <= 100; $i++) {
            $kode = 'PRD-' . now()->format('dmy') . '-' . str_pad($i, 4, '0', STR_PAD_LEFT);

            $produk = Produk::create([
                'kategori_id' => $faker->randomElement($kategoriIds),
                'kode_produk' => $kode,
                'nama_produk' => $faker->words(3, true),
                // 'brand' => $faker->company,
                'brand' => 'Arumi Galeri',
                'price' => $faker->numberBetween(57000, 650000),
                'cost_price' => $faker->numberBetween(50000, 640000),
                'stock' => $faker->numberBetween(30, 100),
                'description' => $faker->paragraph(10),
                'discount' => $faker->randomElement([0, 5, 10, 15, 20]),
            ]);

            // Simulasikan upload beberapa gambar
            // for ($j = 1; $j <= rand(1, 3); $j++) {
            //     $fakeImage = $faker->image(storage_path('app/public/produk-images'), 640, 480, null, false);

            // }
            ProdukGambar::create([
                'kode_produk' => $produk->kode_produk,
                'gambar' => 'produk-images/default.jpg'
            ]);
        }

        $this->command->info('✔️  100 Produk beserta gambarnya berhasil dibuat.');
    }
}
