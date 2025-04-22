<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

/**
 * @OA\Schema(
 *     schema="UpdateReservationRequest",
 *     title="UpdateReservationRequest",
 *     description="Update reservation request validation",
 *     @OA\Property(property="scheduled_at", type="string", format="date-time", example="2024-03-20 14:30:00"),
 *     @OA\Property(property="notes", type="string", example="Please bring your own towel")
 * )
 */
class UpdateReservationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->id === $this->route('reservation')->user_id;
    }

    public function rules(): array
    {
        return [
            'scheduled_at' => ['sometimes', 'required', 'date', 'after:now'],
            'notes' => ['sometimes', 'nullable', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'scheduled_at.required' => __('messages.reservation.scheduled_at_required'),
            'scheduled_at.date' => __('messages.reservation.scheduled_at_date'),
            'scheduled_at.after' => __('messages.reservation.scheduled_at_future'),
            'notes.max' => __('messages.reservation.notes_max'),
        ];
    }
}
