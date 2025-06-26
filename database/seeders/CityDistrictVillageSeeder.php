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
        $faker = Faker::create('id_ID');

        // Buat kota Baubau
        $baubau = City::firstOrCreate(['name' => 'Baubau']);

        // Daftar kecamatan Baubau
        $kecamatans = [
            'Betoambari',
            'Murhum',
            'Batupoaro',
            'Kokalukuna',
            'Bungi',
            'Lea-Lea',
            'Sorawolio',
            'Wolio'
        ];

        foreach ($kecamatans as $kecamatan) {
            $district = District::create([
                'city_id' => $baubau->id,
                'name' => $kecamatan
            ]);

            // Buat kelurahan secara acak untuk tiap kecamatan
            for ($i = 0; $i < 5; $i++) {
                Village::create([
                    'city_id' => $baubau->id,
                    'district_id' => $district->id,
                    'name' => $faker->unique()->streetName
                ]);
            }
        }

        $this->command->info('✅ Kota, Kecamatan, dan Kelurahan Baubau berhasil dibuat!');
    }
}
