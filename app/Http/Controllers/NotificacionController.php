<?php

namespace App\Http\Controllers;

use App\Models\Notificacion;
use Illuminate\Http\Request;

class NotificacionController extends Controller
{
    // Método para listar todas las notificaciones
    public function index()
    {
        $notificaciones = Notificacion::with(['usuario', 'permiso'])->get();
        return response()->json($notificaciones);
    }

    // Método para crear una nueva notificación
    public function store(Request $request)
    {
        $request->validate([
            'id_usuario' => 'required|exists:users,id',
            'id_permiso' => 'required|exists:permisos,id',
            'mensaje' => 'required|string',
            'tipo' => 'required|in:Expiración,Alerta,Sanción',
        ]);

        $notificacion = Notificacion::create([
            'id_usuario' => $request->id_usuario,
            'id_permiso' => $request->id_permiso,
            'mensaje' => $request->mensaje,
            'tipo' => $request->tipo,
            'leido' => 0,
        ]);

        return response()->json(['notificacion' => $notificacion], 201);
    }

    // Método para marcar una notificación como leída
    public function markAsRead($id)
    {
        $notificacion = Notificacion::findOrFail($id);
        $notificacion->leido = 1;
        $notificacion->save();

        return response()->json(['message' => 'Notificación marcada como leída']);
    }

    // Método para eliminar una notificación
    public function destroy($id)
    {
        Notificacion::destroy($id);
        return response()->json(['message' => 'Notificación eliminada']);
    }
}
