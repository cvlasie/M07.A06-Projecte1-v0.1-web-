<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function likes()
    {
        return $this->belongsToMany(Post::class, 'likes');
    }

    public function favorites()
    {
        return $this->belongsToMany(Place::class, 'favorites');
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Verifica si el usuario tiene el rol especificado.
     *
     * @param string $role
     * @return bool
     */
    public function hasRole(string $role): bool
    {
        // Aquí puedes implementar la lógica para verificar el rol del usuario.
        // En este ejemplo, se compara el nombre del rol con el proporcionado.
        return $this->role->name === $role;
    }

    /**
     * Determina si el usuario tiene acceso al panel de administración de Filament.
     *
     * @return bool
     */
    public function canAccessFilament(): bool
    {
        // Verifica si el usuario tiene el rol de "admin" o "editor".
        return $this->hasRole('admin') || $this->hasRole('editor');
    }
}
