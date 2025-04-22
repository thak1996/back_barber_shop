<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\ShopService;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            ['name' => 'Corte de Cabelo', 'description' => 'Corte masculino tradicional'],
            ['name' => 'Barba', 'description' => 'Barba completa com toalha quente'],
            ['name' => 'Combo (Cabelo + Barba)', 'description' => 'Corte masculino + barba completa'],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }

        $shopServices = [
            ['shop_id' => 1, 'service_id' => 1, 'price' => 50.00],
            ['shop_id' => 1, 'service_id' => 2, 'price' => 40.00],
            ['shop_id' => 1, 'service_id' => 3, 'price' => 80.00],
        ];

        foreach ($shopServices as $shopService) {
            ShopService::create($shopService);
        }
    }
}
