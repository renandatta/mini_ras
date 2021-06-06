<?php

namespace App\Http\Controllers\Transporter;

use App\Http\Controllers\Controller;
use App\Http\Requests\OnlyIdRequest;
use App\Http\Requests\VehicleSaveRequest;
use App\Repositories\VehicleRepository;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    protected $vehicle;
    public function __construct(VehicleRepository $vehicle)
    {
        $this->middleware(['auth', 'feature', 'profile']);
        $this->vehicle = $vehicle;
    }

    public function index()
    {
        session(['menu_active' => 'transporter.vehicles']);
        return view('transporter.vehicles.index');
    }

    public function search(Request $request)
    {
        $vehicles = $this->vehicle->search($request);
        return view('transporter.vehicles._table', compact('vehicles'));
    }

    public function info(Request $request)
    {
        $vehicle = $this->vehicle->find($request->input('id'));
        return view('transporter.vehicles._info', compact('vehicle'));
    }

    public function save(VehicleSaveRequest $request)
    {
        return $this->vehicle->save($request);
    }

    public function delete(OnlyIdRequest $request)
    {
        return $this->vehicle->delete($request->input('id'));
    }
}
