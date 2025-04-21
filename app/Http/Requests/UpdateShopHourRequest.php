<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateShopHourRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->can('update', $this->route('shop'));
    }

    public function rules()
    {
        return [
            'open_time'   => 'sometimes|date_format:H:i:s',
            'lunch_start' => 'sometimes|date_format:H:i:s',
            'lunch_end'   => 'sometimes|date_format:H:i:s',
            'close_time'  => 'sometimes|date_format:H:i:s',
        ];
    }
}
