<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    protected $fillable = [
        'name',
        'description',
        'feature_id'
    ];

    public function feature()
    {
        return $this->belongsTo(Feature::class);
    }
}
