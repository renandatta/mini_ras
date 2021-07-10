<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Http\Requests\OnlyIdRequest;
use App\Http\Requests\UserSaveRequest;
use App\Repositories\UserRepository;
use App\Repositories\UserRoleRepository;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $user;
    public function __construct(UserRepository $user, UserRoleRepository $userRole)
    {
        $this->middleware(['auth', 'feature']);
        $this->user = $user;
        view()->share(['user_roles' => $userRole->dropdown_user()]);
    }

    public function index()
    {
        session(['menu_active' => 'owner.users']);
        return view('owner.users.index');
    }

    public function search(Request $request)
    {
        $request->merge(['profile_id' => auth()->user()->profile_id]);
        $users = $this->user->search($request);
        return view('owner.users._table', compact('users'));
    }

    public function info(Request $request)
    {
        $user = $this->user->find($request->input('id'));
        return view('owner.users._info', compact('user'));
    }

    public function save(UserSaveRequest $request)
    {
        $request->merge(['profile_id' => auth()->user()->profile_id]);
        return $this->user->save($request);
    }

    public function delete(OnlyIdRequest $request)
    {
        return $this->user->delete($request->input('id'));
    }
}
