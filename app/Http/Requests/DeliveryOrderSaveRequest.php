<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeliveryOrderSaveRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'no_order' => 'required',
            'date' => 'required',
            'transporter_id' => 'required',
            'pickup_date' => 'required',
            'pickup_time' => 'required',
            'name' => 'required',
            'pickup_location_id.*' => 'required',
            'pickup_detail.*' => 'required',
            'deliver_location_id.*' => 'required',
            'deliver_detail.*' => 'required',
        ];
    }
}
