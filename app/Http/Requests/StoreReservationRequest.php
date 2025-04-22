<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

/**
 * @OA\Schema(
 *     schema="StoreReservationRequest",
 *     title="StoreReservationRequest",
 *     description="Store reservation request validation",
 *     required={"shop_id", "scheduled_at"},
 *     @OA\Property(property="shop_id", type="integer", format="int64", example=1),
 *     @OA\Property(property="scheduled_at", type="string", format="date-time", example="2024-03-20 14:30:00"),
 *     @OA\Property(property="notes", type="string", example="Please bring your own towel")
 * )
 */
class StoreReservationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->role === 'user';
    }

    public function rules(): array
    {
        return [
            'shop_id' => ['required', 'integer', 'exists:shops,id'],
            'scheduled_at' => ['required', 'date', 'after:now'],
            'notes' => ['nullable', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'shop_id.required' => __('messages.reservation.shop_required'),
            'shop_id.exists' => __('messages.reservation.shop_exists'),
            'scheduled_at.required' => __('messages.reservation.scheduled_at_required'),
            'scheduled_at.date' => __('messages.reservation.scheduled_at_date'),
            'scheduled_at.after' => __('messages.reservation.scheduled_at_future'),
            'notes.max' => __('messages.reservation.notes_max'),
        ];
    }
}
