<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;
    protected $fillable = [
        'profile_id',
        'code',
        'name',
        'tracking_url'
    ];

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }
}
