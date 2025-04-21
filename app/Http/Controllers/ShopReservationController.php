<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\Reservation;
use Illuminate\Validation\Rule;

class ShopReservationController extends Controller
{
    public function index(Shop $shop)
    {
        $this->authorize('view', $shop);
        return response()->json($shop->reservations);
    }

    public function update(Request $request, Shop $shop, Reservation $reservation)
    {
        $this->authorize('update', $shop);
        $data = $request->validate([
            'status' => ['required', Rule::in(['pending', 'confirmed', 'canceled'])]
        ]);
        $reservation->update(['status' => $data['status']]);
        return response()->json($reservation);
    }

    public function availableSlots(Request $request, Shop $shop)
    {
        $request->validate(['date' => 'required|date']);
        $slots = $request->user()->listAvailableSlots($shop, $request->date);
        return response()->json($slots);
    }
}
