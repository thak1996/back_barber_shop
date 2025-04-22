<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @OA\Schema(
 *     schema="ShopHourRequest",
 *     title="ShopHourRequest",
 *     description="Shop hour request validation",
 *     required={"weekday", "open_time", "close_time"},
 *     @OA\Property(property="weekday", type="integer", format="int32", example=1, description="0 = Sunday, 1 = Monday, ..., 6 = Saturday"),
 *     @OA\Property(property="open_time", type="string", format="time", example="09:00:00"),
 *     @OA\Property(property="close_time", type="string", format="time", example="18:00:00"),
 *     @OA\Property(property="lunch_start", type="string", format="time", example="12:00:00"),
 *     @OA\Property(property="lunch_end", type="string", format="time", example="13:00:00"),
 *     @OA\Property(property="is_closed", type="boolean", example=false)
 * )
 */
class ShopHourRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'weekday' => ['required', 'integer', 'between:0,6'],
            'open_time' => ['required', 'date_format:H:i:s'],
            'close_time' => ['required', 'date_format:H:i:s', 'after:open_time'],
            'lunch_start' => ['nullable', 'date_format:H:i:s'],
            'lunch_end' => ['nullable', 'date_format:H:i:s', 'after:lunch_start'],
            'is_closed' => ['boolean'],
        ];

        if ($this->isMethod('PUT')) {
            $rules = array_map(function ($rule) {
                return 'sometimes|' . $rule;
            }, $rules);
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'weekday.required' => __('messages.shop_hours.weekday_required'),
            'weekday.between' => __('messages.shop_hours.weekday_range'),
            'open_time.required' => __('messages.shop_hours.time_required'),
            'open_time.date_format' => __('messages.shop_hours.time_format'),
            'close_time.required' => __('messages.shop_hours.time_required'),
            'close_time.date_format' => __('messages.shop_hours.time_format'),
            'close_time.after' => __('messages.shop_hours.close_after_open'),
            'lunch_start.date_format' => __('messages.shop_hours.time_format'),
            'lunch_end.date_format' => __('messages.shop_hours.time_format'),
            'lunch_end.after' => __('messages.shop_hours.lunch_end_after_start'),
        ];
    }
}
