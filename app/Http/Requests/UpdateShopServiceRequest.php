<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateShopServiceRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->can('update', $this->route('shop'));
    }

    public function rules()
    {
        return [
            'price' => 'required|numeric|min:0',
        ];
    }
}
