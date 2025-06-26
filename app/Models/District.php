<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;
    protected $fillable = ['city_id', 'name'];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function villages()
    {
        return $this->hasMany(Village::class);
    }

    public function biodata()
    {
        return $this->hasMany(Biodata::class);
    }

    public function ongkir()
    {
        return $this->hasMany(Ongkir::class);
    }
}
