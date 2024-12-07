@extends('layouts.main')

@section('content')
<style>
    .form-group {
        position: relative;
        /* Asegura que los elementos hijos con posición absoluta se alineen correctamente */
    }

    .dropdown-menu {
        position: absolute;
        top: 100%;
        /* Ubica el menú justo debajo del input */
        left: 0;
        width: 100%;
        /* Asegura que el ancho del menú sea igual al del input */
        max-height: 200px;
        /* Altura máxima del menú */
        overflow-y: auto;
        /* Permite el scroll si hay demasiados elementos */
        z-index: 1050;
        /* Coloca el menú encima de otros elementos */
        display: none;
        /* Oculta el menú por defecto */
        background-color: #fff;
        /* Fondo blanco para el menú */
        border: 1px solid #ddd;
        /* Borde gris claro */
        border-radius: 4px;
        /* Bordes redondeados */
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        /* Sombra para mejor visibilidad */
    }

    .dropdown-item {
        padding: 8px 12px;
        cursor: pointer;
    }

    /* Cambia el color de fondo al pasar el cursor */
    .dropdown-item:hover {
        background-color: #e9ecef;
        /* Un gris claro */
    }

    /* Opcional: Cambia el color de texto también, si lo deseas */
    .dropdown-item:hover {
        color: #495057;
        /* Gris oscuro */
    }

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

<div class="container mt-0">
    <h1 class="text-center">Gestión de Permisos</h1>

    <!-- Botón para abrir el modal de registro -->
    <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#registerPermisoModal">
        <i class="fas fa-plus"></i> Registrar Permiso
    </button>

    <!-- Tabla de permisos -->
    <table class="table table-bordered table-striped table-hover" id="permisosTable">
        <thead>
            <tr>
                <th>Item</th>
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
                    <div class="d-flex justify-content-between">
                        <!-- Botón Editar -->
                        <button class="btn btn-warning btn-sm flex-fill mx-1" data-toggle="modal" data-target="#editPermisoModal"
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
                            <button type="submit" class="btn btn-danger btn-sm w-100">
                                <i class="fas fa-trash"></i> Eliminar
                            </button>
                        </form>
                    </div>
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
                        <label for="vehiculo">Número de placa del Vehículo</label>
                        <input type="text" id="vehiculo_search" class="form-control" placeholder="Ingrese placa del vehículo">
                        <input type="hidden" name="id_vehiculo" id="vehiculo_id">
                        <ul class="dropdown-menu" id="vehiculo_results"></ul>
                    </div>
                    <div class="form-group">
                        <label for="conductor">Conductor (Buscar por nombre)</label>
                        <input type="text" id="conductor_search" class="form-control" placeholder="Ingrese nombre del conductor">
                        <input type="hidden" name="id_conductor" id="conductor_id">
                        <ul class="dropdown-menu" id="conductor_results"></ul>
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
        function setupAutocomplete(inputId, resultListId, hiddenFieldId, url) {
            $(inputId).on('input', function() {
                const query = $(this).val();
                if (query.length > 1) {
                    $.ajax({
                        url: url,
                        method: 'GET',
                        data: {
                            search: query
                        },
                        success: function(data) {
                            const list = $(resultListId);
                            list.empty();
                            if (data.length > 0) {
                                data.forEach(item => {
                                    list.append(`<li class="dropdown-item" data-id="${item.id}" data-value="${item.text}">${item.text}</li>`);
                                });
                                list.show();
                            } else {
                                list.hide();
                            }
                        }
                    });
                } else {
                    $(resultListId).hide();
                }
            });

            $(document).on('click', resultListId + ' li', function() {
                const id = $(this).data('id');
                const value = $(this).data('value');
                $(inputId).val(value);
                $(hiddenFieldId).val(id);
                $(resultListId).hide();
            });

            $(document).on('click', function(e) {
                if (!$(e.target).closest(inputId).length && !$(e.target).closest(resultListId).length) {
                    $(resultListId).hide();
                }
            });
        }
        setupAutocomplete('#vehiculo_search', '#vehiculo_results', '#vehiculo_id', '/permisos/search/vehiculos');
        setupAutocomplete('#conductor_search', '#conductor_results', '#conductor_id', '/permisos/search/conductores');
    });
</script>

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