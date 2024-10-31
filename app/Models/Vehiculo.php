<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    use HasFactory;

    protected $table = 'vehiculos';
    protected $fillable = ['placa', 'marca', 'modelo', 'anio', 'id_conductor', 'estado'];

    // Relación con la tabla Conductor
    public function conductor()
    {
        return $this->belongsTo(Conductor::class, 'id_conductor');
    }
}
