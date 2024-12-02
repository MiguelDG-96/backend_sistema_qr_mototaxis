<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'descripcion'];

    // Especificar el nombre de la tabla
    protected $table = 'rols';

    /**
     * Relación con el modelo User.
     * Un rol puede estar asociado a varios usuarios.
     */
    public function users()
    {
        return $this->hasMany(User::class, 'id_rol');
    }

    /**
     * Relación con el modelo PermisoAcceso.
     * Un rol puede tener varios permisos.
     */
    public function permisos()
    {
        return $this->belongsToMany(PermisoAcceso::class, 'rol_permisos', 'rol_id', 'permiso_acceso_id');
    }
}
