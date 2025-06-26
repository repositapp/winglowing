<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;
use App\Models\District;
use App\Models\Village;
use App\Models\Ongkir;
use Faker\Factory as Faker;

class OngkirSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        $villages = Village::with('city', 'district')->get();

        foreach ($villages as $village) {
            Ongkir::create([
                'city_id' => $village->city_id,
                'district_id' => $village->district_id,
                'village_id' => $village->id,
                'biaya' => $faker->numberBetween(5000, 30000), // harga random Rp5.000 - Rp30.000
            ]);
        }

        $this->command->info('✅ Data ongkir berhasil dibuat untuk semua kelurahan!');
    }
}
