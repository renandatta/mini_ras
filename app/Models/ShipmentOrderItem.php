<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShipmentOrderItem extends Model
{
    protected $fillable = [
        'shipment_order_id',
        'name',
        'qty',
        'unit',
        'description'
    ];

    public function shipment_order()
    {
        return $this->belongsTo(ShipmentOrder::class);
    }
}
