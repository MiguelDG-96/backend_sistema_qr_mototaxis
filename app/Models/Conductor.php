<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conductor extends Model
{
    use HasFactory;

    protected $table = 'conductores';
    protected $fillable = ['nombre', 'dni', 'direccion', 'telefono', 'id_asociacion', 'estado'];

    // Relación con la tabla Asociacion
    public function asociacion()
    {
        return $this->belongsTo(Asociacion::class, 'id_asociacion');
    }
}
