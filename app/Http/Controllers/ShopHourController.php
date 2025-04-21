<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\ShopHour;
use Illuminate\Validation\Rule;

class ShopHourController extends Controller
{
    public function index(Shop $shop)
    {
        return response()->json($shop->hours);
    }

    public function store(Request $request, Shop $shop)
    {
        $this->authorize('update', $shop);
        $data = $request->validate([
            'weekday'     => ['required', 'integer', 'between:0,6', Rule::unique('shop_hours')->where(fn($q) => $q->where('shop_id', $shop->id))],
            'open_time'   => 'required|date_format:H:i:s',
            'lunch_start' => 'required|date_format:H:i:s',
            'lunch_end'   => 'required|date_format:H:i:s',
            'close_time'  => 'required|date_format:H:i:s',
        ]);
        $hour = $shop->hours()->create($data);
        return response()->json($hour, 201);
    }

    public function update(Request $request, Shop $shop, ShopHour $shopHour)
    {
        $this->authorize('update', $shop);
        $data = $request->validate([
            'open_time'   => 'sometimes|date_format:H:i:s',
            'lunch_start' => 'sometimes|date_format:H:i:s',
            'lunch_end'   => 'sometimes|date_format:H:i:s',
            'close_time'  => 'sometimes|date_format:H:i:s',
        ]);
        $shopHour->update($data);
        return response()->json($shopHour);
    }

    public function destroy(Shop $shop, ShopHour $shopHour)
    {
        $this->authorize('update', $shop);
        $shopHour->delete();
        return response()->noContent();
    }
}
