<?php

namespace App\Http\Controllers;

use App\Models\DeliveryOrder;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {

    }

    public function index()
    {
        return view('home.index');
    }

    public function track_order(Request $request)
    {
        $request->validate(['no_order' => 'required']);
        $delivery_order = DeliveryOrder::where('no_order', $request->input('no_order'))->first();
        if (empty($delivery_order)) return redirect()->back();
        return view('home.track_order', compact('delivery_order'));
    }
}
