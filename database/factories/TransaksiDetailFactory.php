<?php

namespace Database\Factories;

use App\Models\Transaksi;
use App\Models\Produk;
use App\Models\TransaksiDetail;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TransaksiDetail>
 */
class TransaksiDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = TransaksiDetail::class;

    public function definition(): array
    {
        $produk = Produk::inRandomOrder()->first() ?? Produk::factory()->create();
        $qty = $this->faker->numberBetween(1, 5);

        $hargaDiskon = $produk->price - ($produk->price * $produk->diskon / 100);
        $subtotal = $hargaDiskon * $qty;

        return [
            'kode_transaksi' => Transaksi::inRandomOrder()->first()->kode_transaksi ?? Transaksi::factory(),
            'produk_id' => $produk->id,
            'qty' => $qty,
            'subtotal' => $subtotal,
        ];
    }
}
