<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use App\Models\PermisoAcceso;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RolPermisoAccesoController extends Controller
{
    // Mostrar la página principal de gestión de roles y permisos
    public function index()
    {
        $roles = Rol::with('permisos')->get();
        $permisos = PermisoAcceso::all();

        return view('PermisosRoles', compact('roles', 'permisos'));
    }

    // Método para asignar permisos a un rol
    public function assignPermisos(Request $request, $id_rol)
    {
        $rol = Rol::findOrFail($id_rol);

        $request->validate([
            'permisos' => 'required|array',
            'permisos.*' => 'exists:permisos_acceso,id',
        ]);

        // Asignar permisos sin eliminar los existentes
        $rol->permisos()->syncWithoutDetaching($request->permisos);

        return response()->json(['message' => 'Permisos asignados correctamente'], Response::HTTP_OK);
    }

    // Método para revocar permisos de un rol
    public function revokePermissions(Request $request, $id_rol)
    {
        $rol = Rol::findOrFail($id_rol);

        $request->validate([
            'permisos' => 'required|array',
            'permisos.*' => 'exists:permisos_acceso,id',
        ]);

        // Revocar permisos específicos
        $rol->permisos()->detach($request->permisos);

        return response()->json(['message' => 'Permisos revocados correctamente'], Response::HTTP_OK);
    }

    // Método para obtener los permisos de un rol específico
    public function getPermissions($id_rol)
    {
        $rol = Rol::with('permisos')->findOrFail($id_rol);

        return response()->json($rol->permisos, Response::HTTP_OK);
    }

    // Método para actualizar los permisos de un rol
    public function updatePermissions(Request $request, $id_rol)
    {
        $rol = Rol::findOrFail($id_rol);

        $request->validate([
            'permisos' => 'required|array',
            'permisos.*' => 'exists:permisos_acceso,id'
        ]);

        // Actualizar los permisos del rol, reemplazando los actuales
        $rol->permisos()->sync($request->permisos);

        return response()->json(['message' => 'Permisos actualizados correctamente'], Response::HTTP_OK);
    }
}
