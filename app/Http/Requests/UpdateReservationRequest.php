<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReservationRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->can('update', $this->route('reservation'));
    }

    public function rules()
    {
        return [
            'scheduled_at' => 'required|date_format:Y-m-d H:i:s',
        ];
    }
}
