<?php

namespace App\Repositories;

use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileRepository extends Repository {

    protected $profile;
    public function __construct(Profile $profile)
    {
        $this->profile = $profile;
    }

    public function search(Request $request)
    {
        $profile = $this->profile
            ->with(['users']);
        $paginate = $request->input('paginate') ?? null;
        if ($paginate != null) return $profile->paginate($paginate);
        return $profile->get();
    }

    public function find($value, $column = 'id')
    {
        return $this->profile->where($column, $value)->first();
    }

    public function store(Request $request)
    {
        return $this->profile->create($request->all());
    }

    public function update(Request $request, $id)
    {
        $profile = $this->profile->find($id);
        $profile->update($request->all());
        return $profile;
    }

    public function save(Request $request)
    {
        $id = $request->input('id') ?? '';
        return $id == '' ? $this->store($request) : $this->update($request, $id);
    }

    public function delete($id)
    {
        $profile = $this->profile->find($id);
        if (!empty($profile)) $profile->delete();
        return $profile;
    }

    public function dropdown()
    {
        $result = array();
        foreach ($this->profile->get() as $value)
            $result[$value->id] = $value->name;
        return $result;
    }

}
