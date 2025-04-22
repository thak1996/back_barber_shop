<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FavoriteShopRequest extends FormRequest
{
    public function authorize()
    {
        return true; // any authenticated user
    }

    public function rules()
    {
        return [
            'shop_id' => 'required|exists:shops,id',
        ];
    }

    public function messages()
    {
        return [
            'shop_id.required' => __('messages.favorite.shop_required'),
            'shop_id.exists' => __('messages.favorite.shop_not_found')
        ];
    }
}
