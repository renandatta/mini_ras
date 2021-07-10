<?php

namespace App\Repositories;

use App\Models\CustomerProfile;
use Illuminate\Http\Request;

class CustomerProfileRepository extends Repository {

    protected $customerProfile, $profile;
    public function __construct(CustomerProfile $customerProfile, ProfileRepository $profile)
    {
        $this->customerProfile = $customerProfile;
        $this->profile = $profile;
    }

    public function search(Request $request)
    {
        $customerProfile = $this->customerProfile;
        $customerProfile = $this->filter($request, $customerProfile, [
            ['value' => 'profile_id']
        ]);
        $paginate = $request->input('paginate') ?? null;
        if ($paginate != null) return $customerProfile->paginate($paginate);
        return $customerProfile->get();
    }

    public function find($value, $column = 'id')
    {
        return $this->customerProfile->where($column, $value)->first();
    }

    public function save(Request $request)
    {
        $name = $request->input('name');
        $profile = $this->profile->find($name, 'name');
        if (empty($profile)) $profile = $this->profile->save(new Request(['name' => $name]));

        return $this->customerProfile->firstOrCreate([
            'profile_id' => $request->input('profile_id'),
            'customer_id' => $profile->id
        ]);
    }

    public function delete($id)
    {
        $customerProfile = $this->customerProfile->find($id);
        if (!empty($customerProfile)) $customerProfile->delete();
        return $customerProfile;
    }

}
