<?php

namespace App\Http\Controllers;

use App\Repositories\DeliveryOrderRepository;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $deliveryOrder;
    public function __construct(DeliveryOrderRepository $deliveryOrder)
    {
        $this->middleware(['fitur_program']);
        $this->deliveryOrder = $deliveryOrder;
    }

    public function index()
    {
        session(['menu_active' => '/']);
        return view('dashboard.index');
    }

    public function track_order(Request $request)
    {
        $request->validate(['no_order' => 'required']);
        $delivery_order = $this->deliveryOrder->find($request->input('no_order'), 'no_order');
        return view('dashboard._tracking', compact('delivery_order'));
    }
}
