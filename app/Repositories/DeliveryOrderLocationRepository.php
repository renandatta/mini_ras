<?php

namespace App\Repositories;

use App\Models\DeliveryOrderLocation;
use Illuminate\Http\Request;

class DeliveryOrderLocationRepository extends Repository {

    protected $deliveryOrderLocation;
    public function __construct(DeliveryOrderLocation $deliveryOrderLocation)
    {
        $this->deliveryOrderLocation = $deliveryOrderLocation;
    }

    public function shipment_order_item($shipment_order_id, $name)
    {
        return $this->deliveryOrderLocation
            ->whereHas('delivery_order', function ($delivery) use ($shipment_order_id) {
                $delivery->where('shipment_order_id', $shipment_order_id);
            })
            ->where('name', $name)
            ->first();
    }

    public function delivery_order_item($delivery_order_id, $name)
    {
        return $this->deliveryOrderLocation
            ->where('delivery_order_id', $delivery_order_id)
            ->where('name', $name)
            ->first();
    }

    public function search(Request $request)
    {
        $deliveryOrderLocation = $this->deliveryOrderLocation;
        $deliveryOrderLocation = $this->filter($request, $deliveryOrderLocation, [
            ['value' => 'delivery_order_id']
        ]);
        $paginate = $request->input('paginate');
        if ($paginate !== null) return $deliveryOrderLocation->paginate($paginate);
        return $deliveryOrderLocation->get();
    }

    public function save(Request $request, $delivery_order_id)
    {
        $pickup_location_id = $request->input('pickup_location_id');
        $pickup_detail = $request->input('pickup_detail');
        $deliver_location_id = $request->input('deliver_location_id');
        $deliver_detail = $request->input('deliver_detail');
        foreach ($pickup_location_id as $key => $pickup_id) {
            $this->deliveryOrderLocation->updateOrCreate([
                'delivery_order_id' => $delivery_order_id,
            ], [
                'no_order' => $request->input('no_order') . '-' . ($key+1),
                'pickup_location_id' => $pickup_id,
                'pickup_detail' => $pickup_detail[$key],
                'deliver_location_id' => $deliver_location_id[$key],
                'deliver_detail' => $deliver_detail[$key],
                'pickup_date' => $request->input('pickup_date'),
                'pickup_time' => $request->input('pickup_time'),
                'status' => 'Waiting for Pickup'
            ]);
        }
    }

}
