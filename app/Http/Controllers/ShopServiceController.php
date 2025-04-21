<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\ShopService;

class ShopServiceController extends Controller
{
    public function index(Shop $shop)
    {
        $this->authorize('update', $shop);
        return response()->json($shop->services);
    }

    public function store(Request $request, Shop $shop)
    {
        $this->authorize('update', $shop);
        $data = $request->validate([
            'service_id' => 'required|exists:services,id',
            'price'      => 'required|numeric|min:0',
        ]);
        $shop->services()->attach($data['service_id'], ['price' => $data['price']]);
        $service = $shop->services()->find($data['service_id']);
        return response()->json($service, 201);
    }

    public function update(Request $request, Shop $shop, ShopService $shopService)
    {
        $this->authorize('update', $shop);
        $data = $request->validate(['price' => 'required|numeric|min:0']);
        $shopService->update($data);
        return response()->json($shopService);
    }

    public function destroy(Shop $shop, ShopService $shopService)
    {
        $this->authorize('update', $shop);
        $shop->services()->detach($shopService->service_id);
        return response()->noContent();
    }
}
