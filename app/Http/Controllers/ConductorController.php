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
        try {
            $conductores = Conductor::with('asociacion')->where('estado', 1)->get();
            $asociaciones = Asociacion::where('estado', 1)->get();

            return view('conductores', compact('conductores', 'asociaciones'));
        } catch (\Exception $e) {
            return redirect()->route('home')->with('alert', [
                'type' => 'error',
                'title' => 'Error al cargar datos',
                'message' => 'Ocurrió un problema al intentar cargar los datos de conductores.',
                'confirmButtonText' => 'Reintentar',
            ]);
        }
    }

    // Método para registrar un nuevo conductor
    public function store(Request $request)
    {
        try {
            $request->validate([
                'nombre' => 'required|string|max:100',
                'dni' => 'required|string|size:8|unique:conductores,dni',
                'direccion' => 'nullable|string|max:255',
                'telefono' => 'nullable|string|max:20',
                'id_asociacion' => 'required|exists:asociaciones,id',
            ]);

            Conductor::create([
                'nombre' => $request->nombre,
                'dni' => $request->dni,
                'direccion' => $request->direccion,
                'telefono' => $request->telefono,
                'id_asociacion' => $request->id_asociacion,
                'estado' => 1,
            ]);

            return redirect()->route('conductores.index')->with('alert', [
                'type' => 'success',
                'title' => 'Conductor Registrado',
                'message' => 'El conductor ha sido registrado exitosamente.',
                'confirmButtonText' => 'Aceptar',
            ]);
        } catch (\Exception $e) {
            return redirect()->route('conductores.index')->with('alert', [
                'type' => 'error',
                'title' => 'Error al registrar',
                'message' => 'Ocurrió un problema al intentar registrar el conductor.',
                'confirmButtonText' => 'Reintentar',
            ]);
        }
    }

    // Método para actualizar un conductor
    public function update(Request $request, $id)
    {
        try {
            $conductor = Conductor::findOrFail($id);

            $request->validate([
                'nombre' => 'sometimes|required|string|max:100',
                'dni' => 'sometimes|required|string|size:8|unique:conductores,dni,' . $conductor->id,
                'direccion' => 'nullable|string|max:255',
                'telefono' => 'nullable|string|max:20',
                'id_asociacion' => 'sometimes|required|exists:asociaciones,id',
            ]);

            $conductor->update($request->only([
                'nombre',
                'dni',
                'direccion',
                'telefono',
                'id_asociacion',
            ]));

            return redirect()->route('conductores.index')->with('alert', [
                'type' => 'success',
                'title' => 'Conductor Actualizado',
                'message' => 'Los datos del conductor han sido actualizados exitosamente.',
                'confirmButtonText' => 'Aceptar',
            ]);
        } catch (\Exception $e) {
            return redirect()->route('conductores.index')->with('alert', [
                'type' => 'error',
                'title' => 'Error al actualizar',
                'message' => 'Ocurrió un problema al intentar actualizar el conductor.',
                'confirmButtonText' => 'Reintentar',
            ]);
        }
    }

    // Método para desactivar un conductor
    public function destroy($id)
    {
        try {
            $conductor = Conductor::find($id);

            if (!$conductor) {
                return redirect()->route('conductores.index')->with('alert', [
                    'type' => 'error',
                    'title' => 'Conductor no encontrado',
                    'message' => 'El conductor que intentas desactivar no existe.',
                    'confirmButtonText' => 'Reintentar',
                ]);
            }

            $conductor->update(['estado' => 0]);

            return redirect()->route('conductores.index')->with('alert', [
                'type' => 'success',
                'title' => 'Conductor Desactivado',
                'message' => 'El conductor ha sido desactivado correctamente.',
                'confirmButtonText' => 'Aceptar',
            ]);
        } catch (\Exception $e) {
            return redirect()->route('conductores.index')->with('alert', [
                'type' => 'error',
                'title' => 'Error al desactivar',
                'message' => 'Ocurrió un problema al intentar desactivar el conductor.',
                'confirmButtonText' => 'Reintentar',
            ]);
        }
    }
}
