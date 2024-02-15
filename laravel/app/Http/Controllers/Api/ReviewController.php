<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Place;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function index(Place $place)
    {
        return response()->json($place->reviews);
    }

    public function store(Request $request, Place $place)
    {
        $this->validate($request, [
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string',
        ]);

        $review = new Review($request->all());
        $review->user_id = Auth::id(); 
        $place->reviews()->save($review);

        return response()->json($review, 201);
    }

    public function show(Place $place, Review $review)
    {
        return response()->json($review);
    }

    public function update(Request $request, Place $place, Review $review)
    {
        $this->validate($request, [
            'rating' => 'sometimes|required|integer|min:1|max:5',
            'comment' => 'sometimes|required|string',
        ]);

        $review->fill($request->all());
        $review->save();

        return response()->json($review);
    }

    public function destroy(Place $place, Review $review)
    {
        $review->delete();

        return response()->json(null, 204);
    }
}
