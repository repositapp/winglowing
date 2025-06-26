<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'rekening_id',
        'metode_pembayaran',
        'kode_transaksi',
        'total',
        'ongkir',
        'grand_total',
        'status',
        'image_transfer'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function rekening()
    {
        return $this->belongsTo(Rekening::class);
    }

    public function biodata()
    {
        return $this->belongsTo(Biodata::class, 'user_id', 'user_id');
    }

    public function details()
    {
        return $this->hasMany(TransaksiDetail::class, 'kode_transaksi', 'kode_transaksi');
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($transaksi) {
            $tanggal = now()->format('dmy');
            // Cek jumlah transaksi keseluruhan
            $count = Transaksi::count() + 1;

            $kodeUrut = str_pad($count, 4, '0', STR_PAD_LEFT); // jadikan 00001, 00002, dst
            $transaksi->kode_transaksi = 'TRX-' . $tanggal . '-' .  $kodeUrut;
        });
    }
}
