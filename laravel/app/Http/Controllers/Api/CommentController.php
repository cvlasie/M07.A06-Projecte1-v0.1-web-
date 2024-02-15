<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;


class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['index', 'show']);
    }
    
    public function index($postId)
    {
        $comments = Comment::with('user')->where('post_id', $postId)->get();
        return response()->json(['comments' => $comments], Response::HTTP_OK);
    }

    public function show($postId, $commentId)
    {
        $comment = Comment::where('post_id', $postId)->findOrFail($commentId);
        return response()->json(['comment' => $comment], Response::HTTP_OK);
    }

    public function store(Request $request, $postId)
    {
        $request->validate([
            'body' => 'required|string',
        ]);
        
        $comment = Comment::create([
            'post_id' => $postId,
            'user_id' => Auth::id(),
            'body' => $request->input('body'),
        ]);
        
        return response()->json(['comment' => $comment], Response::HTTP_CREATED);
    }

    public function update(Request $request, $postId, $commentId)
    {
        $request->validate([
            'body' => 'required|string',
        ]);

        $comment = Comment::where('post_id', $postId)->findOrFail($commentId);
        $comment->update([
            'body' => $request->input('body'),
        ]);

        return response()->json(['comment' => $comment], Response::HTTP_OK);
    }

    public function destroy($postId, $commentId)
    {
        $comment = Comment::where('post_id', $postId)->findOrFail($commentId);
    
        // Asegúrate de que el usuario autenticado sea el propietario del comentario o un administrador
        if (Auth::id() !== $comment->user_id && !Auth::user()->isAdmin()) {
            return response()->json(['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }
    
        $comment->delete();
    
        return response()->json(['message' => 'Comment deleted successfully'], Response::HTTP_OK);
    }
}