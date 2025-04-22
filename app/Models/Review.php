<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @OA\Schema(
 *     schema="Review",
 *     title="Review",
 *     description="Review model",
 *     @OA\Property(property="id", type="integer", format="int64", example=1),
 *     @OA\Property(property="user_id", type="integer", format="int64", example=1),
 *     @OA\Property(property="shop_id", type="integer", format="int64", example=1),
 *     @OA\Property(property="rating", type="integer", format="int32", example=5),
 *     @OA\Property(property="comment", type="string", example="Great service!"),
 *     @OA\Property(property="type", type="string", enum={"good", "neutral", "bad"}, example="good"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'shop_id',
        'rating',
        'comment',
        'type',
    ];

    protected $casts = [
        'rating' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }
}
