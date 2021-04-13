<?php

namespace App\Http\Controllers;

use App\Http\Requests\IdRequest;
use App\Http\Requests\ProfileSaveRequest;
use App\Repositories\ProfileRepository;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    protected $profile;
    public function __construct(ProfileRepository $profile)
    {
        $this->middleware(['fitur_program']);
        $this->profile = $profile;
    }

    public function index()
    {
        session(['menu_active' => 'profiles']);
        return view('profiles.index');
    }

    public function search(Request $request)
    {
        $profiles = $this->profile->search($request);
        return view('profiles._table', compact('profiles'));
    }

    public function info(Request $request)
    {
        $profile = $this->profile->find($request->input('id'));
        return view('profiles._info', compact('profile'));
    }

    public function save(ProfileSaveRequest $request)
    {
        return $this->profile->save($request);
    }

    public function delete(IdRequest $request)
    {
        return $this->profile->delete($request->input('id'));
    }
}
