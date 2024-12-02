@extends('layouts.main')

@section('content')
<div class="container mt-0 py-0">
    <!-- Título del Dashboard -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="mb-1">Gestión de Permisos de Mototaxis</h1>
            <small>Inicio / Dashboard</small>
        </div>
        <a href="#" class="btn btn-primary">
            <i class="fas fa-download"></i> Descargar PDF
        </a>
    </div>

    <!-- Tarjetas de Resumen -->
    <div class="row">
        <!-- Usuarios -->
        <div class="col-lg-3 col-md-6 mb-2">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <i class="fas fa-users fa-2x text-primary mb-2"></i>
                    <h5 class="card-title">Usuarios</h5>
                    <h3 class="card-text">{{ $usuarios }}</h3>
                    <p class="small text-muted">Usuarios Registrados</p>
                </div>
            </div>
        </div>

        <!-- Asociaciones -->
        <div class="col-lg-3 col-md-6 mb-2">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <i class="fas fa-building fa-2x text-success mb-2"></i>
                    <h5 class="card-title">Asociaciones</h5>
                    <h3 class="card-text">{{ $asociaciones }}</h3>
                    <p class="small text-muted">Total de Asociaciones</p>
                </div>
            </div>
        </div>

        <!-- Vehículos -->
        <div class="col-lg-3 col-md-6 mb-2">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <i class="fas fa-car fa-2x text-warning mb-2"></i>
                    <h5 class="card-title">Vehículos</h5>
                    <h3 class="card-text">{{ $vehiculos }}</h3>
                    <p class="small text-muted">Vehículos Registrados</p>
                </div>
            </div>
        </div>

        <!-- Conductores -->
        <div class="col-lg-3 col-md-6 mb-2">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <i class="fas fa-id-card fa-2x text-info mb-2"></i>
                    <h5 class="card-title">Conductores</h5>
                    <h3 class="card-text">{{ $conductores }}</h3>
                    <p class="small text-muted">Conductores Registrados</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráfico de Permisos -->
    <div class="row mt-2">
        <div class="col-12">
            <div class="card border-0 shadow-lg">
                <div class="card-header bg-gradient-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-chart-bar mr-2"></i> Distribución de Permisos</h5>
                    <form class="form-inline">
                        <select id="periodo" class="form-control mr-2">
                            <option value="yearly">Anual</option>
                            @foreach(range(1, 12) as $month)
                            <option value="{{ $month }}" {{ $mes == $month ? 'selected' : '' }}>
                                {{ \Illuminate\Support\Carbon::create()->month($month)->locale('es')->translatedFormat('F') }}
                            </option>
                            @endforeach
                        </select>
                        <select id="año" class="form-control mr-2">
                            @for($i = now()->year - 10; $i <= 2050; $i++)
                                <option value="{{ $i }}" {{ $año == $i ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                        </select>
                        <button type="button" id="updateChartButton" class="btn btn-light">Actualizar</button>
                    </form>
                </div>
                <div class="card-body d-flex justify-content-start align-items-center">
                    <div class="chart-container">
                        <canvas id="permisosChart"></canvas>
                    </div>
                    <div class="chart-legend ml-4">
                        <div class="leyenda-item">
                            <span class="legend-color" style="background-color: rgba(54, 162, 235, 0.7);"></span> Vigente
                        </div>
                        <div class="leyenda-item">
                            <span class="legend-color" style="background-color: rgba(255, 206, 86, 0.7);"></span> Suspendido
                        </div>
                        <div class="leyenda-item">
                            <span class="legend-color" style="background-color: rgba(255, 99, 132, 0.7);"></span> Expirado
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <style>
        .card-1 {
            display: flex;
            justify-content: flex-center;
            align-items: center;
            height: 250px;
        }

        .chart-container {
            width: 70%;
        }

        .chart-legend {
            display: flex;
            flex-direction: column;
            margin-left: 20px;
        }

        .leyenda-item {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .legend-color {
            width: 15px;
            height: 15px;
            display: inline-block;
            margin-right: 5px;
            border-radius: 50%;
        }

        #permisosChart {
            width: 100%;
            height: 300px;
        }

        .card {
            border-radius: 15px;
        }

        .card-header {
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
            background: linear-gradient(90deg, #4e73df, #224abe);
        }

        .btn-sm {
            font-size: 0.85rem;
            margin: 0 5px;
            color: #4e73df;
            border: 1px solid #4e73df;
        }

        .btn-sm:hover {
            background: #4e73df;
            color: white;
        }

        .card-footer {
            font-size: 0.85rem;
        }

        .shadow-lg {
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .container {
            flex-grow: 1;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('permisosChart').getContext('2d');
            let permisosChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: @json($labels), // Datos iniciales
                    datasets: [{
                        label: 'Cantidad de Permisos',
                        data: @json($data), // Datos iniciales
                        backgroundColor: [
                            'rgba(54, 162, 235, 0.7)',
                            'rgba(255, 206, 86, 0.7)',
                            'rgba(255, 99, 132, 0.7)'
                        ],
                        borderColor: [
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(255, 99, 132, 1)'
                        ],
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false,
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                font: {
                                    size: 20
                                }
                            }
                        },
                        x: {
                            ticks: {
                                font: {
                                    size: 20
                                }
                            },
                            categoryPercentage: 0.8,
                            barPercentage: 0.6
                        }
                    },
                    layout: {
                        padding: {
                            top: 10,
                            bottom: 10,
                            right: 50
                        }
                    }
                }
            });

            document.getElementById('updateChartButton').addEventListener('click', function() {
                const periodo = document.getElementById('periodo').value;
                const año = document.getElementById('año').value;

                fetch(`/dashboard/data?año=${año}&mes=${periodo !== 'yearly' ? periodo : ''}`)
                    .then(response => response.json())
                    .then(data => {
                        permisosChart.data.labels = data.labels;
                        permisosChart.data.datasets[0].data = data.data;
                        permisosChart.update();
                    })
                    .catch(error => console.error('Error:', error));
            });
        });
    </script>

    @endsection