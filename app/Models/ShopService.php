<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @OA\Schema(
 *     schema="ShopService",
 *     title="ShopService",
 *     description="Shop service model",
 *     @OA\Property(property="id", type="integer", format="int64", example=1),
 *     @OA\Property(property="shop_id", type="integer", format="int64", example=1),
 *     @OA\Property(property="name", type="string", example="Haircut"),
 *     @OA\Property(property="description", type="string", example="Basic haircut service"),
 *     @OA\Property(property="duration", type="integer", format="int32", example=30, description="Duration in minutes"),
 *     @OA\Property(property="price", type="number", format="float", example=25.00),
 *     @OA\Property(property="is_active", type="boolean", example=true),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class ShopService extends Model
{
    use HasFactory;

    protected $fillable = [
        'shop_id',
        'name',
        'description',
        'duration',
        'price',
        'is_active',
    ];

    protected $casts = [
        'duration' => 'integer',
        'price' => 'float',
        'is_active' => 'boolean',
    ];

    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }
}
