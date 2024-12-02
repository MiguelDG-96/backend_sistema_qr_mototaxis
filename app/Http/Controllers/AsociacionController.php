<?php

namespace App\Http\Controllers;

use App\Models\Asociacion;
use Illuminate\Http\Request;

class AsociacionController extends Controller
{
    // Método para listar todas las asociaciones
    public function index()
    {
        // Obtiene todas las asociaciones activas
        $asociaciones = Asociacion::all();

        // Retorna la vista con las asociaciones
        return view('asociaciones', compact('asociaciones'));
    }

    // Método para crear una nueva asociación
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'nombre' => 'required|string|max:100|unique:asociaciones',
            'direccion' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'estado' => 'required|boolean',
        ]);

        // Crear la asociación si pasa la validación
        Asociacion::create($request->all());

        session()->flash('success', 'Asociación registrada exitosamente.');
        // Redirigir con mensaje de éxito
        return redirect()->route('asociaciones.index');
    }

    // Método para actualizar una asociación
    public function update(Request $request, $id)
    {
        // Buscar la asociación por ID
        $asociacion = Asociacion::findOrFail($id);

        // Validar los datos del formulario
        $request->validate([
            'nombre' => 'required|string|max:100|unique:asociaciones,nombre,' . $asociacion->id,
            'direccion' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'estado' => 'required|boolean',
        ]);

        // Actualizar los datos de la asociación
        $asociacion->update($request->all());

        // Redirigir con mensaje de éxito
        return redirect()->route('asociaciones.index')->with('success', 'Asociación actualizada correctamente.');
    }

    // Método para eliminar (desactivar) una asociación
    public function destroy($id)
    {
        // Buscar la asociación por ID
        $asociacion = Asociacion::find($id);

        // Verificar si existe
        if (!$asociacion) {
            return redirect()->route('asociaciones.index')->withErrors(['error' => 'Asociación no encontrada.']);
        }

        // Cambiar el estado a 0 en lugar de eliminar el registro
        $asociacion->estado = 0;
        $asociacion->save();

        // Redirigir con mensaje de éxito
        return redirect()->route('asociaciones.index')->with('success', 'Asociación desactivada correctamente.');
    }
}
