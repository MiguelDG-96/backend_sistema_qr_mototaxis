<?php

namespace App\Http\Controllers;

use App\Models\Reporte;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReporteController extends Controller
{
    // Método para listar todos los reportes
    public function index()
    {
        $reportes = Reporte::with('usuario')->get();
        return response()->json($reportes);
    }

    // Método para crear un nuevo reporte
    public function store(Request $request)
    {
        $request->validate([
            'id_usuario' => 'nullable|exists:users,id',
            'tipo_reporte' => 'required|in:Permisos por vencer,Permisos vencidos,Asociaciones inscritas',
        ]);

        $reporte = Reporte::create([
            'id_usuario' => $request->id_usuario,
            'tipo_reporte' => $request->tipo_reporte,
        ]);

        return response()->json(['reporte' => $reporte], 201);
    }

    // Método para eliminar un reporte
    public function destroy($id)
    {
        Reporte::destroy($id);
        return response()->json(['message' => 'Reporte eliminado']);
    }
}
