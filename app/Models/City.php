<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    public function districts()
    {
        return $this->hasMany(District::class);
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
