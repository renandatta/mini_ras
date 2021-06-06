<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\OnlyIdRequest;
use App\Http\Requests\ProfileSaveRequest;
use App\Repositories\ProfileRepository;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    protected $profile;
    public function __construct(ProfileRepository $profile)
    {
        $this->middleware(['auth', 'feature']);
        $this->profile = $profile;
    }

    public function index()
    {
        session(['menu_active' => 'admin.profiles']);
        return view('admin.profiles.index');
    }

    public function search(Request $request)
    {
        $profiles = $this->profile->search($request);
        return view('admin.profiles._table', compact('profiles'));
    }

    public function info(Request $request)
    {
        $profile = $this->profile->find($request->input('id'));
        return view('admin.profiles._info', compact('profile'));
    }

    public function save(ProfileSaveRequest $request)
    {
        return $this->profile->save($request);
    }

    public function delete(OnlyIdRequest $request)
    {
        return $this->profile->delete($request->input('id'));
    }
}
