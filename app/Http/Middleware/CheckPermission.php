<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{
    public function handle($request, Closure $next, $permission)
    {
        // $user = Auth::user();

        // Verifica si el usuario tiene el permiso requerido
        // if (!$user->can($permission)) {
        //     Si no tiene el permiso, redirige o muestra un error
        //     return redirect()->route('dashboard')->with('error', 'No tienes permiso para acceder a esta página.');
        // }

        // return $next($request);
    }
}
