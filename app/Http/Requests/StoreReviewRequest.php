<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class StoreReviewRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->role === 'user';
    }

    public function rules()
    {
        return [
            'rating'  => 'required|numeric|min:0|max:5',
            'comment' => 'nullable|string',
            'type'    => ['required', Rule::in(['good', 'neutral', 'bad'])],
        ];
    }
}
