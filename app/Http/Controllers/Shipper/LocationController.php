<?php

namespace App\Http\Controllers\Shipper;

use App\Http\Controllers\Controller;
use App\Http\Requests\OnlyIdRequest;
use App\Http\Requests\LocationSaveRequest;
use App\Repositories\CustomerRepository;
use App\Repositories\LocationRepository;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    protected $location;
    public function __construct(LocationRepository $location, CustomerRepository $customer)
    {
        $this->middleware(['auth', 'feature', 'profile']);
        $this->location = $location;
        view()->share(['customer' => $customer->dropdown()]);
    }

    public function index()
    {
        session(['menu_active' => 'admin.locations']);
        return view('shipper.locations.index');
    }

    public function search(Request $request)
    {
        $request->merge(['profile_id' => auth()->user()->profile_id]);
        $locations = $this->location->search($request);
        return view('shipper.locations._table', compact('locations'));
    }

    public function info(Request $request)
    {
        $location = $this->location->find($request->input('id'));
        return view('shipper.locations._info', compact('location'));
    }

    public function save(LocationSaveRequest $request)
    {
        $request->merge(['profile_id' => auth()->user()->profile_id]);
        return $this->location->save($request);
    }

    public function delete(OnlyIdRequest $request)
    {
        return $this->location->delete($request->input('id'));
    }
}
