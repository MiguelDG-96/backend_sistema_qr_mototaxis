<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users'; // Asegúrate de que sea el nombre correcto de la tabla


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

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Definición de la relación con el modelo Rol
    public function rol()
    {
        return $this->belongsTo(Rol::class, 'id_rol');
    }
}
