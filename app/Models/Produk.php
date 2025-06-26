<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $fillable = [
        'kategori_id',
        'kode_produk',
        'nama_produk',
        'brand',
        'price',
        'cost_price',
        'stock',
        'description',
        'discount'
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class);
    }

    public function gambar()
    {
        return $this->hasMany(ProdukGambar::class, 'kode_produk', 'kode_produk');
    }

    // Ambil hanya 1 gambar (gambar utama)
    public function gambarUtama()
    {
        return $this->hasOne(ProdukGambar::class, 'kode_produk', 'kode_produk')->oldest(); // ambil gambar pertama
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($produk) {
            $tanggal = now()->format('dmy');
            // Cek jumlah produk keseluruhan
            $count = Produk::count() + 1;

            $kodeUrut = str_pad($count, 4, '0', STR_PAD_LEFT); // jadikan 00001, 00002, dst
            $produk->kode_produk = 'PRD-' . $tanggal . '-' .  $kodeUrut;
        });
    }

    public function keranjang()
    {
        return $this->hasMany(Keranjang::class);
    }

    public function getHargaDiskonAttribute()
    {
        if ($this->diskon) {
            return $this->price - ($this->price * $this->diskon / 100);
        }
        return $this->price;
    }
}
