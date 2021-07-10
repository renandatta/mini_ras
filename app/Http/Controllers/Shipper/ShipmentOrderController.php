<?php

namespace App\Http\Controllers\Shipper;

use App\Http\Controllers\Controller;
use App\Http\Requests\OnlyIdRequest;
use App\Http\Requests\ShipmentOrderSaveRequest;
use App\Repositories\CustomerRepository;
use App\Repositories\ProfileRepository;
use App\Repositories\ShipmentOrderRepository;
use Illuminate\Http\Request;

class ShipmentOrderController extends Controller
{
    protected $shipmentOrder, $profile, $customer;
    public function __construct(ShipmentOrderRepository $shipmentOrder,
                                ProfileRepository $profile,
                                CustomerRepository $customer)
    {
        $this->middleware(['auth', 'feature']);
        $this->shipmentOrder = $shipmentOrder;
        $this->profile = $profile;
        view()->share(['list_customer' => $customer->dropdown()]);
        view()->share(['list_status' => $shipmentOrder->list_status()]);
    }

    public function index()
    {
        return view('shipper.shipment_orders.index');
    }

    public function search(Request $request)
    {
        $request->merge(['shipper_id' => auth()->user()->profile_id]);
        $shipment_orders = $this->shipmentOrder->search($request);
        return view('shipper.shipment_orders._table', compact('shipment_orders'));
    }

    public function info(Request $request)
    {
        $profile_id = auth()->user()->profile_id;
        $list_shipper = $this->profile->dropdown();
        $shipment_order = $this->shipmentOrder->find($request->input('id', ''));
        $no_order = !empty($shipment_order) ? $shipment_order->no_order : $this->shipmentOrder->auto_no($profile_id);
        return view('shipper.shipment_orders._info', compact(
            'shipment_order', 'list_shipper', 'no_order'
        ));
    }

    public function save(ShipmentOrderSaveRequest $request)
    {
        $request->merge(['shipper_id' => auth()->user()->profile_id]);
        return $this->shipmentOrder->save($request);
    }

    public function delete(OnlyIdRequest $request)
    {
        return $this->shipmentOrder->delete($request->input('id'));
    }

}
