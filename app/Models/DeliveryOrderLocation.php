<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryOrderLocation extends Model
{
    protected $fillable = [
        'no_order',
        'delivery_order_id',
        'pickup_location_id',
        'pickup_detail',
        'deliver_location_id',
        'deliver_detail',
        'pickup_date',
        'pickup_time',
        'loading_date',
        'loading_time',
        'arrive_date',
        'arrive_time',
        'unloading_date',
        'unloading_time',
        'file',
        'status'
    ];

    public function delivery_order()
    {
        return $this->belongsTo(DeliveryOrder::class);
    }

    public function pickup_location()
    {
        return $this->belongsTo(Location::class);
    }

    public function deliver_location()
    {
        return $this->belongsTo(Location::class);
    }

    public function getStatusCaptionAttribute()
    {
        if ($this->file != '') return "Closed";
        else if ($this->unloading_time != '') return "Unloading Completed";
        else if ($this->arrive_time != '') return "Arrive at Destination";
        else if ($this->loading_time != '') return "In Transit";
        else if ($this->pickup_time != '') return "Waiting for Pickup";
        return "-";
    }
}
