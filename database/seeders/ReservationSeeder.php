<?php

namespace Database\Seeders;

use App\Models\Reservation;
use App\Enums\ReservationStatus;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ReservationSeeder extends Seeder
{
    public function run(): void
    {
        Reservation::create([
            'user_id' => 1,
            'shop_id' => 1,
            'service_id' => 1,
            'scheduled_at' => Carbon::tomorrow()->setTime(14, 30, 0),
            'status' => ReservationStatus::CONFIRMED->value,
        ]);
    }
}