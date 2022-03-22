<?php

namespace App\Http\Controllers\Shipper;

use App\Http\Controllers\Controller;
use App\Repositories\DeliveryOrderLocationRepository;
use App\Repositories\DeliveryOrderRepository;
use Illuminate\Http\Request;

class DeliveryOrderTimelineController extends Controller
{
    protected $deliveryOrderLocation, $deliveryOrder;
    public function __construct(DeliveryOrderLocationRepository $deliveryOrderLocation,
                                DeliveryOrderRepository $deliveryOrder)
    {
        $this->middleware(['auth', 'feature']);
        $this->deliveryOrderLocation = $deliveryOrderLocation;
        $this->deliveryOrder = $deliveryOrder;
    }

    public function info(Request $request)
    {
        return $this->deliveryOrderItem->find($request->input('id'));
    }

    public function search(Request $request)
    {
        $delivery_order = $this->deliveryOrder->find($request->input('delivery_order_id'));
        $locations = $this->deliveryOrderLocation->search($request);
        return view('shipper.delivery_orders.timelines._table', compact(
            'locations', 'delivery_order'
        ));
    }

}
