<?php

namespace App\Http\Controllers\Shipper;

use App\Http\Controllers\Controller;
use App\Http\Requests\OnlyIdRequest;
use App\Http\Requests\DeliveryOrderItemSaveRequest;
use App\Repositories\DeliveryOrderItemRepository;
use App\Repositories\DeliveryOrderRepository;
use Illuminate\Http\Request;

class DeliveryOrderItemController extends Controller
{
    protected $deliveryOrderItem, $deliveryOrder;
    public function __construct(DeliveryOrderItemRepository $deliveryOrderItem,
                                DeliveryOrderRepository $deliveryOrder)
    {
        $this->middleware(['auth', 'feature']);
        $this->deliveryOrderItem = $deliveryOrderItem;
        $this->deliveryOrder = $deliveryOrder;
    }

    public function info(Request $request)
    {
        return $this->deliveryOrderItem->find($request->input('id'));
    }

    public function search(Request $request)
    {
        $delivery_order = $this->deliveryOrder->find($request->input('delivery_order_id'));
        $items = $this->deliveryOrderItem->search($request);
        return view('shipper.delivery_orders.items._table', compact(
            'items', 'delivery_order'
        ));
    }

}
