<?php

namespace App\Http\Controllers;

use App\Models\Vehiculo;
use Illuminate\Http\Request;

class VehiculoController extends Controller
{
    // Método para listar todos los vehículos
    public function index()
    {
        $vehiculos = Vehiculo::with('conductor')->get();
        return response()->json($vehiculos);
    }

    // Método para registrar un nuevo vehículo
    public function store(Request $request)
    {
        $request->validate([
            'placa' => 'required|string|max:10|unique:vehiculos,placa',
            'marca' => 'required|string|max:50',
            'modelo' => 'required|string|max:50',
            'anio' => 'required|integer',
            'id_conductor' => 'required|exists:conductores,id',
            'estado' => 'required|boolean',
        ]);

        $vehiculo = Vehiculo::create($request->all());

        return response()->json(['vehiculo' => $vehiculo], 201);
    }

    // Método para obtener un vehículo por su ID
    public function show($id)
    {
        $vehiculo = Vehiculo::with('conductor')->find($id);

        if (!$vehiculo) {
            return response()->json(['message' => 'Vehículo no encontrado'], 404);
        }

        return response()->json($vehiculo);
    }

    // Método para actualizar un vehículo
    public function update(Request $request, $id)
    {
        $vehiculo = Vehiculo::findOrFail($id);
        $request->validate([
            'placa' => 'sometimes|required|string|max:10|unique:vehiculos,placa,' . $vehiculo->id,
            'marca' => 'sometimes|required|string|max:50',
            'modelo' => 'sometimes|required|string|max:50',
            'anio' => 'sometimes|required|integer',
            'id_conductor' => 'sometimes|required|exists:conductores,id',
            'estado' => 'sometimes|required|boolean',
        ]);

        $vehiculo->update($request->all());

        return response()->json(['vehiculo' => $vehiculo]);
    }

    public function destroy($id)
    {
        $vehiculo = Vehiculo::find($id);

        if (!$vehiculo) {
            return response()->json(['message' => 'Vehículo no encontrado'], 404);
        }

        // Cambiar el estado a 0 en lugar de eliminar el registro
        $vehiculo->estado = 0;
        $vehiculo->save();

        return response()->json(['message' => 'Vehículo desactivado']);
    }
}
