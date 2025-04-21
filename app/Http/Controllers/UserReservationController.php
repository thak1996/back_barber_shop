<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;

class UserReservationController extends Controller
{
    public function index(Request $request)
    {
        return response()->json($request->user()->reservations);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'shop_id'      => 'required|exists:shops,id',
            'service_id'   => 'required|exists:services,id',
            'scheduled_at' => 'required|date_format:Y-m-d H:i:s',
        ]);
        $reservation = $request->user()->reservations()->create($data);
        return response()->json($reservation, 201);
    }

    public function update(Request $request, Reservation $reservation)
    {
        $this->authorize('update', $reservation);
        $data = $request->validate(['scheduled_at' => 'required|date_format:Y-m-d H:i:s']);
        $reservation->update($data);
        return response()->json($reservation);
    }

    public function destroy(Reservation $reservation)
    {
        $this->authorize('delete', $reservation);
        $reservation->delete();
        return response()->noContent();
    }
}
