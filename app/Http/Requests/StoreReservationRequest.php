<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReservationRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->role === 'user';
    }

    public function rules()
    {
        return [
            'shop_id'      => 'required|exists:shops,id',
            'service_id'   => 'required|exists:services,id',
            'scheduled_at' => 'required|date_format:Y-m-d H:i:s',
        ];
    }
}
