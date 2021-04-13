<?php

namespace App\Http\Controllers;

use App\Http\Requests\IdRequest;
use App\Http\Requests\DeliveryOrderSaveRequest;
use App\Repositories\DeliveryOrderRepository;
use App\Repositories\VehicleRepository;
use Illuminate\Http\Request;

class DeliveryOrderController extends Controller
{
    protected $deliveryOrder;
    public function __construct(DeliveryOrderRepository $deliveryOrder, VehicleRepository $vehicle)
    {
        $this->middleware(['fitur_program']);
        $this->deliveryOrder = $deliveryOrder;
        view()->share(['vehicles' => $vehicle->dropdown()]);
    }

    public function index()
    {
        session(['menu_active' => 'delivery_orders']);
        return view('delivery_orders.index');
    }

    public function search(Request $request)
    {
        $delivery_orders = $this->deliveryOrder->search($request);
        return view('delivery_orders._table', compact('delivery_orders'));
    }

    public function info(Request $request)
    {
        $delivery_order = $this->deliveryOrder->find($request->input('id'));
        return view('delivery_orders._info', compact('delivery_order'));
    }

    public function save(DeliveryOrderSaveRequest $request)
    {
        return $this->deliveryOrder->save($request);
    }

    public function delete(IdRequest $request)
    {
        return $this->deliveryOrder->delete($request->input('id'));
    }
}
