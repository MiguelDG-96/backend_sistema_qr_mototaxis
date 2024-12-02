@extends('layouts.main')

@section('content')
<div class="container">
    <div class="card mt-4">
        <div class="card-header">
            <h1 class="text-center">Gestión de Asociaciones</h1>
        </div>
        <div class="card-body">
            <!-- Botón para abrir el modal de registro -->
            <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#registerAsociacionModal">
                <i class="fas fa-plus"></i> Registrar Asociación
            </button>

            <!-- Tabla de asociaciones -->
            <table class="table table-bordered table-striped" id="asociacionesTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Dirección</th>
                        <th>Teléfono</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($asociaciones as $asociacion)
                    <tr>
                        <td>{{ $asociacion->id }}</td>
                        <td>{{ $asociacion->nombre }}</td>
                        <td>{{ $asociacion->direccion }}</td>
                        <td>{{ $asociacion->telefono }}</td>
                        <td>{{ $asociacion->estado ? 'Activo' : 'Inactivo' }}</td>
                        <td>
                            <!-- Botón Editar -->
                            <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editAsociacionModal"
                                data-id="{{ $asociacion->id }}"
                                data-nombre="{{ $asociacion->nombre }}"
                                data-direccion="{{ $asociacion->direccion }}"
                                data-telefono="{{ $asociacion->telefono }}"
                                data-estado="{{ $asociacion->estado }}">
                                <i class="fas fa-edit"></i> Editar
                            </button>
                            <!-- Botón Desactivar -->
                            <form action="{{ route('asociaciones.destroy', $asociacion->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i> Desactivar
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal para registrar asociación -->
<div class="modal fade" id="registerAsociacionModal" tabindex="-1" role="dialog" aria-labelledby="registerAsociacionModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('asociaciones.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="registerAsociacionModalLabel">Registrar Asociación</h5>
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
                        <label for="registerDireccion">Dirección</label>
                        <input type="text" name="direccion" id="registerDireccion" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="registerTelefono">Teléfono</label>
                        <input type="text" name="telefono" id="registerTelefono" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="registerEstado">Estado</label>
                        <select name="estado" id="registerEstado" class="form-control" required>
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
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

<!-- Modal para editar asociación -->
<div class="modal fade" id="editAsociacionModal" tabindex="-1" role="dialog" aria-labelledby="editAsociacionModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="" method="POST" id="editAsociacionForm">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editAsociacionModalLabel">Editar Asociación</h5>
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
                        <label for="editDireccion">Dirección</label>
                        <input type="text" name="direccion" id="editDireccion" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="editTelefono">Teléfono</label>
                        <input type="text" name="telefono" id="editTelefono" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="editEstado">Estado</label>
                        <select name="estado" id="editEstado" class="form-control" required>
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
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
        // Inicializar DataTables
        $('#asociacionesTable').DataTable({
            responsive: true,
            autoWidth: false,
            language: {
                url: "//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json"
            }
        });

        // Configurar el modal de edición
        $('#editAsociacionModal').on('show.bs.modal', function(event) {
            const button = $(event.relatedTarget);
            const id = button.data('id');
            const nombre = button.data('nombre');
            const direccion = button.data('direccion');
            const telefono = button.data('telefono');
            const estado = button.data('estado');

            $('#editNombre').val(nombre);
            $('#editDireccion').val(direccion);
            $('#editTelefono').val(telefono);
            $('#editEstado').val(estado);

            $('#editAsociacionForm').attr('action', `/asociaciones/${id}`);
        });
    });
</script>
@endsection