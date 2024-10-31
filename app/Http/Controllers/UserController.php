<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Credenciales incorrectas'], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['token' => $token, 'user' => $user], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Sesión cerrada correctamente'], 200);
    }

    // Método para registrar un nuevo usuario
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'id_rol' => 'required|exists:rols,id'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'id_rol' => $request->id_rol,
            'estado' => 1,
        ]);

        return response()->json(['user' => $user], 201);
    }

    // Método para listar todos los usuarios
    public function index()
    {
        $users = User::with('rol')->get();
        return response()->json($users);
    }

    // Método para actualizar un usuario
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->all());

        return response()->json(['user' => $user]);
    }

    public function show()
    {
        $user = auth('sanctum')->user();

        if (!$user) {
            return response()->json(['message' => 'No autorizado'], 401);
        }

        // Cargar la relación 'rol' usando `with` y devolver el usuario con su rol
        $user = User::with('rol')->find($user->id);

        return response()->json($user);
    }




    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        // Cambiar el estado a 0 en lugar de eliminar el registro
        $user->estado = 0;
        $user->save();

        return response()->json(['message' => 'Usuario desactivado']);
    }
}
