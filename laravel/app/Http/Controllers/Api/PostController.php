<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['index', 'show']);
    }
    
    public function index()
    {
        $posts = Post::with('author')->get(); 
        return response()->json($posts);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'body' => 'required|max:255',
            'file_id' => 'required|exists:files,id',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);
    
        $validatedData['author_id'] = $request->user()->id;
    
        $post = Post::create($validatedData);
    
        return response()->json($post, 201);
    }

    public function show($id)
    {
        $post = Post::with('author')->findOrFail($id);
        return response()->json($post);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'body' => 'required|max:255',
            'file_id' => 'required|exists:files,id',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);
    
        $post = Post::findOrFail($id);
    
        if ($request->user()->id !== $post->author_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
    
        $post->update($validatedData);
    
        return response()->json($post);
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
        return response()->json(null, 204);
    }

    public function like(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        $request->user()->likePosts()->attach($post->id);

        return response()->json(['message' => 'Added to likes']);
    }

    public function unlike(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        $request->user()->likePosts()->detach($post->id);

        return response()->json(['message' => 'Removed from likes']);
    }

}