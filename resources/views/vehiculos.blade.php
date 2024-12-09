@extends('layouts.main')

@section('content')
<style>
    .btn {
        white-space: nowrap;
        /* Evita que el texto se divida en varias líneas */
        font-size: 0.875rem;
        /* Ajusta el tamaño del texto */
    }

    .d-flex .btn {
        flex: 1;
        /* Asegura que los botones ocupen el mismo espacio */
    }
</style>
<div class="container">
    <div class="card mt-4">
        <div class="card-header">
            <h1 class="text-center">Gestión de Vehículos</h1>
        </div>
        <div class="card-body">
            <!-- Botón para abrir el modal de registro -->
            <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#registerVehiculoModal">
                <i class="fas fa-plus"></i> Registrar Vehículo
            </button>

            <!-- Tabla de vehículos -->
            <table class="table table-bordered table-striped table-hover" id="vehiculosTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Placa</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Año</th>
                        <th>Conductor</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($vehiculos as $vehiculo)
                    <tr>
                        <td>{{ $vehiculo->id }}</td>
                        <td>{{ $vehiculo->placa }}</td>
                        <td>{{ $vehiculo->marca }}</td>
                        <td>{{ $vehiculo->modelo }}</td>
                        <td>{{ $vehiculo->anio }}</td>
                        <td>{{ $vehiculo->conductor->nombre ?? 'No asignado' }}</td>
                        <td>
                            <div class="d-flex justify-content-between">
                                <!-- Botón Editar -->
                                <button class="btn btn-warning btn-sm flex-fill mx-1" data-toggle="modal" data-target="#editVehiculoModal"
                                    data-id="{{ $vehiculo->id }}"
                                    data-placa="{{ $vehiculo->placa }}"
                                    data-marca="{{ $vehiculo->marca }}"
                                    data-modelo="{{ $vehiculo->modelo }}"
                                    data-anio="{{ $vehiculo->anio }}"
                                    data-conductor="{{ $vehiculo->id_conductor }}">
                                    <i class="fas fa-edit"></i> Editar
                                </button>
                                <!-- Botón Desactivar -->
                                <form action="{{ route('vehiculos.destroy', $vehiculo->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm w-100">
                                        <i class="fas fa-trash"></i> Desactivar
                                    </button>
                                </form>
                            </div>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal para registrar vehículo -->
<div class="modal fade" id="registerVehiculoModal" tabindex="-1" role="dialog" aria-labelledby="registerVehiculoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('vehiculos.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="registerVehiculoModalLabel">Registrar Vehículo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="registerPlaca">Placa</label>
                        <input type="text" name="placa" id="registerPlaca" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="registerMarca">Marca</label>
                        <input type="text" name="marca" id="registerMarca" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="registerModelo">Modelo</label>
                        <input type="text" name="modelo" id="registerModelo" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="registerAnio">Año</label>
                        <input type="number" name="anio" id="registerAnio" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="registerConductor">Conductor</label>
                        <select name="id_conductor" id="registerConductor" class="form-control" required>
                            <option value="">-- Seleccionar Conductor --</option>
                            @foreach ($conductores as $conductor)
                            <option value="{{ $conductor->id }}">{{ $conductor->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Registrar</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal para editar vehículo -->
<div class="modal fade" id="editVehiculoModal" tabindex="-1" role="dialog" aria-labelledby="editVehiculoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="" method="POST" id="editVehiculoForm">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editVehiculoModalLabel">Editar Vehículo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="editPlaca">Placa</label>
                        <input type="text" name="placa" id="editPlaca" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="editMarca">Marca</label>
                        <input type="text" name="marca" id="editMarca" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="editModelo">Modelo</label>
                        <input type="text" name="modelo" id="editModelo" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="editAnio">Año</label>
                        <input type="number" name="anio" id="editAnio" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="editConductor">Conductor</label>
                        <select name="id_conductor" id="editConductor" class="form-control" required>
                            @foreach ($conductores as $conductor)
                            <option value="{{ $conductor->id }}">{{ $conductor->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#vehiculosTable').DataTable({
            responsive: true,
            autoWidth: false,
            language: {
                url: "//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json"
            }
        });

        $('#editVehiculoModal').on('show.bs.modal', function(event) {
            const button = $(event.relatedTarget);
            const id = button.data('id');
            const placa = button.data('placa');
            const marca = button.data('marca');
            const modelo = button.data('modelo');
            const anio = button.data('anio');
            const conductor = button.data('conductor');

            $('#editPlaca').val(placa);
            $('#editMarca').val(marca);
            $('#editModelo').val(modelo);
            $('#editAnio').val(anio);
            $('#editConductor').val(conductor);

            $('#editVehiculoForm').attr('action', `/vehiculos/${id}`);
        });
    });
</script>
@if(session('alert'))
<script>
    Swal.fire({
        icon: '{{ session("alert.type") }}', // Tipo de alerta (success, error)
        title: '{{ session("alert.title") }}', // Título de la alerta
        text: '{{ session("alert.message") }}', // Mensaje de la alerta
        confirmButtonText: '{{ session("alert.confirmButtonText") ?? "Aceptar" }}' // Botón de confirmación
    });
</script>
@endif

@endsection