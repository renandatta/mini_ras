<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerLocation extends Model
{
    protected $fillable = [
        'customer_id',
        'name',
        'address',
        'lat',
        'lng',
        'description',
        'city',
        'province',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function getCoordinateAttribute()
    {
        return $this->lat . ', ' . $this->lng;
    }
}
