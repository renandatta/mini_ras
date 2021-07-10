<?php

namespace App\Http\Controllers\Transporter;

use App\Http\Controllers\Controller;
use App\Http\Requests\IdRequest;
use App\Repositories\DeliveryOrderRepository;
use App\Repositories\ProfileRepository;
use App\Repositories\ShipmentOrderRepository;
use Illuminate\Http\Request;

class DeliveryOrderController extends Controller
{
    protected $shipmentOrder, $profile, $deliveryOrder;
    public function __construct(ShipmentOrderRepository $shipmentOrder, ProfileRepository $profile,
                                DeliveryOrderRepository $deliveryOrder)
    {
        $this->middleware(['auth', 'feature']);
        $this->shipmentOrder = $shipmentOrder;
        $this->deliveryOrder = $deliveryOrder;
        view()->share(['list_transporter' => $profile->dropdown()]);
    }

    public function index()
    {
        return view('transporter.delivery_orders.index');
    }

    public function search(Request $request)
    {
        $request->merge(['transporter_id' => auth()->user()->profile_id]);
        $delivery_orders = $this->deliveryOrder->search($request);
        return view('transporter.delivery_orders._table', compact('delivery_orders'));
    }

    public function save(Request $request)
    {
        $filename = $this->save_file($request, 'delivery_order_attachment');
        if ($filename != '') $request->merge(['finish_attachment' => $filename]);
        return $this->deliveryOrder->save($request);
    }

    public function info(IdRequest $request)
    {
        $mode = $request->input('mode');
        $delivery_order = $this->deliveryOrder->find($request->input('id'));
        return view('transporter.delivery_orders._info', compact('delivery_order', 'mode'));
    }

}
