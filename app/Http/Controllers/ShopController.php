<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Requests\CreateShopRequest;
use App\Http\Requests\UpdateShopRequest;

/**
 * @OA\Tag(
 *     name="Shops",
 *     description="Endpoints para gerenciamento de barbearias"
 * )
 */
class ShopController extends Controller
{
    /**
     * @OA\Get(
     *     path="/shops",
     *     summary="Lista todas as barbearias",
     *     tags={"Shops"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de barbearias"
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        $shops = Shop::with('user')->get();

        return response()->json([
            'status' => 'success',
            'data' => $shops
        ]);
    }

    /**
     * @OA\Post(
     *     path="/shops",
     *     summary="Cria uma nova barbearia (apenas ADMIN)",
     *     tags={"Shops"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=201,
     *         description="Barbearia criada com sucesso"
     *     )
     * )
     */
    public function store(CreateShopRequest $request): JsonResponse
    {
        if (!auth()->user()->role->isAdmin()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized'
            ], 403);
        }

        // Criar usuário da barbearia
        $shopUser = User::create([
            'name' => $request->owner_name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => UserRole::SHOP->value
        ]);

        // Criar barbearia
        $shop = Shop::create([
            'user_id' => $shopUser->id,
            'company_name' => $request->company_name,
            'primary_color' => $request->primary_color ?? '#000000',
            'secondary_color' => $request->secondary_color ?? '#FFFFFF',
            'logo_url' => $request->logo_url
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Shop created successfully',
            'data' => $shop->load('user')
        ], 201);
    }

    /**
     * @OA\Get(
     *     path="/shops/{id}",
     *     summary="Mostra detalhes de uma barbearia",
     *     tags={"Shops"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalhes da barbearia"
     *     )
     * )
     */
    public function show(Shop $shop): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data' => $shop->load(['user', 'hours', 'services'])
        ]);
    }

    /**
     * @OA\Put(
     *     path="/shops/{id}",
     *     summary="Atualiza uma barbearia (ADMIN ou própria barbearia)",
     *     tags={"Shops"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Barbearia atualizada com sucesso"
     *     )
     * )
     */
    public function update(UpdateShopRequest $request, Shop $shop): JsonResponse
    {
        $user = auth()->user();

        if (!$user->role->isAdmin() && $shop->user_id !== $user->id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized'
            ], 403);
        }

        $shop->update($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Shop updated successfully',
            'data' => $shop->fresh()->load('user')
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/shops/{id}",
     *     summary="Remove uma barbearia (apenas ADMIN)",
     *     tags={"Shops"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Barbearia removida com sucesso"
     *     )
     * )
     */
    public function destroy(Shop $shop): JsonResponse
    {
        if (!auth()->user()->role->isAdmin()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized'
            ], 403);
        }

        $shop->user()->delete();
        $shop->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Shop deleted successfully'
        ]);
    }
}
