<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerProfile extends Model
{
    protected $fillable = [
        'profile_id',
        'customer_id'
    ];

    public function customer()
    {
        return $this->belongsTo(Profile::class, 'customer_id', 'id');
    }
}
