<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateReservationStatusRequest;
use App\Models\Reservation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Shop Reservations",
 *     description="Shop reservations management endpoints"
 * )
 */
class ShopReservationController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/shops/{shop}/reservations",
     *     summary="Get all reservations for a shop",
     *     tags={"Shop Reservations"},
     *     @OA\Parameter(
     *         name="shop",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of shop reservations",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Reservation")
     *         )
     *     )
     * )
     */
    public function index(Request $request, $shopId): JsonResponse
    {
        $reservations = Reservation::where('shop_id', $shopId)
            ->with(['user', 'service'])
            ->get();

        return response()->json([
            'data' => $reservations
        ]);
    }

    /**
     * @OA\Put(
     *     path="/api/shops/{shop}/reservations/{reservation}",
     *     summary="Update reservation status",
     *     tags={"Shop Reservations"},
     *     @OA\Parameter(
     *         name="shop",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="reservation",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateReservationStatusRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Reservation updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Reservation")
     *     )
     * )
     */
    public function update(UpdateReservationStatusRequest $request, $shopId, $id): JsonResponse
    {
        $reservation = Reservation::where('shop_id', $shopId)
            ->where('id', $id)
            ->firstOrFail();

        $reservation->update($request->validated());

        return response()->json([
            'message' => __('messages.reservation.updated'),
            'data' => $reservation
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/shops/{shop}/available-slots",
     *     summary="Get available reservation slots for a date",
     *     tags={"Shop Reservations"},
     *     @OA\Parameter(
     *         name="shop",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="date",
     *         in="query",
     *         required=true,
     *         @OA\Schema(type="string", format="date")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of available slots",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(type="string", format="time")
     *         )
     *     )
     * )
     */
    public function availableSlots(Request $request, $shopId): JsonResponse
    {
        $request->validate([
            'date' => 'required|date_format:Y-m-d'
        ], [
            'date.required' => __('messages.reservation.date_required'),
            'date.date_format' => __('messages.reservation.date_format'),
        ]);

        $slots = $request->user()->listAvailableSlots($shopId, $request->date);

        return response()->json([
            'data' => $slots
        ]);
    }
}
