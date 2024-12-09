<?php

namespace App\Http\Controllers;

use App\Models\Permiso;
use App\Models\Vehiculo;
use App\Models\Conductor;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PermisoController extends Controller
{
    /**
     * Método para listar todos los permisos.
     * Muestra la vista principal con la lista de permisos, vehículos y conductores activos.
     */
    public function index()
    {
        $permisos = Permiso::with(['vehiculo', 'conductor'])->get();
        $vehiculos = Vehiculo::where('estado', 1)->get();
        $conductores = Conductor::where('estado', 1)->get();

        return view('permisos', compact('permisos', 'vehiculos', 'conductores'));
    }

    /**
     * Método para registrar un nuevo permiso.
     * Valida la entrada, genera un QR único y lo almacena en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_vehiculo' => 'required|exists:vehiculos,id',
            'id_conductor' => 'required|exists:conductores,id',
            'fecha_emision' => 'required|date',
            'fecha_expiracion' => 'required|date|after_or_equal:fecha_emision',
            'estado' => 'required|in:Vigente,Expirado,Suspendido',
        ]);

        // Verificar si ya existe un permiso activo con el mismo vehículo y conductor
        $existingPermiso = Permiso::where('id_vehiculo', $request->id_vehiculo)
            ->where('id_conductor', $request->id_conductor)
            ->where('estado', 'Vigente') // Solo permisos activos
            ->first();

        if ($existingPermiso) {
            return redirect()->back()->with('alert', [
                'type' => 'error',
                'title' => '¡Error!',
                'message' => 'Ya existe un permiso con esta placa y conductor.',
                'confirmButtonText' => 'Aceptar'
            ]);
        }

        $link = "http://127.0.0.1:8000/qrcodes/";
        // Crear el permiso
        $permiso = Permiso::create($request->all());
        // Añadir el texto del QR
        $permiso = Permiso::where('id', $permiso->id)->first();
        $permiso->qr = $link . $permiso->id;
        $permiso->save();

        QrCode::size(80)->generate($link . $permiso->id, "qrcodes/" . $permiso->id . ".svg");

        return redirect()->route('permisos.index')->with('alert', [
            'type' => 'success',
            'title' => 'Permiso Registrado',
            'message' => 'El permiso ha sido registrado exitosamente.',
            'confirmButtonText' => 'Aceptar',
        ]);
    }

    // Método para buscar vehículos
    public function searchVehiculos(Request $request)
    {
        $query = $request->input('search');
        $vehiculos = Vehiculo::where('placa', 'like', "%$query%")->get(['id', 'placa']);
        return response()->json($vehiculos->map(fn($v) => ['id' => $v->id, 'text' => $v->placa]));
    }

    // Método para buscar conductores
    public function searchConductores(Request $request)
    {
        $query = $request->input('search');
        $conductores = Conductor::where('nombre', 'like', "%$query%")->get(['id', 'nombre']);
        return response()->json($conductores->map(fn($c) => ['id' => $c->id, 'text' => $c->nombre]));
    }

    /**
     * Método para mostrar los detalles del permiso al escanear el QR.
     */
    public function download_qr($id)
    {
        $qr = Permiso::find($id);
        $path = public_path() . '/qrcodes/' . $qr->id . '.svg';
        return response()->download($path);
    }

    public function showQr($id)
    {
        $permiso = Permiso::with(['vehiculo', 'conductor', 'conductor.asociacion'])->find($id);

        if (!$permiso) {
            abort(404, 'Permiso no encontrado.');
        }

        return view('permiso_qr', compact('permiso'));
    }

    /**
     * Método para actualizar un permiso existente.
     * Permite modificar los datos del permiso y recalcular el código QR si es necesario.
     */
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

        // Recalcular el QR si el permiso se actualiza
        $qrUrl = route('permisos.showQr', ['id' => $permiso->id]);
        $qrPath = public_path("qrcodes/permiso_{$permiso->id}.png");
        QrCode::format('png')->size(300)->generate($qrUrl, $qrPath);

        $permiso->codigo_qr = asset("qrcodes/permiso_{$permiso->id}.png");
        $permiso->save();

        return redirect()->route('permisos.index')->with('alert', [
            'type' => 'success',
            'title' => 'Permiso Actualizado',
            'message' => 'El permiso ha sido actualizado correctamente.',
            'confirmButtonText' => 'Aceptar',
        ]);
    }

    /**
     * Método para desactivar (eliminar lógicamente) un permiso.
     */
    public function destroy($id)
    {
        $permiso = Permiso::find($id);

        if (!$permiso) {
            return redirect()->route('permisos.index')->with('alert', [
                'type' => 'error',
                'title' => 'Permiso no encontrado',
                'message' => 'No se encontró el permiso que intentas eliminar.',
                'confirmButtonText' => 'Reintentar',
            ]);
        }

        // Cambiar el estado a inactivo (opcional) o eliminar directamente
        $permiso->delete();

        return redirect()->route('permisos.index')->with('alert', [
            'type' => 'success',
            'title' => 'Permiso Eliminado',
            'message' => 'El permiso ha sido eliminado correctamente.',
            'confirmButtonText' => 'Aceptar',
        ]);
    }
}
