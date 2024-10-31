<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
    use HasFactory;

    protected $table = 'notificaciones';
    protected $fillable = ['id_usuario', 'id_permiso', 'mensaje', 'tipo', 'leido'];

    // Relación con el modelo Usuario
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    // Relación con el modelo Permiso
    public function permiso()
    {
        return $this->belongsTo(Permiso::class, 'id_permiso');
    }
}
