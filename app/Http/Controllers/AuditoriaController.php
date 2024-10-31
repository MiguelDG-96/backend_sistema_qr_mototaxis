<?php

namespace App\Http\Controllers;

use App\Models\Auditoria;
use Illuminate\Http\Request;

class AuditoriaController extends Controller
{
    // Método para listar todos los registros de auditoría
    public function index()
    {
        $auditoria = Auditoria::with('usuario')->get();
        return response()->json($auditoria);
    }

    // Método para registrar una nueva acción en auditoría
    public function store(Request $request)
    {
        $request->validate([
            'id_usuario' => 'required|exists:users,id',
            'accion' => 'required|string|max:255',
        ]);

        $auditoria = Auditoria::create([
            'id_usuario' => $request->id_usuario,
            'accion' => $request->accion,
            'fecha' => now(),
        ]);

        return response()->json(['auditoria' => $auditoria], 201);
    }

    // Método para eliminar un registro de auditoría
    public function destroy($id)
    {
        Auditoria::destroy($id);
        return response()->json(['message' => 'Registro de auditoría eliminado']);
    }
}
