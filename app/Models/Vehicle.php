<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed code
 * @property mixed name
 */
class Vehicle extends Model
{
    use HasFactory;
    protected $fillable = [
        'profile_id',
        'code',
        'name',
        'tracking_url',
        'no_license',
        'data_license_expired',
        'no_registration',
        'date_tax_expired',
    ];

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    public function getNameCompleteAttribute()
    {
        return $this->code . ' | ' . $this->name;
    }
}
