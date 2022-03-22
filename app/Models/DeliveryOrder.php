<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryOrder extends Model
{
    const STATUS = array(
        'Ready to Ship', 'In Transit', 'Arrive at Destination', 'Unloading Completed', 'Closed'
    );
    protected $fillable = [
        'shipment_order_id',
        'transporter_id',
        'no_order',
        'date',
        'description',
        'is_confirmed'
    ];

    public function shipment_order()
    {
        return $this->belongsTo(ShipmentOrder::class);
    }

    public function transporter()
    {
        return $this->belongsTo(Profile::class, 'transporter_id', 'id');
    }

    public function items()
    {
        return $this->hasMany(DeliveryOrderItem::class);
    }

    public function locations()
    {
        return $this->hasMany(DeliveryOrderLocation::class);
    }

    public function location()
    {
        return $this->hasOne(DeliveryOrderLocation::class);
    }

    public function current_location()
    {
        return $this->hasOne(DeliveryOrderLocation::class)
            ->where('status', '<>', 'Closed')
            ->orderBy('no_order');
    }

    public function getStatusAttribute()
    {
        if ($this->is_confirmed !== 1) {
            if ($this->is_confirmed === null) return "Waiting Confirmation";
            else return "Transporter Rejected";
        } else return $this->current_location->status_caption ?? '-';
    }

}
