<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReservationRequest;
use App\Http\Requests\UpdateReservationRequest;
use App\Models\Reservation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="User Reservations",
 *     description="User reservations management endpoints"
 * )
 */
class UserReservationController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/user/reservations",
     *     summary="Get all reservations for the authenticated user",
     *     tags={"User Reservations"},
     *     @OA\Response(
     *         response=200,
     *         description="List of user reservations",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Reservation")
     *         )
     *     )
     * )
     */
    public function index(Request $request): JsonResponse
    {
        $reservations = $request->user()->reservations()
            ->with(['shop', 'service'])
            ->get();

        return response()->json([
            'data' => $reservations
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/user/reservations",
     *     summary="Create a new reservation",
     *     tags={"User Reservations"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreReservationRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Reservation created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Reservation")
     *     )
     * )
     */
    public function store(StoreReservationRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['user_id'] = $request->user()->id;

        $reservation = Reservation::create($data);

        return response()->json([
            'message' => __('messages.reservation.created'),
            'data' => $reservation
        ], 201);
    }

    /**
     * @OA\Put(
     *     path="/api/user/reservations/{reservation}",
     *     summary="Update a reservation",
     *     tags={"User Reservations"},
     *     @OA\Parameter(
     *         name="reservation",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateReservationRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Reservation updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Reservation")
     *     )
     * )
     */
    public function update(UpdateReservationRequest $request, Reservation $reservation): JsonResponse
    {
        $this->authorize('update', $reservation);

        $reservation->update($request->validated());

        return response()->json([
            'message' => __('messages.reservation.updated'),
            'data' => $reservation
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/user/reservations/{reservation}",
     *     summary="Delete a reservation",
     *     tags={"User Reservations"},
     *     @OA\Parameter(
     *         name="reservation",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Reservation deleted successfully"
     *     )
     * )
     */
    public function destroy(Reservation $reservation): JsonResponse
    {
        $this->authorize('delete', $reservation);

        $reservation->delete();

        return response()->json([
            'message' => __('messages.reservation.deleted')
        ]);
    }
}
