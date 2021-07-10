<?php

namespace App\Http\Controllers\Shipper;

use App\Http\Controllers\Controller;
use App\Http\Requests\OnlyIdRequest;
use App\Http\Requests\ShipmentOrderItemSaveRequest;
use App\Repositories\ShipmentOrderItemRepository;
use Illuminate\Http\Request;

class ShipmentOrderItemController extends Controller
{
    protected $shipmentOrderItem;
    public function __construct(ShipmentOrderItemRepository $shipmentOrderItem)
    {
        $this->middleware(['auth', 'feature']);
        $this->shipmentOrderItem = $shipmentOrderItem;
    }

    public function info(Request $request)
    {
        return $this->shipmentOrderItem->find($request->input('id'));
    }

    public function search(Request $request)
    {
        $shipment_order_id = $request->input('shipment_order_id');
        $items = $this->shipmentOrderItem->search($request);
        return view('shipper.shipment_orders.items._table', compact('items', 'shipment_order_id'));
    }

    public function save(ShipmentOrderItemSaveRequest $request)
    {
        return $this->shipmentOrderItem->save($request);
    }

    public function delete(OnlyIdRequest $request)
    {
        return $this->shipmentOrderItem->delete($request->input('id'));
    }

}
