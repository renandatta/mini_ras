<?php

namespace App\Repositories;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerRepository extends Repository {

    protected $customer;
    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    public function search(Request $request)
    {
        $customer = $this->customer;
        $customer = $this->filter($request, $customer, [
            ['value' => 'name']
        ]);
        $paginate = $request->input('paginate') ?? null;
        if ($paginate != null) return $customer->paginate($paginate);
        return $customer->get();
    }

    public function find($value, $column = 'id')
    {
        return $this->customer->where($column, $value)->first();
    }

    public function store(Request $request)
    {
        return $this->customer->create($request->all());
    }

    public function update(Request $request, $id)
    {
        $customer = $this->customer->find($id);
        $customer->update($request->all());
        return $customer;
    }

    public function save(Request $request)
    {
        $id = $request->input('id') ?? '';
        return $id == '' ? $this->store($request) : $this->update($request, $id);
    }

    public function delete($id)
    {
        $customer = $this->customer->find($id);
        if (!empty($customer)) $customer->delete();
        return $customer;
    }

    public function dropdown()
    {
        $result = array();
        foreach ($this->customer->get() as $value)
            $result[$value->id] = $value->name;
        return $result;
    }

}
