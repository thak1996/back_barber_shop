<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ShopHourController;
use App\Http\Controllers\ShopServiceController;
use App\Http\Controllers\ShopReservationController;
use App\Http\Controllers\UserReservationController;
use App\Http\Controllers\FavoriteShopController;
use App\Http\Controllers\ReviewController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Public (auth)
Route::post('auth/login', [AuthController::class, 'login']);
Route::post('auth/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('auth/reset-password', [AuthController::class, 'resetPassword']);

// Protected (JWT)
Route::middleware('auth:api')->group(function () {
    // Auth
    Route::post('auth/logout', [AuthController::class, 'logout']);
    Route::post('auth/refresh', [AuthController::class, 'refresh']);
    Route::get('auth/me', [AuthController::class, 'me']);

    // Shop Hours
    Route::apiResource('shops.hours', ShopHourController::class)
        ->except(['show', 'create', 'edit']);

    // Shop Services
    Route::apiResource('shops.services', ShopServiceController::class)
        ->shallow()
        ->except(['show', 'create', 'edit']);

    // Available slots (30m interval)
    Route::get('shops/{shop}/slots', [ShopReservationController::class, 'availableSlots']);

    // Shop Reservations
    Route::get('shops/{shop}/reservations', [ShopReservationController::class, 'index']);
    Route::patch('shops/{shop}/reservations/{reservation}', [ShopReservationController::class, 'update']);

    // User Reservations
    Route::apiResource('users.reservations', UserReservationController::class)
        ->except(['show', 'create', 'edit']);

    // Favorite Shops
    Route::post('favorites', [FavoriteShopController::class, 'store']);
    Route::delete('favorites/{shop}', [FavoriteShopController::class, 'destroy']);

    // Reviews
    Route::apiResource('shops.reviews', ReviewController::class)
        ->only(['index', 'store', 'update']);
});
