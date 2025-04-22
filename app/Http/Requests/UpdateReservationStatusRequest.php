<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @OA\Schema(
 *     schema="UpdateReservationStatusRequest",
 *     title="UpdateReservationStatusRequest",
 *     description="Update reservation status request validation",
 *     required={"status"},
 *     @OA\Property(
 *         property="status",
 *         type="string",
 *         enum={"pending", "confirmed", "cancelled", "completed"},
 *         example="confirmed"
 *     )
 * )
 */
class UpdateReservationStatusRequest extends FormRequest
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
        return [
            'status' => ['required', 'string', Rule::in(['pending', 'confirmed', 'cancelled', 'completed'])],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'status.required' => __('messages.reservation.status_required'),
            'status.in' => __('messages.reservation.status_invalid'),
        ];
    }
}
