<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'content', 'user_id', 'media_path', 'likes'];

    // Relación 1:1 (One to One) con el modelo File
    public function file()
    {
        return $this->hasOne(File::class);
    }

    public function post()
    {
        return $this->hasOne(Post::class);
    }

    // Relación 1:N (One to Many) con el modelo User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }    

    public function author()
    {
        return $this->belongsTo(User::class);
    }
    
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
