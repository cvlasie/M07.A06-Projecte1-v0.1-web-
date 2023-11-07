<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    use HasFactory;

    // Asegúrate de agregar todos los campos que son asignables en masa
    protected $fillable = ['name', 'description', 'media_path', /* otros campos que tengas */];

    // Si tienes relaciones con otros modelos, puedes definirlas aquí

    // Por ejemplo, si un lugar pertenece a un usuario, podrías tener:
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Si un lugar tiene múltiples archivos multimedia, podrías tener:
    public function files()
    {
        return $this->hasMany(File::class);
    }

    // Si un lugar tiene comentarios o reseñas, podrías tener:
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function file()
    {
        return $this->belongsTo(File::class);
    }

}
