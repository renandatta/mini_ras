<?php

namespace App\Repositories;

use App\Models\Driver;
use Illuminate\Http\Request;

class DriverRepository extends Repository {

    protected $driver;
    public function __construct(Driver $driver)
    {
        $this->driver = $driver;
    }

    public function search(Request $request)
    {
        $driver = $this->driver;
        $driver = $this->filter($request, $driver, [
            ['value' => 'profile_id']
        ]);
        $paginate = $request->input('paginate') ?? null;
        if ($paginate != null) return $driver->paginate($paginate);
        return $driver->get();
    }

    public function find($value, $column = 'id')
    {
        return $this->driver->where($column, $value)->first();
    }

    public function store(Request $request)
    {
        return $this->driver->create($request->all());
    }

    public function update(Request $request, $id)
    {
        $driver = $this->driver->find($id);
        $driver->update($request->all());
        return $driver;
    }

    public function save(Request $request)
    {
        $id = $request->input('id') ?? '';
        return $id == '' ? $this->store($request) : $this->update($request, $id);
    }

    public function delete($id)
    {
        $driver = $this->driver->find($id);
        if (!empty($driver)) $driver->delete();
        return $driver;
    }

}
