<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'company_name',
        'primary_color',
        'secondary_color',
        'logo_url',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function hours()
    {
        return $this->hasMany(ShopHour::class);
    }
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    public function services()
    {
        return $this->belongsToMany(Service::class, 'shop_services')->withPivot('price');
    }
}
