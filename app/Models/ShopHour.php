<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @OA\Schema(
 *     schema="ShopHour",
 *     title="ShopHour",
 *     description="Shop operating hours model",
 *     @OA\Property(property="id", type="integer", format="int64", example=1),
 *     @OA\Property(property="shop_id", type="integer", format="int64", example=1),
 *     @OA\Property(property="weekday", type="integer", format="int32", example=1, description="0 = Sunday, 1 = Monday, ..., 6 = Saturday"),
 *     @OA\Property(property="open_time", type="string", format="time", example="09:00:00"),
 *     @OA\Property(property="close_time", type="string", format="time", example="18:00:00"),
 *     @OA\Property(property="lunch_start", type="string", format="time", example="12:00:00"),
 *     @OA\Property(property="lunch_end", type="string", format="time", example="13:00:00"),
 *     @OA\Property(property="is_closed", type="boolean", example=false),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class ShopHour extends Model
{
    use HasFactory;

    protected $fillable = [
        'shop_id',
        'weekday',
        'open_time',
        'close_time',
        'lunch_start',
        'lunch_end',
        'is_closed',
    ];

    protected $casts = [
        'weekday' => 'integer',
        'is_closed' => 'boolean',
    ];

    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }
}
