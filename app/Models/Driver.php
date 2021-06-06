<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    protected $fillable = [
        'profile_id',
        'name',
        'no_id',
        'address',
        'phone',
        'photo',
        'tracking_url',
    ];

    public function getPhotoFileAttribute()
    {
        if ($this->photo == '') return asset('images/default.png');
        return asset('assets/' . $this->photo);
    }
}
