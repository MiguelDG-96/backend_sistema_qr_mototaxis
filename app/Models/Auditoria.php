<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auditoria extends Model
{
    use HasFactory;

    protected $table = 'auditoria';
    protected $fillable = ['id_usuario', 'accion', 'fecha'];
    public $timestamps = false; // Desactiva created_at y updated_at

    // Relación con el modelo User
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }
}
