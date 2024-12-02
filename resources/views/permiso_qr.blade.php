@extends('layouts.main')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">Detalles del Permiso</h1>
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white">
            <h3 class="text-center">Permiso N° {{ $permiso->id }}</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Información del vehículo -->
                <div class="col-md-6">
                    <h5><strong>Información del Vehículo</strong></h5>
                    <p><strong>Placa:</strong> {{ $permiso->vehiculo->placa }}</p>
                    <p><strong>Marca:</strong> {{ $permiso->vehiculo->marca }}</p>
                    <p><strong>Modelo:</strong> {{ $permiso->vehiculo->modelo }}</p>
                </div>
                <!-- Información del conductor -->
                <div class="col-md-6">
                    <h5><strong>Información del Conductor</strong></h5>
                    <p><strong>Nombre:</strong> {{ $permiso->conductor->nombre }}</p>
                    <p><strong>DNI:</strong> {{ $permiso->conductor->dni ?? 'No disponible' }}</p>
                    <p><strong>Asociación:</strong> {{ $permiso->conductor->asociacion->nombre ?? 'No Asociado' }}</p>
                </div>
            </div>

            <hr>

            <div class="row">
                <!-- Información del permiso -->
                <div class="col-md-6">
                    <h5><strong>Detalles del Permiso</strong></h5>
                    <p><strong>Fecha de Emisión:</strong> {{ $permiso->fecha_emision }}</p>
                    <p><strong>Fecha de Expiración:</strong> {{ $permiso->fecha_expiracion }}</p>
                    <p><strong>Estado:</strong>
                        <span class="badge 
                            @if($permiso->estado == 'Vigente') badge-success 
                            @elseif($permiso->estado == 'Expirado') badge-danger 
                            @else badge-warning @endif">
                            {{ $permiso->estado }}
                        </span>
                    </p>
                </div>
                <!-- Código QR -->
                <div class="col-md-6 text-center">
                    <h5><strong>Código QR</strong></h5>
                    <img src="{{ $permiso->codigo_qr }}" alt="Código QR" class="img-fluid border border-primary p-2">
                    <a href="{{ $permiso->codigo_qr }}" class="btn btn-outline-primary btn-sm mt-3" download="Permiso_{{ $permiso->id }}_QR.png">
                        <i class="fas fa-download"></i> Descargar QR
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="text-center mt-4">
        <a href="{{ route('permisos.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver a Permisos
        </a>
    </div>
</div>
@endsection