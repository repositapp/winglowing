<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'produk_id',
        'qty',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }

    // Ambil hanya 1 gambar (gambar utama)
    public function gambarUtama()
    {
        return $this->hasOne(ProdukGambar::class, 'kode_produk', 'kode_produk')->oldest(); // ambil gambar pertama
    }
}
