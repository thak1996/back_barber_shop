<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AvailableSlotsRequest extends FormRequest
{
    public function authorize()
    {
        return true; // any authenticated user
    }

    public function rules()
    {
        return [
            'date' => 'required|date',
        ];
    }
}
