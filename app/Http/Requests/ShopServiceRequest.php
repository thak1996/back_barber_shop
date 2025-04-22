<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @OA\Schema(
 *     schema="ShopServiceRequest",
 *     title="ShopServiceRequest",
 *     description="Shop service request validation",
 *     required={"name", "duration", "price"},
 *     @OA\Property(property="name", type="string", example="Haircut"),
 *     @OA\Property(property="description", type="string", example="Basic haircut service"),
 *     @OA\Property(property="duration", type="integer", format="int32", example=30, description="Duration in minutes"),
 *     @OA\Property(property="price", type="number", format="float", example=25.00),
 *     @OA\Property(property="is_active", type="boolean", example=true)
 * )
 */
class ShopServiceRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'duration' => ['required', 'integer', 'min:1'],
            'price' => ['required', 'numeric', 'min:0'],
            'is_active' => ['boolean'],
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
            'name.required' => __('messages.service.name_required'),
            'name.max' => __('messages.service.name_max'),
            'duration.required' => __('messages.service.duration_required'),
            'duration.integer' => __('messages.service.duration_integer'),
            'duration.min' => __('messages.service.duration_min'),
            'price.required' => __('messages.service.price_required'),
            'price.numeric' => __('messages.service.price_numeric'),
            'price.min' => __('messages.service.price_min'),
        ];
    }
}
