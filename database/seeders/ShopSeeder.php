<?php

namespace Database\Seeders;

use App\Models\Shop;
use Illuminate\Database\Seeder;

class ShopSeeder extends Seeder
{
    public function run(): void
    {
        Shop::create([
            'user_id' => 2,
            'company_name' => 'Barbearia Exemplo',
            'primary_color' => '#000000',
            'secondary_color' => '#FFFFFF',
            'logo_url' => 'https://via.placeholder.com/150',
        ]);
    }
}
