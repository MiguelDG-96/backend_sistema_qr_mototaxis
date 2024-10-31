<?php

namespace App\Http\Controllers;

use App\Models\Asociacion;
use Illuminate\Http\Request;

class AsociacionController extends Controller
{
    // Método para listar todas las asociaciones
    public function index()
    {
        $asociaciones = Asociacion::all();
        return response()->json($asociaciones);
    }

    // Método para crear una nueva asociación
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100|unique:asociaciones',
            'direccion' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'estado' => 'required|boolean',
        ]);

        // Crear la asociación si pasa la validación
        $asociacion = Asociacion::create($request->all());

        return response()->json(['asociacion' => $asociacion], 201);
    }

    // Método para actualizar una asociación
    public function update(Request $request, $id)
    {
        $asociacion = Asociacion::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:100|unique:asociaciones,nombre,' . $asociacion->id,
            'direccion' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'estado' => 'required|boolean',
        ]);

        $asociacion->update($request->all());

        return response()->json(['asociacion' => $asociacion]);
    }

    // Método para eliminar una asociación
    public function destroy($id)
    {
        $asociacion = Asociacion::find($id);

        if (!$asociacion) {
            return response()->json(['message' => 'Asociación no encontrada'], 404);
        }

        // Cambiar el estado a 0 en lugar de eliminar el registro
        $asociacion->estado = 0;
        $asociacion->save();

        return response()->json(['message' => 'Asociación desactivada']);
    }
}
