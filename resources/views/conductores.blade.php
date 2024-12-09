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
            <h1 class="text-center">Gestión de Transportista</h1>
        </div>
        <div class="card-body">
            <!-- Botón para abrir el modal de registro -->
            <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#registerConductorModal">
                <i class="fas fa-user-plus"></i> Registrar Conductor
            </button>

            <!-- Tabla de conductores -->
            <table class="table table-bordered table-striped table-hover" id="conductoresTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>DNI</th>
                        <th>Teléfono</th>
                        <th>Dirección</th>
                        <th>Asociación</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($conductores as $conductor)
                    <tr>
                        <td>{{ $conductor->id }}</td>
                        <td>{{ $conductor->nombre }}</td>
                        <td>{{ $conductor->dni }}</td>
                        <td>{{ $conductor->telefono }}</td>
                        <td>{{ $conductor->direccion }}</td>
                        <td>{{ $conductor->asociacion->nombre }}</td>
                        <td>
                            <div class="d-flex justify-content-between">
                                <!-- Botón Editar -->
                                <button class="btn btn-warning btn-sm flex-fill mx-1" data-toggle="modal" data-target="#editConductorModal"
                                    data-id="{{ $conductor->id }}"
                                    data-nombre="{{ $conductor->nombre }}"
                                    data-dni="{{ $conductor->dni }}"
                                    data-telefono="{{ $conductor->telefono }}"
                                    data-direccion="{{ $conductor->direccion }}"
                                    data-asociacion="{{ $conductor->id_asociacion }}">
                                    <i class="fas fa-edit"></i> Editar
                                </button>
                                <!-- Botón Desactivar -->
                                <form action="{{ route('conductores.destroy', $conductor->id) }}" method="POST" class="d-inline">
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
    </div>
</div>

<!-- Modal para registrar conductor -->
<div class="modal fade" id="registerConductorModal" tabindex="-1" role="dialog" aria-labelledby="registerConductorModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('conductores.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="registerConductorModalLabel">Registrar Conductor</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="registerNombre">Nombre</label>
                        <input type="text" name="nombre" id="registerNombre" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="registerDni">DNI</label>
                        <input type="text" name="dni" id="registerDni" class="form-control" required maxlength="8">
                    </div>
                    <div class="form-group">
                        <label for="registerTelefono">Teléfono</label>
                        <input type="text" name="telefono" id="registerTelefono" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="registerDireccion">Dirección</label>
                        <input type="text" name="direccion" id="registerDireccion" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="registerAsociacion">Asociación</label>
                        <select name="id_asociacion" id="registerAsociacion" class="form-control" required>
                            <option value="">-- Seleccionar Asociación --</option>
                            @foreach ($asociaciones as $asociacion)
                            <option value="{{ $asociacion->id }}">{{ $asociacion->nombre }}</option>
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

<!-- Modal para editar conductor -->
<div class="modal fade" id="editConductorModal" tabindex="-1" role="dialog" aria-labelledby="editConductorModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="" method="POST" id="editConductorForm">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editConductorModalLabel">Editar Conductor</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="editNombre">Nombre</label>
                        <input type="text" name="nombre" id="editNombre" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="editDni">DNI</label>
                        <input type="text" name="dni" id="editDni" class="form-control" required maxlength="8">
                    </div>
                    <div class="form-group">
                        <label for="editTelefono">Teléfono</label>
                        <input type="text" name="telefono" id="editTelefono" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="editDireccion">Dirección</label>
                        <input type="text" name="direccion" id="editDireccion" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="editAsociacion">Asociación</label>
                        <select name="id_asociacion" id="editAsociacion" class="form-control" required>
                            @foreach ($asociaciones as $asociacion)
                            <option value="{{ $asociacion->id }}">{{ $asociacion->nombre }}</option>
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
        $('#conductoresTable').DataTable({
            responsive: true,
            autoWidth: false,
            language: {
                url: "//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json"
            }
        });

        $('#editConductorModal').on('show.bs.modal', function(event) {
            const button = $(event.relatedTarget);
            const id = button.data('id');
            const nombre = button.data('nombre');
            const dni = button.data('dni');
            const telefono = button.data('telefono');
            const direccion = button.data('direccion');
            const asociacion = button.data('asociacion');

            $('#editNombre').val(nombre);
            $('#editDni').val(dni);
            $('#editTelefono').val(telefono);
            $('#editDireccion').val(direccion);
            $('#editAsociacion').val(asociacion);

            $('#editConductorForm').attr('action', `/conductores/${id}`);
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