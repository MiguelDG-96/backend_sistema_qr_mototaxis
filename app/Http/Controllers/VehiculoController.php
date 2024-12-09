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
        try {
            $request->validate([
                'placa' => 'required|string|max:10|unique:vehiculos,placa',
                'marca' => 'required|string|max:50',
                'modelo' => 'required|string|max:50',
                'anio' => 'required|integer',
                'id_conductor' => 'required|exists:conductores,id',
            ]);

            Vehiculo::create($request->all());

            return redirect()->route('vehiculos.index')->with('alert', [
                'type' => 'success',
                'title' => 'Vehículo Registrado',
                'message' => 'El vehículo ha sido registrado exitosamente.',
                'confirmButtonText' => 'Aceptar',
            ]);
        } catch (\Exception $e) {
            return redirect()->route('vehiculos.index')->with('alert', [
                'type' => 'error',
                'title' => 'Error al Registrar',
                'message' => 'Ocurrió un problema al intentar registrar el vehículo.',
                'confirmButtonText' => 'Reintentar',
            ]);
        }
    }

    // Método para actualizar un vehículo
    public function update(Request $request, $id)
    {
        try {
            $vehiculo = Vehiculo::findOrFail($id);

            $request->validate([
                'placa' => 'sometimes|required|string|max:10|unique:vehiculos,placa,' . $vehiculo->id,
                'marca' => 'sometimes|required|string|max:50',
                'modelo' => 'sometimes|required|string|max:50',
                'anio' => 'sometimes|required|integer',
                'id_conductor' => 'sometimes|required|exists:conductores,id',
            ]);

            $vehiculo->update($request->all());

            return redirect()->route('vehiculos.index')->with('alert', [
                'type' => 'success',
                'title' => 'Vehículo Actualizado',
                'message' => 'Los datos del vehículo han sido actualizados exitosamente.',
                'confirmButtonText' => 'Aceptar',
            ]);
        } catch (\Exception $e) {
            return redirect()->route('vehiculos.index')->with('alert', [
                'type' => 'error',
                'title' => 'Error al Actualizar',
                'message' => 'Ocurrió un problema al intentar actualizar el vehículo.',
                'confirmButtonText' => 'Reintentar',
            ]);
        }
    }

    // Método para desactivar un vehículo
    public function destroy($id)
    {
        try {
            $vehiculo = Vehiculo::find($id);

            if (!$vehiculo) {
                return redirect()->route('vehiculos.index')->with('alert', [
                    'type' => 'error',
                    'title' => 'Vehículo no encontrado',
                    'message' => 'El vehículo que intentas desactivar no existe.',
                    'confirmButtonText' => 'Reintentar',
                ]);
            }

            $vehiculo->estado = 0;
            $vehiculo->save();

            return redirect()->route('vehiculos.index')->with('alert', [
                'type' => 'success',
                'title' => 'Vehículo Desactivado',
                'message' => 'El vehículo ha sido desactivado exitosamente.',
                'confirmButtonText' => 'Aceptar',
            ]);
        } catch (\Exception $e) {
            return redirect()->route('vehiculos.index')->with('alert', [
                'type' => 'error',
                'title' => 'Error al Desactivar',
                'message' => 'Ocurrió un problema al intentar desactivar el vehículo.',
                'confirmButtonText' => 'Reintentar',
            ]);
        }
    }
}
