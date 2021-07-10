<?php

namespace App\Http\Controllers\Shipper;

use App\Http\Controllers\Controller;
use App\Http\Requests\IdRequest;
use App\Repositories\CustomerLocationRepository;
use App\Repositories\DeliveryOrderRepository;
use App\Repositories\LocationRepository;
use App\Repositories\ProfileRepository;
use App\Repositories\ShipmentOrderRepository;
use Illuminate\Http\Request;

class DeliveryOrderController extends Controller
{
    protected $shipmentOrder, $profile, $deliveryOrder, $locations, $customerLocation;
    public function __construct(ShipmentOrderRepository $shipmentOrder, ProfileRepository $profile,
                                DeliveryOrderRepository $deliveryOrder, LocationRepository $locations,
                                CustomerLocationRepository $customerLocation)
    {
        $this->middleware(['auth', 'feature']);
        $this->shipmentOrder = $shipmentOrder;
        $this->deliveryOrder = $deliveryOrder;
        $this->locations = $locations;
        $this->customerLocation = $customerLocation;
        view()->share(['list_transporter' => $profile->dropdown()]);
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
        $mode = $request->input('mode');

        $delivery_order = $this->deliveryOrder->find($request->input('id'));
        $shipment_order = $this->shipmentOrder->find($request->input('shipment_order_id', ''));
        if (empty($shipment_order)) $shipment_order = $delivery_order->shipment_order ?? [];
        $no_order = !empty($delivery_order) ? $delivery_order->no_order : $this->deliveryOrder->auto_no($profile_id);
        $items = $shipment_order->items;
        foreach ($items as $value) {
            $value->qty = $value->qty - $this->deliveryOrder->check_qty($shipment_order->id, $value->name);
        }


        $locations = $this->locations->dropdown($profile_id);
        $customer_locations = $this->customerLocation->dropdown($shipment_order->customer_id);

        return view('shipper.delivery_orders._info', compact(
            'delivery_order', 'shipment_order', 'no_order', 'mode',
            'locations', 'customer_locations', 'items'
        ));
    }

    public function save(Request $request)
    {
        $filename = $this->save_file($request, 'delivery_order_attachment');
        if ($filename != '') $request->merge(['finish_attachment' => $filename]);
        return $this->deliveryOrder->save($request);
    }

    public function delete(IdRequest $request)
    {
        return $this->deliveryOrder->delete($request->input('id'));
    }

}
