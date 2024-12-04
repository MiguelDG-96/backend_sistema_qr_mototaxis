<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\AsociacionController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\AuditoriaController;
use App\Http\Controllers\ConductorController;
use App\Http\Controllers\VehiculoController;
use App\Http\Controllers\PermisoController;
use App\Http\Controllers\PermisoAccesoController;
use App\Http\Controllers\RolPermisoAccesoController;
use App\Http\Controllers\NotificacionController;
use App\Http\Middleware\Authenticate;


// Ruta para el login
Route::redirect('/', '/login'); //para cargar el servidor en la vista login
Route::get('/login', [UserController::class, 'showLoginForm'])->name('login');
Route::post('/login', [UserController::class, 'login'])->name('login.submit');
Route::post('/logout', [UserController::class, 'logout'])->name('logout');

// Rutas protegidas por middleware auth
Route::middleware([Authenticate::class])->group(function () {
    // Ruta principal (Dashboard)
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');


    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard/data', [DashboardController::class, 'getChartData'])->name('dashboard.data'); // Nueva ruta

    // Gestión de usuarios
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users', [UserController::class, 'register'])->name('users.register');
    Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

    // Gestión de roles
    Route::get('/rols', [RolController::class, 'index'])->name('rols.index');
    Route::post('/rols', [RolController::class, 'store'])->name('rols.store');
    Route::get('/rols/{id}', [RolController::class, 'show'])->name('rols.show');
    Route::put('/rols/{id}', [RolController::class, 'update'])->name('rols.update');
    Route::delete('/rols/{id}', [RolController::class, 'destroy'])->name('rols.destroy');

    // Gestión de permisos de acceso
    Route::get('/permisos_acceso', [PermisoAccesoController::class, 'index'])->name('permisos_acceso.index');
    Route::post('/permisos_acceso', [PermisoAccesoController::class, 'store'])->name('permisos_acceso.store');
    Route::get('/permisos_acceso/{id}', [PermisoAccesoController::class, 'show'])->name('permisos_acceso.show');
    Route::put('/permisos_acceso/{id}', [PermisoAccesoController::class, 'update'])->name('permisos_acceso.update');
    Route::delete('/permisos_acceso/{id}', [PermisoAccesoController::class, 'destroy'])->name('permisos_acceso.destroy');

    // Gestión de permisos asignados a roles
    Route::get('/roles/permisos', [RolPermisoAccesoController::class, 'index'])->name('rols.permisos.view');
    Route::post('/rols/{id_rol}/permisos', [RolPermisoAccesoController::class, 'assignPermisos'])->name('rols.assign_permisos');
    Route::delete('/rols/{id_rol}/permisos', [RolPermisoAccesoController::class, 'revokePermissions'])->name('rols.revoke_permisos');
    Route::get('/rols/{id_rol}/permisos', [RolPermisoAccesoController::class, 'getPermissions'])->name('rols.get_permisos');
    Route::put('/rols/{id_rol}/permisos', [RolPermisoAccesoController::class, 'updatePermissions'])->name('rols.update_permisos');

    // Gestión de asociaciones
    Route::get('/asociaciones', [AsociacionController::class, 'index'])->name('asociaciones.index');
    Route::post('/asociaciones', [AsociacionController::class, 'store'])->name('asociaciones.store');
    Route::put('/asociaciones/{id}', [AsociacionController::class, 'update'])->name('asociaciones.update');
    Route::delete('/asociaciones/{id}', [AsociacionController::class, 'destroy'])->name('asociaciones.destroy');

    // Gestión de reportes
    Route::get('/reportes', [ReporteController::class, 'index'])->name('reportes.index');
    Route::post('/reportes', [ReporteController::class, 'store'])->name('reportes.store');
    Route::delete('/reportes/{id}', [ReporteController::class, 'destroy'])->name('reportes.destroy');

    // Gestión de auditorías
    Route::get('/auditoria', [AuditoriaController::class, 'index'])->name('auditoria.index');
    Route::post('/auditoria', [AuditoriaController::class, 'store'])->name('auditoria.store');
    Route::delete('/auditoria/{id}', [AuditoriaController::class, 'destroy'])->name('auditoria.destroy');

    // Gestión de conductores
    Route::get('/conductores', [ConductorController::class, 'index'])->name('conductores.index');
    Route::post('/conductores', [ConductorController::class, 'store'])->name('conductores.store');
    Route::get('/conductores/{id}', [ConductorController::class, 'show'])->name('conductores.show');
    Route::put('/conductores/{id}', [ConductorController::class, 'update'])->name('conductores.update');
    Route::delete('/conductores/{id}', [ConductorController::class, 'destroy'])->name('conductores.destroy');

    // Gestión de vehículos
    Route::get('/vehiculos', [VehiculoController::class, 'index'])->name('vehiculos.index');
    Route::post('/vehiculos', [VehiculoController::class, 'store'])->name('vehiculos.store');
    Route::get('/vehiculos/{id}', [VehiculoController::class, 'show'])->name('vehiculos.show');
    Route::put('/vehiculos/{id}', [VehiculoController::class, 'update'])->name('vehiculos.update');
    Route::delete('/vehiculos/{id}', [VehiculoController::class, 'destroy'])->name('vehiculos.destroy');

    // Gestión de permisos
    Route::get('/permisos', [PermisoController::class, 'index'])->name('permisos.index');
    Route::post('/permisos', [PermisoController::class, 'store'])->name('permisos.store');
    Route::get('/permisos/{id}', [PermisoController::class, 'showDetails'])->name('permisos.show');
    Route::put('/permisos/{id}', [PermisoController::class, 'update'])->name('permisos.update');
    Route::delete('/permisos/{id}', [PermisoController::class, 'destroy'])->name('permisos.destroy');

    Route::get('/permisos/{id}', [PermisoController::class, 'download_qr'])->name('permisos.download_qr');
    Route::get('/permisos/{id}/qr', [PermisoController::class, 'showQr'])->name('permisos.showQr');


    // Gestión de notificaciones
    Route::get('/notificaciones', [NotificacionController::class, 'index'])->name('notificaciones.index');
    Route::post('/notificaciones', [NotificacionController::class, 'store'])->name('notificaciones.store');
    Route::put('/notificaciones/{id}/leido', [NotificacionController::class, 'markAsRead'])->name('notificaciones.mark_as_read');
    Route::delete('/notificaciones/{id}', [NotificacionController::class, 'destroy'])->name('notificaciones.destroy');
});
