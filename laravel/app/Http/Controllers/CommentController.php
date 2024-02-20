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
        $comment = Comment::find($commentId);
    
        if (!$comment) {
            return redirect()->route('posts.index')->with('error', 'Comment not found');
        }
    
        // Verificar la autorización para eliminar el comentario
        $this->authorize('delete', $comment);
    
        $comment->delete();
    
        return redirect()->route('posts.show', $postId)->with('success', 'Comment deleted successfully');
    }
}