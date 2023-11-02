<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;

class CommentController extends Controller
{
    public function store(Request $request, $postId)
    {
        $request->validate([
            'content' => 'required',
        ]);

        $post = Post::find($postId);

        if (!$post) {
            return redirect()->route('posts.index')->with('error', 'El post no se encontró');
        }

        $comment = new Comment();
        $comment->content = $request->input('content');
        $comment->user_id = auth()->user()->id;

        // Asociar el comentario al post
        $post->comments()->save($comment);

        return redirect()->back()->with('success', 'Comentario agregado correctamente');
    }
}
