<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'id_rol',
        'estado',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Cambiar `casts` a una propiedad en lugar de una función
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Definición de la relación con el modelo Rol
    public function rol()
    {
        return $this->belongsTo(Rol::class, 'id_rol');
    }
}
