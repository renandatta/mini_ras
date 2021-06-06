<?php

namespace App\Repositories;

use App\Models\UserRole;
use Illuminate\Http\Request;

class UserRoleRepository extends Repository {

    protected $userRole, $credential;
    public function __construct(UserRole $userRole)
    {
        $this->userRole = $userRole;

    }

    public function search(Request $request)
    {
        $userRole = $this->userRole;
        $paginate = $request->input('paginate') ?? null;
        if ($paginate != null) return $userRole->paginate($paginate);
        return $userRole->get();
    }

    public function find($value, $column = 'id')
    {
        return $this->userRole->where($column, $value)->first();
    }

    public function store(Request $request)
    {
        return $this->userRole->create($request->all());
    }

    public function update(Request $request, $id)
    {
        $userRole = $this->userRole->find($id);
        $userRole->update($request->all());
        return $userRole;
    }

    public function save(Request $request)
    {
        $id = $request->input('id') ?? '';
        return $id == '' ? $this->store($request) : $this->update($request, $id);
    }

    public function delete($id)
    {
        $userRole = $this->userRole->find($id);
        if (!empty($userRole)) $userRole->delete();
        return $userRole;
    }

    public function dropdown()
    {
        $result = array();
        foreach ($this->userRole->get() as $value) $result[$value->id] = $value->name;
        return $result;
    }

}
