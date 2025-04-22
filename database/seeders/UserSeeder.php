<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Enums\UserRole;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('users')->truncate();

        User::create([
            'name' => 'User',
            'email' => 'user@example.com',
            'password' => Hash::make('user@123'),
            'phone' => '+5511988888888',
            'address' => 'Rua User, 456',
            'city' => 'São Paulo',
            'state' => 'SP',
            'zip_code' => '04567-890',
            'country' => 'Brazil',
        ]);

        User::create([
            'name' => 'Shop Owner',
            'email' => 'shop@example.com',
            'password' => Hash::make('shop@123'),
            'phone' => '+5511977777777',
            'address' => 'Rua Shop, 789',
            'city' => 'São Paulo',
            'state' => 'SP',
            'zip_code' => '08901-234',
            'country' => 'Brazil',
            'role' => UserRole::SHOP->value,
        ]);

        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin@123'),
            'role' => UserRole::ADMIN->value
        ]);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
