<?php

namespace Database\Factories;

use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaksi>
 */
class TransaksiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Transaksi::class;

    public function definition(): array
    {
        $total = $this->faker->numberBetween(50000, 300000);
        $ongkir = $this->faker->numberBetween(5000, 30000);

        return [
            'kode_transaksi' => 'TRX-' . now()->format('dmy') . '-' . $this->faker->unique()->numerify('####'),
            'user_id' => $this->faker->numberBetween(2, 3),
            'rekening_id' => $this->faker->numberBetween(1, 4),
            'total' => $total,
            'ongkir' => $ongkir,
            'grand_total' => $total + $ongkir,
            'status' => $this->faker->randomElement(['baru', 'packing', 'pengiriman', 'diterima', 'dibatalkan']),
        ];
    }
}
