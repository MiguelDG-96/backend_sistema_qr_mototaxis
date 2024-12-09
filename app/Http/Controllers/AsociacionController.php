<?php

namespace App\Http\Controllers;

use App\Models\Asociacion;
use Illuminate\Http\Request;

class AsociacionController extends Controller
{
    // Método para listar todas las asociaciones
    public function index()
    {
        try {
            // Obtiene todas las asociaciones activas
            $asociaciones = Asociacion::all();

            // Retorna la vista con las asociaciones
            return view('asociaciones', compact('asociaciones'));
        } catch (\Exception $e) {
            return redirect()->route('home')->with('alert', [
                'type' => 'error',
                'title' => 'Error al cargar datos',
                'message' => 'Ocurrió un problema al intentar cargar las asociaciones.',
                'confirmButtonText' => 'Reintentar',
            ]);
        }
    }

    // Método para crear una nueva asociación
    public function store(Request $request)
    {
        try {
            // Validar los datos del formulario
            $request->validate([
                'nombre' => 'required|string|max:100|unique:asociaciones',
                'direccion' => 'nullable|string|max:255',
                'telefono' => 'nullable|string|max:20',
                'estado' => 'required|boolean',
            ]);

            // Crear la asociación si pasa la validación
            Asociacion::create($request->all());

            // Redirigir con mensaje de éxito
            return redirect()->route('asociaciones.index')->with('alert', [
                'type' => 'success',
                'title' => 'Asociación Registrada',
                'message' => 'La asociación se ha registrado exitosamente.',
                'confirmButtonText' => 'Aceptar',
            ]);
        } catch (\Exception $e) {
            return redirect()->route('asociaciones.index')->with('alert', [
                'type' => 'error',
                'title' => 'Error al registrar',
                'message' => 'Ocurrió un problema al intentar registrar la asociación.',
                'confirmButtonText' => 'Reintentar',
            ]);
        }
    }

    // Método para actualizar una asociación
    public function update(Request $request, $id)
    {
        try {
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
            return redirect()->route('asociaciones.index')->with('alert', [
                'type' => 'success',
                'title' => 'Asociación Actualizada',
                'message' => 'La asociación se ha actualizado correctamente.',
                'confirmButtonText' => 'Aceptar',
            ]);
        } catch (\Exception $e) {
            return redirect()->route('asociaciones.index')->with('alert', [
                'type' => 'error',
                'title' => 'Error al actualizar',
                'message' => 'Ocurrió un problema al intentar actualizar la asociación.',
                'confirmButtonText' => 'Reintentar',
            ]);
        }
    }

    // Método para eliminar (desactivar) una asociación
    public function destroy($id)
    {
        try {
            // Buscar la asociación por ID
            $asociacion = Asociacion::find($id);

            // Verificar si existe
            if (!$asociacion) {
                return redirect()->route('asociaciones.index')->with('alert', [
                    'type' => 'error',
                    'title' => 'Asociación no encontrada',
                    'message' => 'La asociación que intentas desactivar no existe.',
                    'confirmButtonText' => 'Reintentar',
                ]);
            }

            // Cambiar el estado a 0 en lugar de eliminar el registro
            $asociacion->estado = 0;
            $asociacion->save();

            // Redirigir con mensaje de éxito
            return redirect()->route('asociaciones.index')->with('alert', [
                'type' => 'success',
                'title' => 'Asociación Desactivada',
                'message' => 'La asociación se ha desactivado correctamente.',
                'confirmButtonText' => 'Aceptar',
            ]);
        } catch (\Exception $e) {
            return redirect()->route('asociaciones.index')->with('alert', [
                'type' => 'error',
                'title' => 'Error al desactivar',
                'message' => 'Ocurrió un problema al intentar desactivar la asociación.',
                'confirmButtonText' => 'Reintentar',
            ]);
        }
    }
}
