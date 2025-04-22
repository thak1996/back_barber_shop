<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ReviewRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $rules = [
            'rating' => 'required|numeric|min:0|max:5',
            'comment' => 'nullable|string',
            'type' => ['required', Rule::in(['good', 'neutral', 'bad'])],
        ];

        if ($this->isMethod('PUT')) {
            $rules = array_map(function ($rule) {
                return 'sometimes|' . $rule;
            }, $rules);
        }

        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'rating.required' => __('messages.review.rating_required'),
            'rating.numeric' => __('messages.review.rating_numeric'),
            'rating.min' => __('messages.review.rating_min'),
            'rating.max' => __('messages.review.rating_max'),
            'type.required' => __('messages.review.type_required'),
            'type.in' => __('messages.review.type_invalid')
        ];
    }
}
