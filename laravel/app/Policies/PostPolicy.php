<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Post;

class PostPolicy
{
    /**
     * Determine whether the user can view any posts.
     */
    public function viewAny(User $user): bool
    {
        return true; // TOTHOM pot llistar i visualitzar posts
    }

    /**
     * Determine whether the user can view the post.
     */
    public function view(User $user, Post $post): bool
    {
        return true; // TOTHOM pot llistar i visualitzar posts
    }

    /**
     * Determine whether the user can create posts.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('author'); // Només els usuaris amb rol “author” poden crear-ne i la resta no
    }

    /**
     * Determine whether the user can update the post.
     */
    public function update(User $user, Post $post): bool
    {
        return $user->hasRole('author') && $user->id === $post->author_id;
        // Els usuaris amb rol “author” poden editar els seu propis posts
    }

    /**
     * Determine whether the user can delete the post.
     */
    public function delete(User $user, Post $post): bool
    {
        return ($user->hasRole('author') && $user->id === $post->author_id) || $user->hasRole('editor');
        // Els usuaris amb rol “author” poden eliminar els seu propis posts, els usuaris amb rol “editor” poden eliminar qualsevol post
    }

    /**
     * Determine whether the user can like the post.
     */
    public function like(User $user, Post $post): bool
    {
        return $user->hasRole('author') && !$post->likedBy($user);
    }

    /**
     * Determine whether the user can unlike the post.
     */
    public function unlike(User $user, Post $post): bool
    {
        return $user->hasRole('author') && $post->likedBy($user);
    }
}
