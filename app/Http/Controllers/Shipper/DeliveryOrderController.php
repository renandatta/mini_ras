<?php

namespace App\Http\Controllers\Shipper;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeliveryOrderSaveRequest;
use App\Http\Requests\IdRequest;
use App\Repositories\CustomerRepository;
use App\Repositories\DeliveryOrderItemRepository;
use App\Repositories\DeliveryOrderLocationRepository;
use App\Repositories\DeliveryOrderRepository;
use App\Repositories\LocationRepository;
use App\Repositories\ProfileRepository;
use App\Repositories\ShipmentOrderRepository;
use Illuminate\Http\Request;

class DeliveryOrderController extends Controller
{
    protected $shipmentOrder, $profile, $deliveryOrder, $locations, $deliveryOrderItem, $deliveryOrderLocation;
    public function __construct(ShipmentOrderRepository $shipmentOrder,
                                ProfileRepository $profile,
                                DeliveryOrderRepository $deliveryOrder,
                                LocationRepository $locations,
                                CustomerRepository $customer,
                                DeliveryOrderItemRepository $deliveryOrderItem,
                                DeliveryOrderLocationRepository $deliveryOrderLocation)
    {
        $this->middleware(['auth', 'feature']);
        $this->shipmentOrder = $shipmentOrder;
        $this->deliveryOrder = $deliveryOrder;
        $this->locations = $locations;
        $this->deliveryOrderItem = $deliveryOrderItem;
        $this->deliveryOrderLocation = $deliveryOrderLocation;
        view()->share(['list_transporter' => $profile->dropdown()]);
        view()->share(['list_customer' => $customer->dropdown()]);
        view()->share(['list_status' => $deliveryOrder->list_status()]);
    }

    public function index(Request $request)
    {
        $shipment_order = $this->shipmentOrder->find($request->input('shipment_order_id', ''));
        return view('shipper.delivery_orders.index', compact('shipment_order'));
    }

    public function search(Request $request)
    {
        $delivery_orders = $this->deliveryOrder->search($request);
        return view('shipper.delivery_orders._table', compact('delivery_orders'));
    }

    public function info(Request $request)
    {
        $profile_id = auth()->user()->profile_id;

        $delivery_order = $this->deliveryOrder->find($request->input('id'));
        $shipment_order = $this->shipmentOrder->find($request->input('shipment_order_id', ''));
        if (empty($shipment_order)) $shipment_order = $delivery_order->shipment_order ?? [];
        $no_order = !empty($delivery_order) ? $delivery_order->no_order : $this->deliveryOrder->auto_no($profile_id);
        $items = $shipment_order->items;

        foreach ($items as $value) {
            if (empty($delivery_order))
                $value->qty -=
                    ($this->deliveryOrderItem->shipment_order_item($shipment_order->id, $value->name)->qty ?? 0);
            else
                $value->qty =
                    ($this->deliveryOrderItem->delivery_order_item($delivery_order->id, $value->name)->qty ?? 0);
        }
        $locations = $this->locations->dropdown($profile_id);
        return view('shipper.delivery_orders._info', compact(
            'delivery_order', 'shipment_order', 'no_order', 'locations', 'items'
        ));
    }

    public function save(DeliveryOrderSaveRequest $request)
    {
        $delivery_order = $this->deliveryOrder->save($request);
        $this->deliveryOrderItem->save($request, $delivery_order->id);
        $this->deliveryOrderLocation->save($request, $delivery_order->id);
        return $delivery_order;
    }

    public function delete(IdRequest $request)
    {
        return $this->deliveryOrder->delete($request->input('id'));
    }

}
