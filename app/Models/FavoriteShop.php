<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavoriteShop extends Model
{
    use HasFactory;
    protected $table = 'favorite_shops';
    protected $fillable = ['user_id', 'shop_id'];
}
