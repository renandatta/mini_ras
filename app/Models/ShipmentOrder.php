<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShipmentOrder extends Model
{
    const STATUS = array(
        'Order In Progress', 'Loading Completed', 'Arrive at Destination', 'Unloading Completed', 'Closed'
    );
    protected $fillable = [
        'customer_id',
        'shipper_id',
        'no_order',
        'date',
        'description',
        'status'
    ];

    public function items()
    {
        return $this->hasMany(ShipmentOrderItem::class, 'shipment_order_id', 'id');
    }

    public function shipper()
    {
        return $this->belongsTo(Profile::class, 'shipper_id', 'id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }
}
