<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = [
        'profile_id',
        'name',
        'code',
        'addess',
        'lat',
        'lng',
        'description'
    ];
}
