<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Place;
use Illuminate\Http\Request;

class PlaceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['index', 'show']);
    }
    
    public function index()
    {
        $places = Place::with('author')->get(); 
        return response()->json($places);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required|string',
        ]);

        $validatedData['author_id'] = auth()->id();

        $place = Place::create($validatedData);
        return response()->json($place, 201);
    }

    public function show($id)
    {
        $place = Place::with('author')->findOrFail($id);
        return response()->json($place);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required|string',
        ]);

        $place = Place::findOrFail($id);
        $place->update($validatedData);
        return response()->json($place);
    }

    public function destroy($id)
    {
        $place = Place::findOrFail($id);
        $place->delete();
        return response()->json(null, 204);
    }

    public function favorite(Request $request, $id)
    {
        $place = Place::findOrFail($id);
        $request->user()->favoritePlaces()->attach($place->id);

        return response()->json(['message' => 'Added to favorites']);
    }

    public function unfavorite(Request $request, $id)
    {
        $place = Place::findOrFail($id);
        $request->user()->favoritePlaces()->detach($place->id);

        return response()->json(['message' => 'Removed from favorites']);
    }

}
