<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\Post;

class CommentController extends Controller
{
    public function store(Request $request, $postId)
    {
        $request->validate([
            'body' => 'required|string',
        ]);
    
        $post = Post::find($postId);
    
        if (!$post) {
            return redirect()->route('posts.index')->with('error', 'Post not found');
        }
    
        Comment::create([
            'post_id' => $postId,
            'user_id' => Auth::id(),
            'body' => $request->input('body'),
        ]);
    
        return redirect()->route('posts.show', $postId)->with('success', 'Comment added successfully');
    }

    public function destroy($postId, $commentId)
    {
        $comment = Comment::where('post_id', $postId)->findOrFail($commentId);
        
        // Asegúrate de que el usuario autenticado sea el propietario del comentario o un administrador
        if (Auth::id() !== $comment->user_id && !Auth::user()->isAdmin()) {
            return response()->json(['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }
    
        $comment->delete();
    
        return response()->json(['message' => 'Comment deleted successfully'], Response::HTTP_NO_CONTENT);
    }
}