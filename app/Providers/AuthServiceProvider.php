<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Shop;
use App\Models\Reservation;
use App\Models\Review;
use App\Policies\ShopPolicy;
use App\Policies\ReservationPolicy;
use App\Policies\ReviewPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Shop::class        => ShopPolicy::class,
        Reservation::class => ReservationPolicy::class,
        Review::class      => ReviewPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();

        // Additional gates if needed
    }
}
