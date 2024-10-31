<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RolController extends Controller
{
    // Método para listar todos los roles
    public function index()
    {
        $rols = Rol::all();
        return response()->json($rols);
    }

    // Método para crear un nuevo rol
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:rols',
            'descripcion' => 'nullable|string',
        ]);

        $rol = Rol::create($request->all());
        return response()->json(['rol' => $rol], 201);
    }
}
