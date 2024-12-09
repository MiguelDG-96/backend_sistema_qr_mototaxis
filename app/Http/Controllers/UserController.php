<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Muestra el formulario de login
    public function showLoginForm()
    {
        return view('auth.login'); // Asegúrate de tener esta vista en resources/views/auth/login.blade.php
    }

    // Procesa el inicio de sesión
    public function login(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Intentar autenticar al usuario
        $user = User::where('email', $request->email)->first();

        // Verificar credenciales
        if ($user && Hash::check($request->password, $user->password)) {
            // Cerrar sesión previa si hay un remember_token activo
            if ($user->remember_token) {
                Auth::logoutOtherDevices($request->password);
            }

            // Autenticar al usuario y regenerar la sesión
            Auth::login($user);
            $request->session()->regenerate();

            // Redirigir al dashboard con alerta de éxito
            return redirect()->route('dashboard')->with('alert', [
                'type' => 'success',
                'title' => '¡Éxito!',
                'message' => 'Inicio de sesión exitoso. ¡Bienvenido!',
                'confirmButtonText' => 'Aceptar',
            ]);
        }

        // Si la autenticación falla
        return back()->with('alert', [
            'type' => 'error',
            'title' => 'Error de inicio de sesión',
            'message' => 'Credenciales incorrectas o usuario no encontrado.',
            'confirmButtonText' => 'Reintentar',
        ]);
    }

    // Cierra la sesión del usuario
    public function logout(Request $request)
    {
        // Cerrar sesión
        Auth::logout();

        // Invalidar la sesión y regenerar el token CSRF
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirigir con mensaje de éxito de cierre de sesión
        return redirect()->route('login')->with('alert', [
            'type' => 'success',
            'title' => 'Sesión Cerrada',
            'message' => 'Has cerrado sesión correctamente.',
            'confirmButtonText' => 'Aceptar',
        ]);
    }


    // Lista todos los usuarios
    public function index()
    {
        // Obtener usuarios activos con sus roles
        $users = User::with('rol')->where('estado', 1)->get();
        $roles = Rol::all(); // Asegúrate de tener el modelo Rol

        return view('User', compact('users', 'roles')); // Vista para listar usuarios
    }

    // Registra un nuevo usuario
    public function register(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'id_rol' => 'required|exists:rols,id',
            //'password' => 'required|string|min:8'
        ]);

        // Crear el usuario
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->id_rol = $request->id_rol;
        $user->estado = 1;
        $user->save();

        return redirect()->route('users.index')->with('alert', [
            'type' => 'success',
            'title' => 'Usuario Registrado',
            'message' => 'El usuario fue registrado exitosamente.',
            'confirmButtonText' => 'Aceptar',
        ]);
    }

    // Actualiza un usuario existente
    public function update(Request $request, $id)
    {
        // Validar los datos
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'id_rol' => 'required|exists:rols,id',
        ]);

        // Buscar al usuario
        $user = User::findOrFail($id);

        // Actualizar los datos del usuario
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'id_rol' => $request->id_rol,
        ]);

        // Si se proporciona una contraseña nueva, actualizarla
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
            $user->save();
        }

        return redirect()->route('users.index')->with('alert', [
            'type' => 'success',
            'title' => 'Usuario Actualizado',
            'message' => 'Los datos del usuario han sido actualizados.',
            'confirmButtonText' => 'Aceptar',
        ]);
    }

    // Desactiva (elimina lógicamente) un usuario
    public function destroy($id)
    {
        // Buscar al usuario
        $user = User::findOrFail($id);

        // Cambiar el estado del usuario a inactivo (0)
        $user->estado = 0;

        // Guardar el cambio
        if ($user->save()) {
            return redirect()->route('users.index')->with('alert', [
                'type' => 'success',
                'title' => 'Usuario Desactivado',
                'message' => 'El usuario fue desactivado correctamente.',
                'confirmButtonText' => 'Aceptar',
            ]);
        } else {
            return back()->with('alert', [
                'type' => 'error',
                'title' => 'Error al Desactivar',
                'message' => 'No se pudo desactivar el usuario. Intenta de nuevo.',
                'confirmButtonText' => 'Reintentar',
            ]);
        }
    }
}
