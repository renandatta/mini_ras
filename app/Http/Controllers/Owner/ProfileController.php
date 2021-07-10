<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileSaveRequest;
use App\Repositories\ProfileRepository;

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
        $profile = $this->profile->find(auth()->user()->profile_id);
        return view('owner.profile.index', compact('profile'));
    }

    public function save(ProfileSaveRequest $request)
    {
        $request->merge(['id' => auth()->user()->profile_id]);
        return $this->profile->save($request);
    }
}
