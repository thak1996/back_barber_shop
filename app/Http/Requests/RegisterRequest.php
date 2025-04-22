<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

/**
 * @OA\Schema(
 *     schema="RegisterRequest",
 *     title="RegisterRequest",
 *     description="User registration request validation",
 *     required={"name", "email", "password", "password_confirmation"},
 *     @OA\Property(property="name", type="string", example="John Doe"),
 *     @OA\Property(property="email", type="string", format="email", example="john@example.com"),
 *     @OA\Property(property="password", type="string", format="password", example="password123"),
 *     @OA\Property(property="password_confirmation", type="string", format="password", example="password123"),
 *     @OA\Property(property="phone", type="string", example="+5511999999999"),
 *     @OA\Property(property="address", type="string", example="123 Main St"),
 *     @OA\Property(property="city", type="string", example="São Paulo"),
 *     @OA\Property(property="state", type="string", example="SP"),
 *     @OA\Property(property="zip_code", type="string", example="01234-567"),
 *     @OA\Property(property="country", type="string", example="Brazil")
 * )
 */
class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:100'],
            'state' => ['nullable', 'string', 'max:100'],
            'zip_code' => ['nullable', 'string', 'max:20'],
            'country' => ['nullable', 'string', 'max:100'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => __('messages.auth.name_required'),
            'name.max' => __('messages.auth.name_max'),
            'email.required' => __('messages.auth.email_required'),
            'email.email' => __('messages.auth.email_invalid'),
            'email.unique' => __('messages.auth.email_taken'),
            'password.required' => __('messages.auth.password_required'),
            'password.confirmed' => __('messages.auth.password_confirmed'),
            'password.min' => __('messages.auth.password_min'),
            'phone.max' => __('messages.auth.phone_max'),
            'address.max' => __('messages.auth.address_max'),
            'city.max' => __('messages.auth.city_max'),
            'state.max' => __('messages.auth.state_max'),
            'zip_code.max' => __('messages.auth.zip_code_max'),
            'country.max' => __('messages.auth.country_max'),
        ];
    }
}
