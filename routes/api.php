<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\AsociacionController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\AuditoriaController;
use App\Http\Controllers\ConductorController;
use App\Http\Controllers\VehiculoController;
use App\Http\Controllers\PermisoController;
use App\Http\Controllers\NotificacionController;

// Rutas públicas (sin protección de autenticación)
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

// Rutas protegidas con middleware de autenticación
Route::middleware('auth:sanctum')->group(function () {
    
    // Rutas para gestión de usuarios
    Route::get('/user', [UserController::class, 'show']);
    Route::post('/logout', [UserController::class, 'logout']);
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{id}', [UserController::class, 'show']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);

    // Rutas para gestión de roles
    Route::get('/rols', [RolController::class, 'index']);
    Route::post('/rols', [RolController::class, 'store']);

    // Rutas para gestión de asociaciones
    Route::get('/asociaciones', [AsociacionController::class, 'index']);
    Route::post('/asociaciones', [AsociacionController::class, 'store']);
    Route::put('/asociaciones/{id}', [AsociacionController::class, 'update']);
    Route::delete('/asociaciones/{id}', [AsociacionController::class, 'destroy']);

    // Rutas para gestión de reportes
    Route::get('/reportes', [ReporteController::class, 'index']);
    Route::post('/reportes', [ReporteController::class, 'store']);
    Route::delete('/reportes/{id}', [ReporteController::class, 'destroy']);

    // Rutas para gestión de auditoría
    Route::get('/auditoria', [AuditoriaController::class, 'index']);
    Route::post('/auditoria', [AuditoriaController::class, 'store']);
    Route::delete('/auditoria/{id}', [AuditoriaController::class, 'destroy']);

    // Rutas para gestión de conductores
    Route::get('/conductores', [ConductorController::class, 'index']);
    Route::get('/conductores/{id}', [ConductorController::class, 'show']);
    Route::post('/conductores', [ConductorController::class, 'store']);
    Route::put('/conductores/{id}', [ConductorController::class, 'update']);
    Route::delete('/conductores/{id}', [ConductorController::class, 'destroy']);

    // Rutas para gestión de vehículos
    Route::get('/vehiculos', [VehiculoController::class, 'index']);
    Route::get('/vehiculos/{id}', [VehiculoController::class, 'show']);
    Route::post('/vehiculos', [VehiculoController::class, 'store']);
    Route::put('/vehiculos/{id}', [VehiculoController::class, 'update']);
    Route::delete('/vehiculos/{id}', [VehiculoController::class, 'destroy']);

    // Rutas para gestión de permisos
    Route::get('/permisos', [PermisoController::class, 'index']);
    Route::post('/permisos', [PermisoController::class, 'store']);
    Route::get('/permisos/{id}', [PermisoController::class, 'showDetails']);
    Route::put('/permisos/{id}', [PermisoController::class, 'update']);
    Route::delete('/permisos/{id}', [PermisoController::class, 'destroy']);

    // Rutas para gestión de notificaciones
    Route::get('/notificaciones', [NotificacionController::class, 'index']);
    Route::post('/notificaciones', [NotificacionController::class, 'store']);
    Route::put('/notificaciones/{id}/leido', [NotificacionController::class, 'markAsRead']);
    Route::delete('/notificaciones/{id}', [NotificacionController::class, 'destroy']);
});
