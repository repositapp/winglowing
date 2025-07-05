<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Aplikasi;
use App\Models\Biodata;
use App\Models\Kategori;
use App\Models\Rekening;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate([
            'name' => 'Administrator',
            'username' => 'admin',
            'email' => 'admin@themesbrand.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'),
            'avatar' => 'users-images/1J7iwiUja9gMqtHL7eIzR6RbaH0rrzZ5buklDQLy.png',
            'role' => 'admin',
            'status' => '1',
            'created_at' => now(),
        ]);

        User::updateOrCreate([
            'name' => 'Marta Andika',
            'username' => 'users',
            'email' => 'user@themesbrand.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'),
            'avatar' => 'users-images/1J7iwiUja9gMqtHL7eIzR6RbaH0rrzZ5buklDQLy.png',
            'role' => 'user',
            'status' => '1',
            'created_at' => now(),
        ]);

        Aplikasi::updateOrCreate([
            'nama_toko' => 'Win Glowing',
            'telepon' => '085827894096',
            'email' => 'win.glowing@gmail.com',
            'instagram' => '@win.glowing',
            'tiktok' => '@win.glowing',
            'alamat' => 'Jl. Sultan Jl. Dayanu Ikhsanudin No.19, Katobengke, Kec. Betoambari, Kota Bau-Bau, Sulawesi Tenggara 93724',
            'maps' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d510.99555313015713!2d122.58137885511219!3d-5.479276799877992!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2da4718720b8a115%3A0xad6b94a44840a278!2sWin.Glowing!5e0!3m2!1sid!2sid!4v1751629922615!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>',
            'nama_pemilik' => 'Edwin',
            'sidebar_lg' => 'Win Glowing',
            'sidebar_mini' => 'WG',
            'title_header' => 'Sistem Informasi Penjualan',
            'logo' => 'aplikasi-images/onlineshop.jpg',
        ]);

        Kategori::updateOrCreate([
            'name' => 'Cleanser',
            'slug' => 'cleanser',
            'image_kategori' => 'kategori-images/default.jpg',
        ]);
        Kategori::updateOrCreate([
            'name' => 'Toner',
            'slug' => 'toner',
            'image_kategori' => 'kategori-images/default.jpg',
        ]);
        Kategori::updateOrCreate([
            'name' => 'Moisturizer',
            'slug' => 'moisturizer',
            'image_kategori' => 'kategori-images/default.jpg',
        ]);
        Kategori::updateOrCreate([
            'name' => 'Serum',
            'slug' => 'serum',
            'image_kategori' => 'kategori-images/default.jpg',
        ]);
        Kategori::updateOrCreate([
            'name' => 'Sunscreen',
            'slug' => 'sunscreen',
            'image_kategori' => 'kategori-images/default.jpg',
        ]);
        Kategori::updateOrCreate([
            'name' => 'Masker Wajah',
            'slug' => 'masker-wajah',
            'image_kategori' => 'kategori-images/default.jpg',
        ]);
        Kategori::updateOrCreate([
            'name' => 'Krim Mata',
            'slug' => 'krim-mata',
            'image_kategori' => 'kategori-images/default.jpg',
        ]);
        Kategori::updateOrCreate([
            'name' => 'Eksfoliator Wajah',
            'slug' => 'eksfoliator-wajah',
            'image_kategori' => 'kategori-images/default.jpg',
        ]);
        Kategori::updateOrCreate([
            'name' => 'Perawatan Tubuh',
            'slug' => 'perawatan-tubuh',
            'image_kategori' => 'kategori-images/default.jpg',
        ]);

        Rekening::updateOrCreate([
            'nama_bank' => 'BRI',
            'rekening' => '1823717238123',
            'pemilik' => 'Win Glowing',
            'logo_bank' => 'bank-images/bri.png',
        ]);
        Rekening::updateOrCreate([
            'nama_bank' => 'BCA',
            'rekening' => '1823717238213',
            'pemilik' => 'Win Glowing',
            'logo_bank' => 'bank-images/bca.png',
        ]);
        Rekening::updateOrCreate([
            'nama_bank' => 'BSI',
            'rekening' => '3743717238123',
            'pemilik' => 'Win Glowing',
            'logo_bank' => 'bank-images/bsi.png',
        ]);
        Rekening::updateOrCreate([
            'nama_bank' => 'Mandiri',
            'rekening' => '1823713288123',
            'pemilik' => 'Win Glowing',
            'logo_bank' => 'bank-images/mandiri.webp',
        ]);

        $this->call([
            ProdukSeeder::class,
            CityDistrictVillageSeeder::class,
            OngkirSeeder::class,
        ]);

        User::factory(1)->create();

        Biodata::updateOrCreate([
            'user_id' => 1,
            'nama_lengkap' => 'Administrator',
            'city_id' => 1,
            'district_id' => 8,
            'village_id' => 1,
            'alamat' => 'Jl. Sultan Jl. Dayanu Ikhsanudin No.19, Katobengke, Kec. Betoambari, Kota Bau-Bau',
            'kode_pos' => '93711',
            'telepon' => '081222452210',
        ]);

        Biodata::updateOrCreate([
            'user_id' => 2,
            'nama_lengkap' => 'Marta Andika',
            'city_id' => 1,
            'district_id' => 8,
            'village_id' => 1,
            'alamat' => 'Jl. Sultan Jl. Dayanu Ikhsanudin No.19, Katobengke, Kec. Betoambari, Kota Bau-Bau',
            'kode_pos' => '93711',
            'telepon' => '081222452210',
        ]);

        Biodata::factory(1)->create();

        $this->call(TransaksiSeeder::class);
    }
}
