<?php

namespace App\Repositories;

use App\Models\Feature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FeatureRepository extends Repository
{

    protected $feature;
    public function __construct(Feature $feature)
    {
        $this->feature = $feature;
    }

    public function search(Request $request)
    {
        $feature = $this->feature->orderBy('code');
        $feature = $this->filter($request, $feature, [
            ['value' => 'in_array_id', 'column' => 'id', 'operator' => 'in_array'],
            ['value' => 'code', 'operator' => 'like%'],
            ['value' => 'parent_code'],
        ]);
        $paginate = $request->input('paginate') ?? null;
        if ($paginate != null) return $feature->paginate($paginate);
        return $feature->get();
    }

    public function find($value, $column = 'id')
    {
        return $this->feature->where($column, $value)->first();
    }

    public function store(Request $request)
    {
        $code = $this->auto_code($this->feature, $request->input('parent_code', '#'));
        $request->merge(['code' => $code]);
        return $this->feature->create($request->all());
    }

    public function update(Request $request, $id)
    {
        $feature = $this->feature->find($id);
        $feature->update($request->all());
        return $feature;
    }

    public function save(Request $request)
    {
        $id = $request->input('id') ?? '';
        return $id == '' ? $this->store($request) : $this->update($request, $id);
    }

    public function delete($id)
    {
        $feature = $this->feature->find($id);
        if (!empty($feature)) $feature->delete();
        return $feature;
    }

    protected $skip = array();
    public function nested_data($data, $parent_code = '#')
    {
        $result = array();
        foreach ($data as $item) {
            if (!in_array($item->id, $this->skip) && $item->parent_code == $parent_code) {
                array_push($this->skip, $item->id);
                $item->children = $this->nested_data($data, $item->code);
                array_push($result, $item);
            }
        }
        return $result;
    }

    public function reposition($id, $direction)
    {
        $jarak = 1;
        $feature = $this->feature->find($id);
        $origin_code = $feature->code;
        $code_array = explode(".", $feature->code);
        $code = $code_array[count($code_array)-1];
        $destination_code = $direction == 'up' ? intval($code) - $jarak : intval($code) + $jarak;
        if (strlen($destination_code) == 1) $destination_code = '0' . $destination_code;
        if ($feature->parent_code != '#') $destination_code = $feature->parent_code. '.' .$destination_code;
        $feature_tujuan = $this->feature->where('code', '=', $destination_code)->first();

        if (!empty($feature_tujuan)) {
            $temp_code = mt_rand(111,999);

            //=====tujuan pindah ke temp
            $this->swap_code($destination_code, $temp_code);

            //=====asal pindah ke tujuan
            $this->swap_code($origin_code, $destination_code);

            //=====temp pindah ke asal
            $this->swap_code($temp_code, $origin_code);
        } else {
            $this->reposisi($id, $direction);
        }
        return $feature;
    }

    public function swap_code($origin_code, $destination_code)
    {
        $this->feature->where('code', "$origin_code")->update(['code' => "$destination_code"]);
        if ($this->feature->where('parent_code', "$origin_code")->count() > 0)
            $this->feature->where('parent_code', "$origin_code")
                ->update([
                    'code' => DB::raw("replace(code, parent_code, '". (string) $destination_code ."')"),
                    'parent_code' => "$destination_code"
                ]);
    }

    public function list_features()
    {
        $result = array();
        $features = $this->feature->where('parent_code', '#')->get();
        foreach ($features as $feature) $result[$feature->id] = $feature->name;
        return $result;
    }

}
