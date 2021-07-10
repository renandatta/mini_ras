<?php

namespace App\Http\Controllers\Shipper;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerLocationSaveRequest;
use App\Http\Requests\OnlyIdRequest;
use App\Repositories\CustomerLocationRepository;
use App\Repositories\CustomerRepository;
use Illuminate\Http\Request;

class CustomerLocationController extends Controller
{
    protected $customerLocation, $customer;
    public function __construct(CustomerLocationRepository $customerLocation, CustomerRepository $customer)
    {
        $this->middleware(['auth', 'feature', 'profile']);
        $this->customerLocation = $customerLocation;
        $this->customer = $customer;
    }

    public function index($customer_id)
    {
        session(['menu_active' => 'shipper.customer_location']);
        $customer = $this->customer->find($customer_id);
        return view('shipper.customers.locations.index', compact('customer', 'customer_id'));
    }

    public function search(Request $request, $customer_id)
    {
        $request->merge(['customer_id' => $customer_id]);
        $customer_locations = $this->customerLocation->search($request);
        return view('shipper.customers.locations._table', compact('customer_locations'));
    }

    public function info(Request $request, $customer_id)
    {
        $customer_location = $this->customerLocation->find($request->input('id'));
        return view('shipper.customers.locations._info', compact('customer_location', 'customer_id'));
    }

    public function save(CustomerLocationSaveRequest $request, $customer_id)
    {
        $request->merge(['customer_id' => $customer_id]);
        return $this->customerLocation->save($request);
    }

    public function delete(OnlyIdRequest $request)
    {
        $customer_location = $this->customerLocation->delete($request->input('id'));
        $this->delete_file($customer_location->photo);
        return $customer_location;
    }
}
