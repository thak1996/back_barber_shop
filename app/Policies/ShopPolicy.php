<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Shop;

class ShopPolicy
{
    public function view(User $user, Shop $shop)
    {
        return $user->id === $shop->user_id && $user->role === 'shop';
    }

    public function update(User $user, Shop $shop)
    {
        return $user->id === $shop->user_id && $user->role === 'shop';
    }
}
