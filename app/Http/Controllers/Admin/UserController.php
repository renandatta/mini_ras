<?php

namespace App\Http\Controllers\Admin;

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
        view()->share(['user_roles' => $userRole->dropdown()]);
    }

    public function index()
    {
        session(['menu_active' => 'admin.users']);
        return view('admin.users.index');
    }

    public function search(Request $request)
    {
        $users = $this->user->search($request);
        return view('admin.users._table', compact('users'));
    }

    public function info(Request $request)
    {
        $user = $this->user->find($request->input('id'));
        return view('admin.users._info', compact('user'));
    }

    public function save(UserSaveRequest $request)
    {
        return $this->user->save($request);
    }

    public function delete(OnlyIdRequest $request)
    {
        return $this->user->delete($request->input('id'));
    }
}
