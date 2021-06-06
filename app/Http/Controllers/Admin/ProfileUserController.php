<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\OnlyIdRequest;
use App\Http\Requests\UserSaveRequest;
use App\Repositories\ProfileRepository;
use App\Repositories\UserRepository;
use App\Repositories\UserRoleRepository;
use Illuminate\Http\Request;

class ProfileUserController extends Controller
{
    protected $user, $profile;
    public function __construct(UserRepository $user, UserRoleRepository $userRole, ProfileRepository $profile)
    {
        $this->middleware(['auth', 'feature']);
        $this->user = $user;
        $this->profile = $profile;
        view()->share(['user_roles' => $userRole->dropdown_user()]);
    }

    public function index(OnlyIdRequest $request)
    {
        $profile = $this->profile->find($request->input('id'));
        return view('admin.profiles.users._index', compact('profile'));
    }

    public function search(Request $request)
    {
        $users = $this->user->search($request);
        return view('admin.profiles.users._table', compact('users'));
    }

    public function info(Request $request)
    {
        $profile_id = $request->input('profile_id');
        $user = $this->user->find($request->input('id'));
        return view('admin.profiles.users._info', compact('user', 'profile_id'));
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
