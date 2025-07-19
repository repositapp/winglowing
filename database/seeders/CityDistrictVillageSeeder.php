<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;
use App\Models\District;
use App\Models\Village;
use Faker\Factory as Faker;

class CityDistrictVillageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat kota Baubau
        $baubau = City::firstOrCreate(['name' => 'Baubau']);

        // Daftar kecamatan beserta kelurahannya
        $data = [
            'Batupoaro' => ['Bonebone', 'Kaobula', 'Lanto', 'Nganganaumala', 'Tarafu', 'Wameo'],
            'Betoambari' => ['Katobengke', 'Labalawa', 'Lipu', 'Sulaa', 'Waborobo'],
            'Bungi' => ['Kampeonaho', 'Liabuku', 'Ngkari-Ngkari', 'Tampuna', 'Waliabuku'],
            'Kokalukuna' => ['Kadolo', 'Kadolomoko', 'Lakologou', 'Liwuto', 'Sukanaeyo', 'Waruruma'],
            'Lea-Lea' => ['Kalia-Lia', 'Kantalai', 'Kolese', 'Lowu-Lowu', 'Palabusa'],
            'Murhum' => ['Baadia', 'Lamangga', 'Melai', 'Tanganapada', 'Wajo'],
            'Sorawolio' => ['Bugi', 'Gonda Baru', 'Kaisabu Baru', 'Karya Baru'],
            'Wolio' => ['Bataraguru', 'Batulo', 'Bukit Wolio Indah', 'Kadolokatapi', 'Tomba', 'Wale', 'Wangkanapi']
        ];

        foreach ($data as $kecamatan => $kelurahans) {
            $district = District::create([
                'city_id' => $baubau->id,
                'name' => $kecamatan
            ]);

            foreach ($kelurahans as $kelurahan) {
                Village::create([
                    'city_id' => $baubau->id,
                    'district_id' => $district->id,
                    'name' => $kelurahan
                ]);
            }
        }

        $this->command->info('✅ Data Kota Baubau beserta Kecamatan dan Kelurahan berhasil dibuat!');
    }
}
