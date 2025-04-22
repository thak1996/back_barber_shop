<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Carbon\Carbon;
use App\Enums\UserRole;

/**
 * @OA\Schema(
 *     schema="User",
 *     title="User",
 *     description="User model",
 *     @OA\Property(property="id", type="integer", format="int64", example=1),
 *     @OA\Property(property="name", type="string", example="John Doe"),
 *     @OA\Property(property="email", type="string", format="email", example="john@example.com"),
 *     @OA\Property(property="phone", type="string", example="+5511999999999"),
 *     @OA\Property(property="address", type="string", example="123 Main St"),
 *     @OA\Property(property="city", type="string", example="São Paulo"),
 *     @OA\Property(property="state", type="string", example="SP"),
 *     @OA\Property(property="zip_code", type="string", example="01234-567"),
 *     @OA\Property(property="country", type="string", example="Brazil"),
 *     @OA\Property(property="role", type="string", enum={"user", "shop"}, example="user"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'city',
        'state',
        'zip_code',
        'country',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'role' => UserRole::class,
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function shop()
    {
        return $this->hasOne(Shop::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function favoriteShops()
    {
        return $this->belongsToMany(Shop::class, 'favorite_shops');
    }

    public function listMyReservations()
    {
        return $this->reservations()->get();
    }

    public function listAvailableSlots(Shop $shop, string $date): array
    {
        $dow   = Carbon::parse($date)->dayOfWeek;
        $hours = $shop->hours()->where('weekday', $dow)->first();
        if (! $hours) return [];

        $slots = [];
        $start = Carbon::parse("$date {$hours->open_time}");
        $lunch = Carbon::parse("$date {$hours->lunch_start}");
        $back  = Carbon::parse("$date {$hours->lunch_end}");
        $end   = Carbon::parse("$date {$hours->close_time}");

        for ($dt = $start; $dt->lt($lunch); $dt->addMinutes(30)) {
            $slots[] = $dt->toDateTimeString();
        }
        for ($dt = $back; $dt->lt($end); $dt->addMinutes(30)) {
            $slots[] = $dt->toDateTimeString();
        }

        $booked = $shop->reservations()
            ->whereDate('scheduled_at', $date)
            ->pluck('scheduled_at')
            ->map(fn($dt) => Carbon::parse($dt)->toDateTimeString())
            ->toArray();

        return array_values(array_diff($slots, $booked));
    }
}
