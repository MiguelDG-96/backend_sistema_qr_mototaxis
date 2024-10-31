<?php

namespace App\Http\Controllers;

use App\Models\Permiso;
use Illuminate\Http\Request;

class PermisoController extends Controller
{
    // Método para listar todos los permisos
    public function index()
    {
        $permisos = Permiso::with(['vehiculo', 'conductor'])->get();
        return response()->json($permisos);
    }

    // Método para registrar un nuevo permiso
    public function store(Request $request)
    {
        $request->validate([
            'id_vehiculo' => 'required|exists:vehiculos,id',
            'id_conductor' => 'required|exists:conductores,id',
            'fecha_emision' => 'required|date',
            'fecha_expiracion' => 'required|date|after_or_equal:fecha_emision',
            'estado' => 'required|in:Vigente,Expirado,Suspendido',
        ]);

        // Verificar si ya existe un permiso con los mismos datos clave
        $existingPermiso = Permiso::where('id_vehiculo', $request->id_vehiculo)
            ->where('id_conductor', $request->id_conductor)
            ->first();

        if ($existingPermiso) {
            return response()->json([
                'message' => 'Ya existe un permiso con los mismos datos.'
            ], 409); // 409 Conflict
        }

        // Crear el permiso si no existe duplicado
        $permiso = Permiso::create($request->all());

        // Generar la URL única para el QR
        $qrUrl = "https://municipalidadmorales.pe/permisos/{$permiso->id}";

        // Almacenar la URL del QR en `codigo_qr`
        $permiso->codigo_qr = $qrUrl;
        $permiso->save();

        return response()->json(['permiso' => $permiso], 201);
    }


    // Método para obtener un permiso por su ID (detalle)
    public function showDetails($id)
    {
        $permiso = Permiso::with(['vehiculo', 'conductor', 'conductor.asociacion'])->find($id);

        if (!$permiso) {
            return response()->json(['message' => 'Permiso no encontrado'], 404);
        }

        // Retorna los detalles en JSON
        return response()->json($permiso);
    }

    // Método para actualizar un permiso
    public function update(Request $request, $id)
    {
        $permiso = Permiso::findOrFail($id);
        $request->validate([
            'id_vehiculo' => 'sometimes|required|exists:vehiculos,id',
            'id_conductor' => 'sometimes|required|exists:conductores,id',
            'fecha_emision' => 'sometimes|required|date',
            'fecha_expiracion' => 'sometimes|required|date|after_or_equal:fecha_emision',
            'estado' => 'sometimes|required|in:Vigente,Expirado,Suspendido',
        ]);

        $permiso->update($request->all());

        return response()->json(['permiso' => $permiso]);
    }

    // Método para eliminar un permiso
    public function destroy($id)
    {
        Permiso::destroy($id);
        return response()->json(['message' => 'Permiso eliminado']);
    }
}
