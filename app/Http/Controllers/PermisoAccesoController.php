<?php

namespace App\Http\Controllers;

use App\Models\PermisoAcceso;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB; // Asegúrate de incluir esta línea
use Illuminate\Support\Facades\Log; // Para registrar errores

class PermisoAccesoController extends Controller
{
    /**
     * Muestra todos los permisos de acceso.
     * Funciona tanto para la vista como para respuestas JSON (API).
     */
    public function index(Request $request)
    {
        try {
            $permisos = PermisoAcceso::all();

            // Si la solicitud es para JSON, devolver datos en formato JSON
            if ($request->wantsJson()) {
                return response()->json($permisos, 200);
            }

            // Retornar la vista principal con los datos
            return view('PermisosAcceso', compact('permisos'));
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al obtener los permisos de acceso: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Almacena un nuevo permiso de acceso.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:255',
        ]);

        PermisoAcceso::create($request->all());

        return redirect()->route('permisos_acceso.index')
            ->with('success', 'Permiso de acceso creado exitosamente.');
    }


    /**
     * Muestra los detalles de un permiso de acceso específico.
     */
    public function show($id)
    {
        try {
            $permiso = PermisoAcceso::findOrFail($id);

            return response()->json($permiso, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Permiso de acceso no encontrado: ' . $e->getMessage()
            ], 404);
        }
    }

    /**
     * Actualiza un permiso de acceso existente.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'sometimes|required|string|max:255',
            'descripcion' => 'sometimes|nullable|string|max:255',
        ], [
            'nombre.required' => 'El campo nombre es obligatorio.',
            'nombre.max' => 'El nombre no puede exceder los 255 caracteres.',
            'descripcion.max' => 'La descripción no puede exceder los 255 caracteres.',
        ]);

        try {
            DB::beginTransaction();

            $permiso = PermisoAcceso::findOrFail($id);

            // Actualiza solo los campos necesarios
            $permiso->update($request->only(['nombre', 'descripcion']));

            DB::commit();

            return redirect()->route('permisos_acceso.index')
                ->with('success', 'Permiso de acceso actualizado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();

            // Registra el error en el log
            Log::error('Error al actualizar permiso: ' . $e->getMessage());

            return redirect()->route('permisos_acceso.index')
                ->with('error', 'Ocurrió un problema al actualizar el permiso. Por favor, inténtalo nuevamente.');
        }
    }


    /**
     * Elimina un permiso de acceso.
     */
    public function destroy($id)
    {
        try {
            $permiso = PermisoAcceso::findOrFail($id);
            $permiso->delete();

            return redirect()->route('permisos_acceso.index')
                ->with('success', 'Permiso de acceso eliminado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('permisos_acceso.index')
                ->with('error', 'Error al eliminar el permiso: ' . $e->getMessage());
        }
    }
}
