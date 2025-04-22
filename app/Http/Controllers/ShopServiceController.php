<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShopServiceRequest;
use App\Models\ShopService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Shop Services",
 *     description="Shop services management endpoints"
 * )
 */
class ShopServiceController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/shops/{shop}/services",
     *     summary="Get all services for a shop",
     *     tags={"Shop Services"},
     *     @OA\Parameter(
     *         name="shop",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of shop services",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/ShopService")
     *         )
     *     )
     * )
     */
    public function index(Request $request, $shopId): JsonResponse
    {
        $services = ShopService::where('shop_id', $shopId)
            ->with('service')
            ->get();

        return response()->json([
            'data' => $services
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/shops/{shop}/services",
     *     summary="Add a service to shop",
     *     tags={"Shop Services"},
     *     @OA\Parameter(
     *         name="shop",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/ShopServiceRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Service added successfully",
     *         @OA\JsonContent(ref="#/components/schemas/ShopService")
     *     )
     * )
     */
    public function store(ShopServiceRequest $request, $shopId): JsonResponse
    {
        $service = ShopService::create([
            'shop_id' => $shopId,
            'service_id' => $request->service_id,
            'price' => $request->price
        ]);

        return response()->json([
            'message' => __('messages.shop_service.created'),
            'data' => $service
        ], 201);
    }

    /**
     * @OA\Put(
     *     path="/api/shops/{shop}/services/{service}",
     *     summary="Update service price",
     *     tags={"Shop Services"},
     *     @OA\Parameter(
     *         name="shop",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="service",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/ShopServiceRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Service price updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/ShopService")
     *     )
     * )
     */
    public function update(ShopServiceRequest $request, $shopId, $id): JsonResponse
    {
        $service = ShopService::where('shop_id', $shopId)
            ->where('id', $id)
            ->firstOrFail();

        $service->update($request->validated());

        return response()->json([
            'message' => __('messages.shop_service.updated'),
            'data' => $service
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/shops/{shop}/services/{service}",
     *     summary="Remove service from shop",
     *     tags={"Shop Services"},
     *     @OA\Parameter(
     *         name="shop",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="service",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Service removed successfully"
     *     )
     * )
     */
    public function destroy($shopId, $id): JsonResponse
    {
        $service = ShopService::where('shop_id', $shopId)
            ->where('id', $id)
            ->firstOrFail();

        $service->delete();

        return response()->json([
            'message' => __('messages.shop_service.deleted')
        ]);
    }
}
