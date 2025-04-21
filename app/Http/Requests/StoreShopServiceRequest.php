<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreShopServiceRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->can('update', $this->route('shop'));
    }

    public function rules()
    {
        return [
            'service_id' => 'required|exists:services,id',
            'price'      => 'required|numeric|min:0',
        ];
    }
}
