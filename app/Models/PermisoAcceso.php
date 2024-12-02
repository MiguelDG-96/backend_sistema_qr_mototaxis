<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermisoAcceso extends Model
{
    use HasFactory;

    // Especifica el nombre correcto de la tabla
    protected $table = 'permisos_acceso';

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    /**
     * Relación con el modelo Role.
     * Un permiso puede pertenecer a varios roles.
     */
    public function roles()
    {
        return $this->belongsToMany(Rol::class, 'rol_permisos', 'permiso_acceso_id', 'rol_id');
    }
}
