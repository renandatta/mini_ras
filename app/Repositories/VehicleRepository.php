<?php

namespace App\Repositories;

use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleRepository extends Repository {

    protected $vehicle;
    public function __construct(Vehicle $vehicle)
    {
        $this->vehicle = $vehicle;
    }

    public function search(Request $request)
    {
        $vehicle = $this->vehicle;
        $vehicle = $this->filter($request, $vehicle, [
            ['value' => 'profile_id']
        ]);
        $paginate = $request->input('paginate') ?? null;
        if ($paginate != null) return $vehicle->paginate($paginate);
        return $vehicle->get();
    }

    public function find($value, $column = 'id')
    {
        return $this->vehicle->where($column, $value)->first();
    }

    public function store(Request $request)
    {
        return $this->vehicle->create($request->all());
    }

    public function update(Request $request, $id)
    {
        $vehicle = $this->vehicle->find($id);
        $vehicle->update($request->all());
        return $vehicle;
    }

    public function save(Request $request)
    {
        $id = $request->input('id') ?? '';
        return $id == '' ? $this->store($request) : $this->update($request, $id);
    }

    public function delete($id)
    {
        $vehicle = $this->vehicle->find($id);
        if (!empty($vehicle)) $vehicle->delete();
        return $vehicle;
    }

}
