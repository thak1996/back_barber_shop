<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use App\Http\Requests\FavoriteShopRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * @OA\Tag(
 *     name="Favorite Shops",
 *     description="Endpoints para gerenciar lojas favoritas"
 * )
 */
class FavoriteShopController extends Controller
{
    /**
     * @OA\Post(
     *     path="/favorite-shops",
     *     tags={"Favorite Shops"},
     *     summary="Adicionar loja aos favoritos",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"shop_id"},
     *             @OA\Property(property="shop_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Loja adicionada aos favoritos com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Added to favorites")
     *         )
     *     ),
     *     @OA\Response(response=400, description="Loja já está nos favoritos"),
     *     @OA\Response(response=404, description="Loja não encontrada"),
     *     @OA\Response(response=422, description="Erro de validação")
     * )
     */
    public function store(FavoriteShopRequest $request)
    {
        try {
            $data = $request->validated();
            $user = $request->user();

            if ($user->favoriteShops()->where('shop_id', $data['shop_id'])->exists()) {
                return response()->json([
                    'error' => __('messages.favorite.already_exists')
                ], 400);
            }

            $user->favoriteShops()->attach($data['shop_id']);

            return response()->json([
                'message' => __('messages.favorite.added')
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error adding to favorites: ' . $e->getMessage());
            return response()->json([
                'error' => __('messages.error.server_error')
            ], 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/favorite-shops/{shop}",
     *     tags={"Favorite Shops"},
     *     summary="Remover loja dos favoritos",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="shop",
     *         in="path",
     *         required=true,
     *         description="ID da loja",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Loja removida dos favoritos com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Removed from favorites")
     *         )
     *     ),
     *     @OA\Response(response=404, description="Loja não encontrada nos favoritos")
     * )
     */
    public function destroy(Request $request, Shop $shop)
    {
        try {
            $user = $request->user();

            if (!$user->favoriteShops()->where('shop_id', $shop->id)->exists()) {
                return response()->json([
                    'error' => __('messages.favorite.not_found')
                ], 404);
            }

            $user->favoriteShops()->detach($shop->id);

            return response()->json([
                'message' => __('messages.favorite.removed')
            ]);
        } catch (\Exception $e) {
            Log::error('Error removing from favorites: ' . $e->getMessage());
            return response()->json([
                'error' => __('messages.error.server_error')
            ], 500);
        }
    }
}
