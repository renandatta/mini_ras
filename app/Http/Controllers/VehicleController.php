<?php

namespace App\Http\Controllers;

use App\Http\Requests\IdRequest;
use App\Http\Requests\VehicleSaveRequest;
use App\Repositories\ProfileRepository;
use App\Repositories\VehicleRepository;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    protected $vehicle;
    public function __construct(VehicleRepository $vehicle, ProfileRepository $profile)
    {
        $this->middleware(['fitur_program']);
        $this->vehicle = $vehicle;
        view()->share(['profiles' => $profile->dropdown()]);
    }

    public function index()
    {
        session(['menu_active' => 'vehicles']);
        return view('vehicles.index');
    }

    public function search(Request $request)
    {
        $vehicles = $this->vehicle->search($request);
        return view('vehicles._table', compact('vehicles'));
    }

    public function info(Request $request)
    {
        $vehicle = $this->vehicle->find($request->input('id'));
        return view('vehicles._info', compact('vehicle'));
    }

    public function save(VehicleSaveRequest $request)
    {
        return $this->vehicle->save($request);
    }

    public function delete(IdRequest $request)
    {
        return $this->vehicle->delete($request->input('id'));
    }
}
