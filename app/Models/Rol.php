<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    use HasFactory;

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = ['nombre', 'descripcion'];

    protected $table = 'rols';
    /**
     * Relación con el modelo User.
     * Un rol puede estar asociado a varios usuarios.
     */
    public function users()
    {
        return $this->hasMany(User::class, 'id_rol');
    }
}
