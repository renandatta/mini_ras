<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\FeatureRepositionRequest;
use App\Http\Requests\OnlyIdRequest;
use App\Http\Requests\FeatureSaveRequest;
use App\Repositories\FeatureRepository;
use Illuminate\Http\Request;

class FeatureController extends Controller
{
    protected $feature;
    public function __construct(FeatureRepository $feature)
    {
        $this->middleware(['auth', 'feature']);
        $this->feature = $feature;
    }

    public function index()
    {
        session(['menu_active' => 'admin.features']);
        return view('admin.features.index');
    }

    public function search(Request $request)
    {
        $features = $this->feature->search($request);
        foreach ($features as $feature) {
            $feature->text = $feature->name;
            unset($feature->icon);
        }
        return $this->feature->nested_data($features);
    }

    public function info(Request $request)
    {
        $feature = $this->feature->find($request->input('id'));
        $parent_code = $request->input('parent_code', '#');
        return view('admin.features._info', compact('feature', 'parent_code'));
    }

    public function save(FeatureSaveRequest $request)
    {
        return $this->feature->save($request);
    }

    public function delete(OnlyIdRequest $request)
    {
        return $this->feature->delete($request->input('id'));
    }

    public function reposition(FeatureRepositionRequest $request)
    {
        return $this->feature->reposition($request->input('id'), $request->input('direction'));
    }
}
