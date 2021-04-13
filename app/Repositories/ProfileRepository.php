<?php

namespace App\Repositories;

use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileRepository
{
    protected $profile;
    public function __construct(Profile $profile)
    {
        $this->profile = $profile;
    }

    public function search(Request $request)
    {
        $profiles = $this->profile
            ->orderBy('name');

        $paginate = $request->input('paginate') ?? null;
        if ($paginate != null) return $profiles->paginate($paginate);
        return $profiles->get();
    }

    public function find($value, $column = 'id')
    {
        return $this->profile->where($column, $value)->first();
    }

    public function save(Request $request)
    {
        $profile = $this->profile->find($request->input('id'));
        if (empty($profile)) $profile = $this->profile->create($request->all());
        else $profile->update($request->all());
        return $profile;
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
        foreach ($this->profile->orderBy('name')->get() as $value)
            $result[$value->id] = $value->name;
        return $result;
    }
}
