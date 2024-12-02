<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Asociacion;
use App\Models\Vehiculo;
use App\Models\Conductor;
use App\Models\Permiso;
use Illuminate\Http\Request;


class DashboardController extends Controller
{
    /**
     * Muestra el dashboard con estadísticas generales y gráficos dinámicos.
     */
    public function dashboard(Request $request)
    {
        // Estadísticas generales
        $usuarios = User::count(); // Total de usuarios registrados
        $asociaciones = Asociacion::count(); // Total de asociaciones
        $vehiculos = Vehiculo::count(); // Total de vehículos registrados
        $conductores = Conductor::count(); // Total de conductores registrados

        // Variables por defecto para filtros
        $año = $request->input('año', now()->year); // Año actual como predeterminado
        $mes = $request->input('mes', null); // Sin mes por defecto (null)

        // Datos iniciales del gráfico (últimos 6 meses por defecto)
        $permisosPorMes = Permiso::whereYear('fecha_emision', $año)
            ->selectRaw('MONTH(fecha_emision) as mes, COUNT(*) as total')
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();
        $labels = $permisosPorMes->pluck('mes')->map(function ($mes) {
            return date('F', mktime(0, 0, 0, $mes, 1)); // Nombres de meses
        });
        $data = $permisosPorMes->pluck('total');

        // Retorna la vista con las variables necesarias
        return view('dashboard', [
            'usuarios' => $usuarios,
            'asociaciones' => $asociaciones,
            'vehiculos' => $vehiculos,
            'conductores' => $conductores,
            'año' => $año,
            'mes' => $mes,
            'labels' => $labels,
            'data' => $data,
        ]);
    }

    /**
     * Devuelve datos dinámicos del gráfico en formato JSON.
     */
    public function getChartData(Request $request)
    {
        // Filtros dinámicos: año y mes
        $año = $request->input('año', now()->year); // Año actual por defecto
        $mes = $request->input('mes', null); // Sin mes (todos los meses del año)

        // Validar y construir datos del gráfico
        if ($mes) {
            // Datos por días del mes seleccionado
            $permisosPorPeriodo = Permiso::whereYear('fecha_emision', $año)
                ->whereMonth('fecha_emision', $mes)
                ->selectRaw('DAY(fecha_emision) as dia, COUNT(*) as total')
                ->groupBy('dia')
                ->orderBy('dia')
                ->get();
            $labels = $permisosPorPeriodo->pluck('dia'); // Días del mes
            $data = $permisosPorPeriodo->pluck('total'); // Total por día
        } else {
            // Datos por meses del año seleccionado
            $permisosPorPeriodo = Permiso::whereYear('fecha_emision', $año)
                ->selectRaw('MONTH(fecha_emision) as mes, COUNT(*) as total')
                ->groupBy('mes')
                ->orderBy('mes')
                ->get();
            $labels = $permisosPorPeriodo->pluck('mes')->map(function ($mes) {
                return date('F', mktime(0, 0, 0, $mes, 1)); // Nombres de meses
            });
            $data = $permisosPorPeriodo->pluck('total'); // Total por mes
        }

        // Retornar datos en formato JSON para el gráfico
        return response()->json([
            'labels' => $labels,
            'data' => $data,
        ]);
    }
}
