<?php

namespace App\Repositories;

use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleRepository
{
    protected $vehicle;
    public function __construct(Vehicle $vehicle)
    {
        $this->vehicle = $vehicle;
    }

    public function search(Request $request)
    {
        $vehicle = $this->vehicle
            ->with(['profile'])
            ->orderBy('code');

        $profile_id = $request->input('profile_id') ?? '';
        if ($profile_id != '') $vehicle = $vehicle->where('profile_id', $profile_id);

        $paginate = $request->input('paginate') ?? null;
        if ($paginate != null) return $vehicle->paginate($paginate);
        return $vehicle->get();
    }

    public function find($value, $column = 'id')
    {
        return $this->vehicle->where($column, $value)->first();
    }

    public function save(Request $request)
    {
        $vehicle = $this->vehicle->find($request->input('id'));
        if (empty($vehicle)) $vehicle = $this->vehicle->create($request->all());
        else $vehicle->update($request->all());
        return $vehicle;
    }

    public function delete($id)
    {
        $vehicle = $this->vehicle->find($id);
        if (!empty($vehicle)) $vehicle->delete();
        return $vehicle;
    }

    public function dropdown()
    {
        $result = array();
        foreach ($this->vehicle->orderBy('code')->get() as $value)
            $result[$value->id] = $value->name;
        return $result;
    }
}
