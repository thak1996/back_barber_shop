<?php

namespace Database\Seeders;

use App\Models\ShopHour;
use Illuminate\Database\Seeder;

class ShopHourSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 5; $i++) {
            ShopHour::create([
                'shop_id' => 1,
                'weekday' => $i,
                'open_time' => '09:00:00',
                'close_time' => '19:00:00',
                'lunch_start' => '12:00:00',
                'lunch_end' => '13:00:00',
            ]);
        }

        ShopHour::create([
            'shop_id' => 1,
            'weekday' => 6,
            'open_time' => '09:00:00',
            'close_time' => '16:00:00',
            'lunch_start' => '12:00:00',
            'lunch_end' => '13:00:00',
        ]);
    }
}
