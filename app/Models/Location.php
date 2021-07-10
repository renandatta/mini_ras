<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = [
        'profile_id',
        'name',
        'code',
        'address',
        'lat',
        'lng',
        'description',
        'city',
        'province',
        'customer_id'
    ];

    public function getCoordinateAttribute()
    {
        return $this->lat . ', ' . $this->lng;
    }
}
