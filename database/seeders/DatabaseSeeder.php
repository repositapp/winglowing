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
            'nama_toko' => 'Arumi Galery',
            'telepon' => '0401-221522',
            'email' => 'launawolio@gmail.com',
            'instagram' => '@sentuhan_buton',
            'tiktok' => '@sentuhan_buton',
            'alamat' => 'Jl. Bhakti Abri, Kel. Bukit Wolio Indah, Kec. Wolio, Kota Bau-Bau, Sulawesi Tenggara 93713',
            'maps' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d834.930680904558!2d122.61416022333478!3d-5.474163351408725!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2da4770bb8dc6fc7%3A0x9fdf22ba0c1dcf19!2sArumi%20Galeri!5e0!3m2!1sid!2sid!4v1750669010062!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>',
            'nama_pemilik' => 'Arumi',
            'sidebar_lg' => 'Arumi Galery',
            'sidebar_mini' => 'AG',
            'title_header' => 'Sistem Informasi Penjualan',
            'logo' => 'aplikasi-images/onlineshop.jpg',
        ]);

        Kategori::updateOrCreate([
            'name' => 'Sarung Pria',
            'slug' => 'sarung-pria',
            'image_kategori' => 'kategori-images/default.jpg',
        ]);
        Kategori::updateOrCreate([
            'name' => 'Sarung Wanita',
            'slug' => 'sarung-wanita',
            'image_kategori' => 'kategori-images/default.jpg',
        ]);
        Kategori::updateOrCreate([
            'name' => 'Tas Samping',
            'slug' => 'tas-samping',
            'image_kategori' => 'kategori-images/default.jpg',
        ]);
        Kategori::updateOrCreate([
            'name' => 'Ransel',
            'slug' => 'ransel',
            'image_kategori' => 'kategori-images/default.jpg',
        ]);
        Kategori::updateOrCreate([
            'name' => 'Baju Pria',
            'slug' => 'baju-pria',
            'image_kategori' => 'kategori-images/default.jpg',
        ]);
        Kategori::updateOrCreate([
            'name' => 'Baju Wanita',
            'slug' => 'baju-wanita',
            'image_kategori' => 'kategori-images/default.jpg',
        ]);
        Kategori::updateOrCreate([
            'name' => 'Aksesoris Pria',
            'slug' => 'aksesoris-pria',
            'image_kategori' => 'kategori-images/default.jpg',
        ]);
        Kategori::updateOrCreate([
            'name' => 'Aksesoris Wanita',
            'slug' => 'aksesoris-wanita',
            'image_kategori' => 'kategori-images/default.jpg',
        ]);

        Rekening::updateOrCreate([
            'nama_bank' => 'BRI',
            'rekening' => '1823717238123',
            'pemilik' => 'Arumi Galeri',
            'logo_bank' => 'bank-images/bri.png',
        ]);
        Rekening::updateOrCreate([
            'nama_bank' => 'BCA',
            'rekening' => '1823717238213',
            'pemilik' => 'Arumi Galeri',
            'logo_bank' => 'bank-images/bca.png',
        ]);
        Rekening::updateOrCreate([
            'nama_bank' => 'BSI',
            'rekening' => '3743717238123',
            'pemilik' => 'Arumi Galeri',
            'logo_bank' => 'bank-images/bsi.png',
        ]);
        Rekening::updateOrCreate([
            'nama_bank' => 'Mandiri',
            'rekening' => '1823713288123',
            'pemilik' => 'Arumi Galeri',
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
            'alamat' => 'Jl. Moh. Husni Thamrin, Wale, Kec. Wolio, Kota Bau-Bau',
            'kode_pos' => '93711',
            'telepon' => '081222452210',
        ]);

        Biodata::updateOrCreate([
            'user_id' => 2,
            'nama_lengkap' => 'Marta Andika',
            'city_id' => 1,
            'district_id' => 8,
            'village_id' => 1,
            'alamat' => 'Jl. Moh. Husni Thamrin, Wale, Kec. Wolio, Kota Bau-Bau',
            'kode_pos' => '93711',
            'telepon' => '081222452210',
        ]);

        Biodata::factory(1)->create();

        $this->call(TransaksiSeeder::class);
    }
}
