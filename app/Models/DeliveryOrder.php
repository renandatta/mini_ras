<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryOrder extends Model
{
    protected $fillable = [
        'shipment_order_id',
        'transporter_id',
        'vehicle_id',
        'no_order',
        'date',
        'date_eta',
        'date_pickup',
        'time_pickup',
        'date_loading',
        'time_loading',
        'note_loading',
        'date_arrive',
        'time_arrive',
        'note_arrive',
        'pickup_location_id',
        'deliver_location_id',
        'status',
        'description',
        'name',
        'qty',
        'unit',
        'date_unloading',
        'time_unloading',
        'note_unloading',
        'finish_attachment',
    ];

    public function shipment_order()
    {
        return $this->belongsTo(ShipmentOrder::class);
    }

    public function transporter()
    {
        return $this->belongsTo(Profile::class, 'transporter_id', 'id');
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function pickup_location()
    {
        return $this->belongsTo(Location::class, 'pickup_location_id', 'id');
    }

    public function deliver_location()
    {
        return $this->belongsTo(CustomerLocation::class, 'deliver_location_id', 'id');
    }
}
