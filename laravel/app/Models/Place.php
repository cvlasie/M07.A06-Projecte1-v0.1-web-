<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'description',
        'file_id',
        'latitude',
        'longitude',
        'author_id',
        'visibility_id',
    ];

    public function file()
    {
        return $this->belongsTo(File::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
    
    public function favorited()
    {
        return $this->belongsToMany(User::class, 'favorites');
    }

    // Relació amb Visibility
    public function visibility() {
        return $this->belongsTo(Visibility::class);
    }

    use HasSEO;

    protected function getDynamicSEOData(): SEOData
    {
        return new SEOData(
            title: $this->title,
            description: $this->excerpt,
            author: $this->author->fullName,
        );
    }
}
