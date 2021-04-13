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
        foreach ($inputs as $input) {
            if ($request->has($input))
                $request->merge([$input => unformat_date($request->input($input))]);
        }
        return $request;
    }

    public function clean_number(Request $request, $inputs)
    {
        foreach ($inputs as $input) {
            if ($request->has($input))
                $request->merge([$input => unformat_number($request->input($input))]);
        }
        return $request;
    }

}
