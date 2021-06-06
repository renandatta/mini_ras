<?php

namespace App\Repositories;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationRepository extends Repository {

    protected $location;
    public function __construct(Location $location)
    {
        $this->location = $location;
    }

    public function search(Request $request)
    {
        $location = $this->location;
        $location = $this->filter($request, $location, [
            ['value' => 'profile_id']
        ]);
        $paginate = $request->input('paginate') ?? null;
        if ($paginate != null) return $location->paginate($paginate);
        return $location->get();
    }

    public function find($value, $column = 'id')
    {
        return $this->location->where($column, $value)->first();
    }

    public function store(Request $request)
    {
        return $this->location->create($request->all());
    }

    public function update(Request $request, $id)
    {
        $location = $this->location->find($id);
        $location->update($request->all());
        return $location;
    }

    public function save(Request $request)
    {
        $id = $request->input('id') ?? '';
        return $id == '' ? $this->store($request) : $this->update($request, $id);
    }

    public function delete($id)
    {
        $location = $this->location->find($id);
        if (!empty($location)) $location->delete();
        return $location;
    }

}
