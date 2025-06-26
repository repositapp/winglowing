<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Biodata>
 */
class BiodataFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => 3,
            'nama_lengkap' => $this->faker->name(),
            'city_id' => 1,
            'district_id' => 1,
            'village_id' => mt_rand(1, 5),
            'alamat' => $this->faker->address(),
            'kode_pos' => '93711',
            'telepon' => $this->faker->phoneNumber(),
        ];
    }
}
