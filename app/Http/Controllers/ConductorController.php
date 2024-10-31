<?php

namespace App\Http\Controllers;

use App\Models\Conductor;
use Illuminate\Http\Request;

class ConductorController extends Controller
{
    // Método para listar todos los conductores
    public function index()
    {
        $conductores = Conductor::with('asociacion')->get();
        return response()->json($conductores);
    }

    // Método para registrar un nuevo conductor
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'dni' => 'required|string|size:8|unique:conductores,dni',
            'direccion' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'id_asociacion' => 'required|exists:asociaciones,id',
            'estado' => 'required|boolean',
        ]);

        $conductor = Conductor::create($request->all());

        return response()->json(['conductor' => $conductor], 201);
    }

    public function show($id)
    {
        $conductor = Conductor::with('asociacion')->find($id);

        if (!$conductor) {
            return response()->json(['message' => 'Conductor no encontrado'], 404);
        }

        return response()->json($conductor);
    }

    // Método para actualizar un conductor
    public function update(Request $request, $id)
    {
        $conductor = Conductor::findOrFail($id);
        $request->validate([
            'nombre' => 'sometimes|required|string|max:100',
            'dni' => 'sometimes|required|string|size:8|unique:conductores,dni,' . $conductor->id,
            'direccion' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'id_asociacion' => 'sometimes|required|exists:asociaciones,id',
            'estado' => 'sometimes|required|boolean',
        ]);

        $conductor->update($request->all());

        return response()->json(['conductor' => $conductor]);
    }

    // Método para eliminar un conductor
    public function destroy($id)
    {
        $conductor = Conductor::find($id);

        if (!$conductor) {
            return response()->json(['message' => 'Conductor no encontrado'], 404);
        }

        // Cambiar el estado a 0 en lugar de eliminar el registro
        $conductor->estado = 0;
        $conductor->save();

        return response()->json(['message' => 'Conductor desactivado']);
    }
}
