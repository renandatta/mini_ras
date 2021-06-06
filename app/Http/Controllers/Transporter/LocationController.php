<?php

namespace App\Http\Controllers\Transporter;

use App\Http\Controllers\Controller;
use App\Http\Requests\OnlyIdRequest;
use App\Http\Requests\LocationSaveRequest;
use App\Repositories\LocationRepository;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    protected $location;
    public function __construct(LocationRepository $location)
    {
        $this->middleware(['auth', 'feature', 'profile']);
        $this->location = $location;
    }

    public function index()
    {
        session(['menu_active' => 'admin.locations']);
        return view('transporter.locations.index');
    }

    public function search(Request $request)
    {
        $locations = $this->location->search($request);
        return view('transporter.locations._table', compact('locations'));
    }

    public function info(Request $request)
    {
        $location = $this->location->find($request->input('id'));
        return view('transporter.locations._info', compact('location'));
    }

    public function save(LocationSaveRequest $request)
    {
        return $this->location->save($request);
    }

    public function delete(OnlyIdRequest $request)
    {
        return $this->location->delete($request->input('id'));
    }
}
