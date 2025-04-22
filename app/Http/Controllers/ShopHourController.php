<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShopHourRequest;
use App\Models\ShopHour;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Shop Hours",
 *     description="Shop hours management endpoints"
 * )
 */
class ShopHourController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/shops/{shop}/hours",
     *     summary="Get shop hours",
     *     tags={"Shop Hours"},
     *     @OA\Parameter(
     *         name="shop",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of shop hours",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/ShopHour")
     *         )
     *     )
     * )
     */
    public function index(Request $request, $shopId): JsonResponse
    {
        $shopHours = ShopHour::where('shop_id', $shopId)->get();
        return response()->json($shopHours);
    }

    /**
     * @OA\Post(
     *     path="/api/shops/{shop}/hours",
     *     summary="Create shop hours",
     *     tags={"Shop Hours"},
     *     @OA\Parameter(
     *         name="shop",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/ShopHourRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Shop hours created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/ShopHour")
     *     )
     * )
     */
    public function store(ShopHourRequest $request, $shopId): JsonResponse
    {
        $shopHour = ShopHour::create([
            'shop_id' => $shopId,
            'weekday' => $request->weekday,
            'open_time' => $request->open_time,
            'close_time' => $request->close_time,
            'is_closed' => $request->is_closed ?? false
        ]);

        return response()->json([
            'message' => __('messages.shop_hours.created'),
            'data' => $shopHour
        ], 201);
    }

    /**
     * @OA\Put(
     *     path="/api/shops/{shop}/hours/{hour}",
     *     summary="Update shop hours",
     *     tags={"Shop Hours"},
     *     @OA\Parameter(
     *         name="shop",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="hour",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/ShopHourRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Shop hours updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/ShopHour")
     *     )
     * )
     */
    public function update(ShopHourRequest $request, $shopId, $id): JsonResponse
    {
        $shopHour = ShopHour::where('shop_id', $shopId)
            ->where('id', $id)
            ->firstOrFail();

        $shopHour->update($request->validated());

        return response()->json([
            'message' => __('messages.shop_hours.updated'),
            'data' => $shopHour
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/shops/{shop}/hours/{hour}",
     *     summary="Delete shop hours",
     *     tags={"Shop Hours"},
     *     @OA\Parameter(
     *         name="shop",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="hour",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Shop hours deleted successfully"
     *     )
     * )
     */
    public function destroy($shopId, $id): JsonResponse
    {
        $shopHour = ShopHour::where('shop_id', $shopId)
            ->where('id', $id)
            ->firstOrFail();

        $shopHour->delete();

        return response()->json([
            'message' => __('messages.shop_hours.deleted')
        ]);
    }
}
