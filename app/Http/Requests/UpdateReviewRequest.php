<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateReviewRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->can('update', $this->route('review'));
    }

    public function rules()
    {
        return [
            'rating'  => 'sometimes|numeric|min:0|max:5',
            'comment' => 'sometimes|string',
            'type'    => ['sometimes', Rule::in(['good', 'neutral', 'bad'])],
        ];
    }
}
