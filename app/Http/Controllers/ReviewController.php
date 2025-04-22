<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\Review;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

/**
 * @OA\Tag(
 *     name="Reviews",
 *     description="Shop review management endpoints"
 * )
 */
class ReviewController extends Controller
{
    /**
     * @OA\Get(
     *     path="/shops/{shop}/reviews",
     *     tags={"Reviews"},
     *     summary="Get all reviews for a shop",
     *     @OA\Parameter(
     *         name="shop",
     *         in="path",
     *         required=true,
     *         description="Shop ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of reviews",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Review")
     *         )
     *     ),
     *     @OA\Response(response=404, description="Shop not found")
     * )
     */
    public function index(Shop $shop)
    {
        try {
            return response()->json($shop->reviews);
        } catch (\Exception $e) {
            Log::error('Error fetching reviews: ' . $e->getMessage());
            return response()->json(['error' => __('messages.error.server_error')], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/shops/{shop}/reviews",
     *     tags={"Reviews"},
     *     summary="Create a new review for a shop",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="shop",
     *         in="path",
     *         required=true,
     *         description="Shop ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"rating", "type"},
     *             @OA\Property(property="rating", type="number", format="float", example=4.5),
     *             @OA\Property(property="comment", type="string", example="Great service!"),
     *             @OA\Property(property="type", type="string", enum={"good", "neutral", "bad"}, example="good")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Review created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Review")
     *     ),
     *     @OA\Response(response=422, description="Validation error"),
     *     @OA\Response(response=404, description="Shop not found")
     * )
     */
    public function store(Request $request, Shop $shop)
    {
        try {
            $data = $request->validate([
                'rating'  => 'required|numeric|min:0|max:5',
                'comment' => 'nullable|string',
                'type'    => ['required', Rule::in(['good', 'neutral', 'bad'])],
            ]);

            $data['user_id'] = $request->user()->id;
            $review = $shop->reviews()->create($data);

            return response()->json([
                'message' => __('messages.review.created'),
                'data' => $review
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'error' => __('messages.review.validation_error'),
                'details' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error creating review: ' . $e->getMessage());
            return response()->json(['error' => __('messages.error.server_error')], 500);
        }
    }

    /**
     * @OA\Put(
     *     path="/shops/{shop}/reviews/{review}",
     *     tags={"Reviews"},
     *     summary="Update a review",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="shop",
     *         in="path",
     *         required=true,
     *         description="Shop ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="review",
     *         in="path",
     *         required=true,
     *         description="Review ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="rating", type="number", format="float", example=4.5),
     *             @OA\Property(property="comment", type="string", example="Updated review comment"),
     *             @OA\Property(property="type", type="string", enum={"good", "neutral", "bad"}, example="good")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Review updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Review")
     *     ),
     *     @OA\Response(response=403, description="Unauthorized"),
     *     @OA\Response(response=404, description="Review not found"),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function update(Request $request, Shop $shop, Review $review)
    {
        try {
            $this->authorize('update', $review);

            $data = $request->validate([
                'rating'  => 'sometimes|numeric|min:0|max:5',
                'comment' => 'sometimes|string',
                'type'    => ['sometimes', Rule::in(['good', 'neutral', 'bad'])],
            ]);

            $review->update($data);

            return response()->json([
                'message' => __('messages.review.updated'),
                'data' => $review
            ]);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            return response()->json(['error' => __('messages.review.unauthorized')], 403);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'error' => __('messages.review.validation_error'),
                'details' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error updating review: ' . $e->getMessage());
            return response()->json(['error' => __('messages.error.server_error')], 500);
        }
    }
}
