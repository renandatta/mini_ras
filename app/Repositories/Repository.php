<?php

namespace App\Repositories;

use Illuminate\Http\Request;

class Repository
{
    public function auto_code($model, $parent_code = '#')
    {
        $last_row = $model
            ->where('parent_code', $parent_code)
            ->orderBy('code', 'desc')
            ->first();
        $code = '01';
        if (!empty($last_row)) {
            $temp = explode(".", $last_row->code);
            $code = intval(end($temp))+1;
            if (strlen($code) == 1) $code = "0$code" ;
        }
        return $parent_code == '#' ? $code : "$parent_code.$code";
    }

    public function clean_date(Request $request, $inputs)
    {
        foreach ($inputs as $input)
            if ($request->has($input))
                $request->merge([$input => unformat_date($request->input($input))]);
        return $request;
    }

    public function clean_number(Request $request, $inputs)
    {
        foreach ($inputs as $input)
            if ($request->has($input))
                $request->merge([$input => unformat_number($request->input($input))]);
        return $request;
    }

    public function filter(Request $request, $model, $params)
    {
        foreach ($params as $param) {
            $value = $param['value'];
            $column = $param['column'] ?? $value;
            $operator = $param['operator'] ?? '=';
            $value = $request->input($value, '') ?? '';

            if ($value !== '') {
                if ($value === 'null') $model = $model->whereNull($column);
                else if ($value === 'not_null') $model = $model->whereNotNull($column);
                else {
                    if ($operator === '=') $model = $model->where($column, $value);
                    else if ($operator === 'like') $model = $model->where($column, 'like', "%$value%");
                    else if ($operator === 'like%') $model = $model->where($column, 'like', "$value%");
                    else if ($operator === 'with') $model = $model->with($value);
                    else if ($operator === 'in_array') $model = $model->inArray($column, $value);
                    else if ($operator === 'not_in_array') $model = $model->NotInArray($column, $value);
                    else $model = $model->where($column, $operator, $value);
                }
            }
        }
        return $model;
    }

}
