@extends('layouts.main')

@section('content')
<div class="container mt-4">
    <h1 class="text-center">Gestión de Permisos</h1>

    <!-- Botón para abrir el modal de registro -->
    <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#registerPermisoModal">
        <i class="fas fa-plus"></i> Registrar Permiso
    </button>

    <!-- Tabla de permisos -->
    <table class="table table-bordered table-striped" id="permisosTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Vehículo</th>
                <th>Conductor</th>
                <th>Fecha Emisión</th>
                <th>Fecha Expiración</th>
                <th>Estado</th>
                <th>Código QR</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($permisos as $permiso)
            <tr>
                <td>{{ $permiso->id }}</td>
                <td>{{ $permiso->vehiculo->placa }}</td>
                <td>{{ $permiso->conductor->nombre }}</td>
                <td>{{ $permiso->fecha_emision }}</td>
                <td>{{ $permiso->fecha_expiracion }}</td>
                <td>
                    <span class="badge 
                        @if($permiso->estado == 'Vigente') badge-success 
                        @elseif($permiso->estado == 'Expirado') badge-danger 
                        @else badge-warning @endif">
                        {{ $permiso->estado }}
                    </span>
                </td>
                <td>
                    <a href="{{ route('permisos.showQr', $permiso->id) }}" target="_blank">
                        <img src="{{ $permiso->codigo_qr }}" alt="QR Code" style="width: 50px; height: 50px;">
                    </a>
                    <br>
                    <a href="{{ route('permisos.download_qr', $permiso->id) }}" target="_blank" class="btn btn-sm btn-info mt-2">
                        Descargar QR
                    </a>
                </td>
                <td>
                    <!-- Botón Editar -->
                    <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editPermisoModal"
                        data-id="{{ $permiso->id }}"
                        data-vehiculo="{{ $permiso->id_vehiculo }}"
                        data-conductor="{{ $permiso->id_conductor }}"
                        data-fecha_emision="{{ $permiso->fecha_emision }}"
                        data-fecha_expiracion="{{ $permiso->fecha_expiracion }}"
                        data-estado="{{ $permiso->estado }}">
                        <i class="fas fa-edit"></i> Editar
                    </button>
                    <!-- Botón Eliminar -->
                    <form action="{{ route('permisos.destroy', $permiso->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="fas fa-trash"></i> Eliminar
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal para registrar permiso -->
<div class="modal fade" id="registerPermisoModal" tabindex="-1" role="dialog" aria-labelledby="registerPermisoModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('permisos.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="registerPermisoModalLabel">Registrar Permiso</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="vehiculo">Vehículo</label>
                        <select name="id_vehiculo" id="vehiculo" class="form-control" required>
                            <option value="">-- Seleccionar Vehículo --</option>
                            @foreach ($vehiculos as $vehiculo)
                            <option value="{{ $vehiculo->id }}">{{ $vehiculo->placa }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="conductor">Conductor</label>
                        <select name="id_conductor" id="conductor" class="form-control" required>
                            <option value="">-- Seleccionar Conductor --</option>
                            @foreach ($conductores as $conductor)
                            <option value="{{ $conductor->id }}">{{ $conductor->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="fecha_emision">Fecha de Emisión</label>
                        <input type="date" name="fecha_emision" id="fecha_emision" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="fecha_expiracion">Fecha de Expiración</label>
                        <input type="date" name="fecha_expiracion" id="fecha_expiracion" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="estado">Estado</label>
                        <select name="estado" id="estado" class="form-control" required>
                            <option value="Vigente">Vigente</option>
                            <option value="Expirado">Expirado</option>
                            <option value="Suspendido">Suspendido</option>
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

<!-- Modal para editar permiso -->
<div class="modal fade" id="editPermisoModal" tabindex="-1" role="dialog" aria-labelledby="editPermisoModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="editPermisoForm" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPermisoModalLabel">Editar Permiso</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Campos de edición -->
                    <input type="hidden" name="id" id="edit_permiso_id">
                    <div class="form-group">
                        <label for="edit_vehiculo">Vehículo</label>
                        <select name="id_vehiculo" id="edit_vehiculo" class="form-control" required>
                            @foreach ($vehiculos as $vehiculo)
                            <option value="{{ $vehiculo->id }}">{{ $vehiculo->placa }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_conductor">Conductor</label>
                        <select name="id_conductor" id="edit_conductor" class="form-control" required>
                            @foreach ($conductores as $conductor)
                            <option value="{{ $conductor->id }}">{{ $conductor->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_fecha_emision">Fecha de Emisión</label>
                        <input type="date" name="fecha_emision" id="edit_fecha_emision" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_fecha_expiracion">Fecha de Expiración</label>
                        <input type="date" name="fecha_expiracion" id="edit_fecha_expiracion" class="form-control"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="edit_estado">Estado</label>
                        <select name="estado" id="edit_estado" class="form-control" required>
                            <option value="Vigente">Vigente</option>
                            <option value="Expirado">Expirado</option>
                            <option value="Suspendido">Suspendido</option>
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
        $('#permisosTable').DataTable({
            responsive: true,
            language: {
                url: "//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json"
            }
        });

        $('#editPermisoModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var vehiculo = button.data('vehiculo');
            var conductor = button.data('conductor');
            var fecha_emision = button.data('fecha_emision');
            var fecha_expiracion = button.data('fecha_expiracion');
            var estado = button.data('estado');

            $('#edit_permiso_id').val(id);
            $('#edit_vehiculo').val(vehiculo);
            $('#edit_conductor').val(conductor);
            $('#edit_fecha_emision').val(fecha_emision);
            $('#edit_fecha_expiracion').val(fecha_expiracion);
            $('#edit_estado').val(estado);

            $('#editPermisoForm').attr('action', '/permisos/' + id);
        });
    });
</script>
@endsection