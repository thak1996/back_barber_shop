<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreShopHourRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->can('update', $this->route('shop'));
    }

    public function rules()
    {
        return [
            'weekday'     => ['required', 'integer', 'between:0,6', Rule::unique('shop_hours')->where(fn($q) => $q->where('shop_id', $this->route('shop')->id))],
            'open_time'   => 'required|date_format:H:i:s',
            'lunch_start' => 'required|date_format:H:i:s',
            'lunch_end'   => 'required|date_format:H:i:s',
            'close_time'  => 'required|date_format:H:i:s',
        ];
    }
}
