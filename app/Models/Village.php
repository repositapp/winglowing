<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Village extends Model
{
    use HasFactory;
    protected $fillable = ['city_id', 'district_id', 'name'];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
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
