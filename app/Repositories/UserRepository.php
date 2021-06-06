<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Http\Request;

class UserRepository extends Repository {

    protected $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function search(Request $request)
    {
        $user = $this->user->with(['user_role']);
        $paginate = $request->input('paginate') ?? null;
        if ($paginate != null) return $user->paginate($paginate);
        return $user->get();
    }

    public function find($value, $column = 'id')
    {
        return $this->user->where($column, $value)->first();
    }

    public function store(Request $request)
    {
        return $this->user->create($request->all());
    }

    public function update(Request $request, $id)
    {
        $user = $this->user->find($id);
        $user->update($request->all());
        return $user;
    }

    public function save(Request $request)
    {
        $id = $request->input('id') ?? '';
        if ($request->input('password') !== '')
            $request->merge(['password' => bcrypt($request->input('password'))]);
        return $id == '' ? $this->store($request) : $this->update($request, $id);
    }

    public function delete($id)
    {
        $user = $this->user->find($id);
        if (!empty($user)) $user->delete();
        return $user;
    }

}
