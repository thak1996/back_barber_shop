<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopService extends Model
{
    use HasFactory;
    protected $fillable = ['shop_id', 'service_id', 'price'];

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
