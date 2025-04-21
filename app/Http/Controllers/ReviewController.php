<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\Review;
use Illuminate\Validation\Rule;

class ReviewController extends Controller
{
    public function index(Shop $shop)
    {
        return response()->json($shop->reviews);
    }

    public function store(Request $request, Shop $shop)
    {
        $data = $request->validate([
            'rating'  => 'required|numeric|min:0|max:5',
            'comment' => 'nullable|string',
            'type'    => ['required', Rule::in(['good', 'neutral', 'bad'])],
        ]);
        $data['user_id'] = $request->user()->id;
        $review = $shop->reviews()->create($data);
        return response()->json($review, 201);
    }

    public function update(Request $request, Shop $shop, Review $review)
    {
        $this->authorize('update', $review);
        $data = $request->validate([
            'rating'  => 'sometimes|numeric|min:0|max:5',
            'comment' => 'sometimes|string',
            'type'    => ['sometimes', Rule::in(['good', 'neutral', 'bad'])],
        ]);
        $review->update($data);
        return response()->json($review);
    }
}
