<?php

namespace App\Repositories;

use App\Models\CustomerLocation;
use Illuminate\Http\Request;

class CustomerLocationRepository extends Repository {

    protected $customerLocation;
    public function __construct(CustomerLocation $customerLocation)
    {
        $this->customerLocation = $customerLocation;
    }

    public function search(Request $request)
    {
        $customerLocation = $this->customerLocation;
        $customerLocation = $this->filter($request, $customerLocation, [
            ['value' => 'customer_id']
        ]);
        $paginate = $request->input('paginate') ?? null;
        if ($paginate != null) return $customerLocation->paginate($paginate);
        return $customerLocation->get();
    }

    public function find($value, $column = 'id')
    {
        return $this->customerLocation->where($column, $value)->first();
    }

    public function store(Request $request)
    {
        return $this->customerLocation->create($request->all());
    }

    public function update(Request $request, $id)
    {
        $customerLocation = $this->customerLocation->find($id);
        $customerLocation->update($request->all());
        return $customerLocation;
    }

    public function save(Request $request)
    {
        $id = $request->input('id') ?? '';
        return $id == '' ? $this->store($request) : $this->update($request, $id);
    }

    public function delete($id)
    {
        $customerLocation = $this->customerLocation->find($id);
        if (!empty($customerLocation)) $customerLocation->delete();
        return $customerLocation;
    }

    public function dropdown($customer_id)
    {
        $result = array();
        foreach($this->customerLocation->where('customer_id', $customer_id)->get() as $value)
            $result[$value->id] = $value->name;
        return $result;
    }

}
