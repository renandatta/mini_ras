<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\OnlyIdRequest;
use App\Http\Requests\UserRoleSaveRequest;
use App\Repositories\FeatureRepository;
use App\Repositories\UserRoleRepository;
use Illuminate\Http\Request;

class UserRoleController extends Controller
{
    protected $userRole;
    public function __construct(UserRoleRepository $userRole, FeatureRepository $feature)
    {
        $this->middleware(['auth', 'feature']);
        $this->userRole = $userRole;
        view()->share(['list_features' => $feature->list_features()]);
    }

    public function index()
    {
        session(['menu_active' => 'admin.user_roles']);
        return view('admin.user_roles.index');
    }

    public function search(Request $request)
    {
        $user_roles = $this->userRole->search($request);
        return view('admin.user_roles._table', compact('user_roles'));
    }

    public function info(Request $request)
    {
        $user_role = $this->userRole->find($request->input('id'));
        return view('admin.user_roles._info', compact('user_role'));
    }

    public function save(UserRoleSaveRequest $request)
    {
        return $this->userRole->save($request);
    }

    public function delete(OnlyIdRequest $request)
    {
        return $this->userRole->delete($request->input('id'));
    }
}
