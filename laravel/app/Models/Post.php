<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'body',
        'file_id',
        'latitude',
        'longitude',
        'author_id'
    ];

    public function file()
    {
       return $this->belongsTo(File::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function likes()
    {
        return $this->belongsToMany(User::class, 'likes');
    }

    /**
     * Verifica si el post ha sido dado like por el usuario dado.
     */
    public function likedBy(User $user)
    {
        return $this->likes()->where('user_id', $user->id)->exists();
    }

    /**
     * Dar like al post.
     */
    public function like(User $user)
    {
        $this->likes()->attach($user->id);
    }

    /**
     * Deshacer el like al post.
     */
    public function unlike(User $user)
    {
        $this->likes()->detach($user->id);
    }
}
