<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Place;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['index', 'show']);
    }
    
    public function index(Place $place)
    {
        return response()->json($place->reviews);
    }

    public function store(Request $request, $placeId)
    {
        $request->validate([
            'comment' => 'required',
            'rating' => 'required|integer|between:1,5',
        ]);

        $review = new Review();
        $review->place_id = $placeId;
        $review->user_id = auth()->id();
        $review->comment = $request->comment;
        $review->rating = $request->rating;
        $review->save();

        return redirect()->route('places.show', $placeId)->with('success', 'Review added successfully.');
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

     /**
     * Remove the specified review from storage.
     *
     * @param  int  $placeId
     * @param  int  $reviewId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($placeId, $reviewId)
    {
        $review = Review::where('place_id', $placeId)->where('id', $reviewId)->firstOrFail();

        // Comprovar si l'usuari actual té permís per eliminar la ressenya
        $this->authorize('delete', $review);

        // Si passa l'autorització, eliminar la ressenya
        $review->delete();

        // Redirigir a la pàgina del lloc amb un missatge d'èxit
        return redirect()->route('places.show', $placeId)->with('success', 'Review deleted successfully.');
    }
}
