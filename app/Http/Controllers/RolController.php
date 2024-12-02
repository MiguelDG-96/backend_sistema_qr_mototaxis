<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use Illuminate\Http\Request;

class RolController extends Controller
{
    /**
     * Lista todos los roles.
     * Si se solicita JSON (por ejemplo, para una API), responde con JSON.
     * Si no, retorna la vista con los roles.
     */
    public function index(Request $request)
    {
        $roles = Rol::all();

        // Verifica si la solicitud espera JSON
        if ($request->wantsJson()) {
            return response()->json($roles, 200);
        }

        // Retorna la vista con los roles
        return view('rols', compact('roles'));
    }

    /**
     * Crea un nuevo rol.
     * Valida los datos de entrada antes de crear el registro.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:rols',
            'descripcion' => 'nullable|string|max:500',
        ]);

        try {
            $rol = Rol::create($request->all());

            // Responder JSON para solicitudes API
            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'Rol creado con éxito',
                    'rol' => $rol,
                ], 201);
            }

            // Redirigir a la vista con un mensaje de éxito
            return redirect()->route('rols.index')->with('success', 'Rol creado con éxito');
        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'Error al crear el rol',
                    'error' => $e->getMessage(),
                ], 500);
            }

            return redirect()->route('rols.index')->with('error', 'Error al crear el rol: ' . $e->getMessage());
        }
    }

    /**
     * Muestra un rol específico.
     * Retorna un mensaje de error si el rol no existe.
     */
    public function show($id)
    {
        $rol = Rol::find($id);

        if (!$rol) {
            return response()->json(['message' => 'Rol no encontrado'], 404);
        }

        return response()->json($rol, 200);
    }

    /**
     * Actualiza un rol existente.
     * Valida los datos antes de actualizar.
     */
    public function update(Request $request, $id)
    {
        $rol = Rol::find($id);

        if (!$rol) {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Rol no encontrado'], 404);
            }

            return redirect()->route('rols.index')->with('error', 'Rol no encontrado');
        }

        $request->validate([
            'nombre' => 'sometimes|required|string|max:255|unique:rols,nombre,' . $rol->id,
            'descripcion' => 'nullable|string|max:500',
        ]);

        try {
            $rol->update($request->all());

            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'Rol actualizado con éxito',
                    'rol' => $rol,
                ], 200);
            }

            return redirect()->route('rols.index')->with('success', 'Rol actualizado con éxito');
        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'Error al actualizar el rol',
                    'error' => $e->getMessage(),
                ], 500);
            }

            return redirect()->route('rols.index')->with('error', 'Error al actualizar el rol: ' . $e->getMessage());
        }
    }

    /**
     * Elimina un rol.
     * Responde con un mensaje adecuado si el rol no existe.
     */
    public function destroy(Request $request, $id)
    {
        $rol = Rol::find($id);

        if (!$rol) {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Rol no encontrado'], 404);
            }

            return redirect()->route('rols.index')->with('error', 'Rol no encontrado');
        }

        try {
            $rol->delete();

            if ($request->wantsJson()) {
                return response()->json(['message' => 'Rol eliminado con éxito'], 200);
            }

            return redirect()->route('rols.index')->with('success', 'Rol eliminado con éxito');
        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'Error al eliminar el rol',
                    'error' => $e->getMessage(),
                ], 500);
            }

            return redirect()->route('rols.index')->with('error', 'Error al eliminar el rol: ' . $e->getMessage());
        }
    }
}
