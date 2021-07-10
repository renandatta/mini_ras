<?php

namespace App\Http\Controllers\Shipper;

use App\Http\Controllers\Controller;
use App\Http\Requests\OnlyIdRequest;
use App\Http\Requests\CustomerSaveRequest;
use App\Repositories\CustomerRepository;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    protected $customer;
    public function __construct(CustomerRepository $customer)
    {
        $this->middleware(['auth', 'feature', 'profile']);
        $this->customer = $customer;
    }

    public function index()
    {
        session(['menu_active' => 'shipper.customers']);
        return view('shipper.customers.index');
    }

    public function search(Request $request)
    {
        $customers = $this->customer->search($request);
        return view('shipper.customers._table', compact('customers'));
    }

    public function info(Request $request)
    {
        $customer = $this->customer->find($request->input('id'));
        return view('shipper.customers._info', compact('customer'));
    }

    public function save(CustomerSaveRequest $request)
    {
        return $this->customer->save($request);
    }

    public function delete(OnlyIdRequest $request)
    {
        $customer = $this->customer->delete($request->input('id'));
        $this->delete_file($customer->photo);
        return $customer;
    }
}
