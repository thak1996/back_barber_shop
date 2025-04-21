<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopHour extends Model
{
    use HasFactory;
    protected $fillable = ['shop_id', 'weekday', 'open_time', 'lunch_start', 'lunch_end', 'close_time'];
    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
}
