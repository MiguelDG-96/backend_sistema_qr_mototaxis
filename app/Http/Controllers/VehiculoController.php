<?php

namespace App\Http\Controllers;

use App\Models\Vehiculo;
use App\Models\Conductor;
use Illuminate\Http\Request;

class VehiculoController extends Controller
{
    // Método para listar todos los vehículos
    public function index()
    {
        $vehiculos = Vehiculo::with('conductor')->where('estado', 1)->get();
        $conductores = Conductor::where('estado', 1)->get(); // Obtener conductores activos
        return view('vehiculos', compact('vehiculos', 'conductores'));
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
        ]);

        Vehiculo::create($request->all());

        return redirect()->route('vehiculos.index')->with('success', 'Vehículo registrado exitosamente.');
    }

    // Método para mostrar un vehículo (opcional para edición)
    public function show($id)
    {
        $vehiculo = Vehiculo::with('conductor')->findOrFail($id);
        return view('vehiculos.show', compact('vehiculo'));
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
        ]);

        $vehiculo->update($request->all());

        return redirect()->route('vehiculos.index')->with('success', 'Vehículo actualizado exitosamente.');
    }

    // Método para desactivar un vehículo
    public function destroy($id)
    {
        $vehiculo = Vehiculo::find($id);

        if (!$vehiculo) {
            return redirect()->route('vehiculos.index')->withErrors(['message' => 'Vehículo no encontrado.']);
        }

        $vehiculo->estado = 0;
        $vehiculo->save();

        return redirect()->route('vehiculos.index')->with('success', 'Vehículo desactivado exitosamente.');
    }
}
