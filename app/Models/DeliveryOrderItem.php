<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryOrderItem extends Model
{
    protected $fillable = [
        'delivery_order_id',
        'name',
        'qty',
        'unit',
        'note'
    ];

    public function delivery_order()
    {
        return $this->belongsTo(DeliveryOrder::class);
    }
}
