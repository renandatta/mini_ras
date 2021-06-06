<?php

namespace App\Http\Controllers\Transporter;

use App\Http\Controllers\Controller;
use App\Http\Requests\OnlyIdRequest;
use App\Http\Requests\DriverSaveRequest;
use App\Repositories\DriverRepository;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    protected $driver;
    public function __construct(DriverRepository $driver)
    {
        $this->middleware(['auth', 'feature', 'profile']);
        $this->driver = $driver;
    }

    public function index()
    {
        session(['menu_active' => 'transporter.drivers']);
        return view('transporter.drivers.index');
    }

    public function search(Request $request)
    {
        $drivers = $this->driver->search($request);
        return view('transporter.drivers._table', compact('drivers'));
    }

    public function info(Request $request)
    {
        $driver = $this->driver->find($request->input('id'));
        return view('transporter.drivers._info', compact('driver'));
    }

    public function save(DriverSaveRequest $request)
    {
        $filename = $this->save_file($request, 'photo_driver');
        if ($filename != '') $request->merge(['photo' => $filename]);
        return $this->driver->save($request);
    }

    public function delete(OnlyIdRequest $request)
    {
        $driver = $this->driver->delete($request->input('id'));
        $this->delete_file($driver->photo);
        return $driver;
    }
}
