<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Enums\ReservationStatus;

/**
 * @OA\Schema(
 *     schema="Reservation",
 *     title="Reservation",
 *     description="Reservation model",
 *     @OA\Property(property="id", type="integer", format="int64", example=1),
 *     @OA\Property(property="user_id", type="integer", format="int64", example=1),
 *     @OA\Property(property="shop_id", type="integer", format="int64", example=1),
 *     @OA\Property(property="service_id", type="integer", format="int64", example=1),
 *     @OA\Property(property="scheduled_at", type="string", format="date-time", example="2024-03-20 14:30:00"),
 *     @OA\Property(property="status", type="string", enum={"pending", "confirmed", "cancelled", "completed"}, example="pending"),
 *     @OA\Property(property="notes", type="string", example="Please bring your own towel"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'shop_id',
        'service_id',
        'scheduled_at',
        'status',
        'notes',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'status' => ReservationStatus::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
}
