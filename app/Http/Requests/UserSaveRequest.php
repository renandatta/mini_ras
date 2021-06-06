<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserSaveRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'user_role_id' => 'required|int',
            'name' => 'required',
            'email' => 'required',
            'password' => 'required|confirmed'
        ];
        if ($this->input('password') == '' && $this->input('id') != '') unset($rules['password']);
        return $rules;
    }
}
