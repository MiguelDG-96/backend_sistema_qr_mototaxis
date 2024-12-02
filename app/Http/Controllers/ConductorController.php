<?php

namespace App\Http\Controllers;

use App\Models\Conductor;
use App\Models\Asociacion;
use Illuminate\Http\Request;

class ConductorController extends Controller
{
    // Método para listar todos los conductores
    public function index()
    {
        // Obtiene todos los conductores activos junto con su asociación
        $conductores = Conductor::with('asociacion')->where('estado', 1)->get();
        $asociaciones = Asociacion::where('estado', 1)->get();

        // Retorna la vista con los datos necesarios
        return view('conductores', compact('conductores', 'asociaciones'));
    }

    // Método para registrar un nuevo conductor
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'nombre' => 'required|string|max:100',
            'dni' => 'required|string|size:8|unique:conductores,dni',
            'direccion' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'id_asociacion' => 'required|exists:asociaciones,id',
        ]);

        // Crear el nuevo conductor
        Conductor::create([
            'nombre' => $request->nombre,
            'dni' => $request->dni,
            'direccion' => $request->direccion,
            'telefono' => $request->telefono,
            'id_asociacion' => $request->id_asociacion,
            'estado' => 1, // Estado por defecto al registrar un nuevo conductor
        ]);

        // Redirigir con mensaje de éxito
        return redirect()->route('conductores.index')->with('success', 'Conductor registrado exitosamente.');
    }

    // Método para actualizar un conductor
    public function update(Request $request, $id)
    {
        // Buscar el conductor por ID
        $conductor = Conductor::findOrFail($id);

        // Validar los datos del formulario
        $request->validate([
            'nombre' => 'sometimes|required|string|max:100',
            'dni' => 'sometimes|required|string|size:8|unique:conductores,dni,' . $conductor->id,
            'direccion' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'id_asociacion' => 'sometimes|required|exists:asociaciones,id',
        ]);

        // Actualizar los datos del conductor
        $conductor->update($request->only([
            'nombre',
            'dni',
            'direccion',
            'telefono',
            'id_asociacion',
        ]));

        // Redirigir con mensaje de éxito
        return redirect()->route('conductores.index')->with('success', 'Conductor actualizado exitosamente.');
    }

    // Método para desactivar un conductor
    public function destroy($id)
    {
        // Buscar el conductor por ID
        $conductor = Conductor::find($id);

        // Verificar si existe
        if (!$conductor) {
            return redirect()->route('conductores.index')->withErrors(['error' => 'Conductor no encontrado.']);
        }

        // Cambiar el estado a 0 en lugar de eliminar el registro
        $conductor->update(['estado' => 0]);

        // Redirigir con mensaje de éxito
        return redirect()->route('conductores.index')->with('success', 'Conductor desactivado correctamente.');
    }
}
