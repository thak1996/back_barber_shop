<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;

class FavoriteShopController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate(['shop_id' => 'required|exists:shops,id']);
        $request->user()->favoriteShops()->attach($data['shop_id']);
        return response()->json(['message' => 'Added to favorites'], 201);
    }

    public function destroy(Request $request, Shop $shop)
    {
        $request->user()->favoriteShops()->detach($shop->id);
        return response()->json(['message' => 'Removed from favorites']);
    }
}
