<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permiso extends Model
{
    use HasFactory;

    protected $table = 'permisos';
    protected $fillable = ['id_vehiculo', 'id_conductor', 'codigo_qr', 'fecha_emision', 'fecha_expiracion', 'estado'];

    // Relación con la tabla Vehiculo
    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class, 'id_vehiculo');
    }

    // Relación con la tabla Conductor
    public function conductor()
    {
        return $this->belongsTo(Conductor::class, 'id_conductor');
    }
}
