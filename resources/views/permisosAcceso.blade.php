@extends('layouts.main')

@section('content')
<style>
    .card {
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .btn-primary,
    .btn-warning,
    .btn-danger {
        border-radius: 5px;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .table th,
    .table td {
        vertical-align: middle;
        text-align: center;
    }

    .table th {
        background-color: #f4f6f9;
    }

    .modal-header {
        background-color: #007bff;
        color: white;
        border-radius: 5px 5px 0 0;
    }

    .modal-footer .btn-secondary {
        background-color: #6c757d;
    }

    .header-controls {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
    }

    .header-controls .search-input {
        width: 250px;
    }

    .header-controls button {
        margin-bottom: 10px;
        /* Para evitar superposición en pantallas pequeñas */
    }
</style>

<div class="container-fluid">
    <!-- Título y controles -->
    <div class="row mb-3">
        <div class="col-12">
            <h1 class="mb-3">Gestión de Permisos de Acceso</h1>
        </div>
    </div>

    <!-- Buscador y botón de crear -->
    <div class="row mb-3">
        <!-- Botón Crear Permiso -->
        <div class="col-md-6">
            <button class="btn btn-primary" data-toggle="modal" data-target="#crearPermisoModal">
                <i class="fas fa-plus"></i> Crear Permiso
            </button>
        </div>

    </div>

    <!-- Tabla de permisos -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Lista de Permisos</h3>
                </div>
                <div class="card-body">
                    <table id="permisosTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($permisos as $permiso)
                            <tr>
                                <td>{{ $permiso->id }}</td>
                                <td>{{ $permiso->nombre }}</td>
                                <td>{{ $permiso->descripcion }}</td>
                                <td>
                                    <!-- Botón Editar -->
                                    <button class="btn btn-warning btn-sm" data-toggle="modal"
                                        data-target="#editarPermisoModal" data-id="{{ $permiso->id }}"
                                        data-nombre="{{ $permiso->nombre }}"
                                        data-descripcion="{{ $permiso->descripcion }}">
                                        <i class="fas fa-edit"></i> Editar
                                    </button>
                                    <!-- Botón Eliminar -->
                                    <form action="{{ route('permisos_acceso.destroy', $permiso->id) }}"
                                        method="POST" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm eliminar-permiso">
                                            <i class="fas fa-trash"></i> Eliminar
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
    </div>
</div>

<!-- Modal para Crear Permiso -->
<div class="modal fade" id="crearPermisoModal" tabindex="-1" role="dialog" aria-labelledby="crearPermisoModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('permisos_acceso.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="crearPermisoModalLabel">Crear Permiso</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nombrePermiso">Nombre</label>
                        <input type="text" class="form-control" id="nombrePermiso" name="nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="descripcionPermiso">Descripción</label>
                        <textarea class="form-control" id="descripcionPermiso" name="descripcion" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="editarPermisoModal" tabindex="-1" role="dialog" aria-labelledby="editarPermisoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="" method="POST" id="editarPermisoForm">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarPermisoModalLabel">Editar Permiso</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="editarPermisoId" name="id">
                    <div class="form-group">
                        <label for="editarNombrePermiso">Nombre</label>
                        <input type="text" class="form-control" id="editarNombrePermiso" name="nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="editarDescripcionPermiso">Descripción</label>
                        <textarea class="form-control" id="editarDescripcionPermiso" name="descripcion" rows="3"></textarea>
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
<script src="//cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: '¡Éxito!',
        text: '{{ session("success") }}',
        showConfirmButton: false,
        timer: 2000
    });
</script>
@endif

@if(session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: '{{ session("error") }}',
        showConfirmButton: false,
        timer: 2000
    });
</script>
@endif
<script>
    // Usar window.onload para asegurar que todo esté cargado
    $(document).ready(function() {

        // Inicializar DataTables y desactivar el buscador automático
        $('#permisosTable').DataTable({
            responsive: true,
            autoWidth: false,
            language: {
                url: "//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json"
            }
        });

        // Evento al hacer clic en el botón de búsqueda
        $('#searchButton').on('click', function() {
            let query = $('#searchInput').val().trim(); // Obtener el texto del buscador
            table.search(query).draw(); // Aplicar el filtro a la tabla
        });

        // Evento de búsqueda en tiempo real (mientras se escribe)
        $('#searchInput').on('keyup', function() {
            let query = $(this).val().trim(); // Obtener el texto del buscador
            table.search(query).draw(); // Aplicar el filtro a la tabla
        });

        // Confirmación de eliminación con SweetAlert
        $('.eliminar-permiso').on('click', function(e) {
            e.preventDefault();
            const form = $(this).closest('form');
            Swal.fire({
                title: '¿Estás seguro?',
                text: 'Esta acción no se puede deshacer',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });

        // Configurar el modal de edición

        $('#editarPermisoModal').on('show.bs.modal', function(event) {
            const button = $(event.relatedTarget); // Botón que activó el modal
            const id = button.data('id'); // Obtén el ID del permiso
            const nombre = button.data('nombre'); // Obtén el nombre del permiso
            const descripcion = button.data('descripcion'); // Obtén la descripción del permiso

            // Asignar valores a los campos del formulario
            $('#editarPermisoId').val(id);
            $('#editarNombrePermiso').val(nombre);
            $('#editarDescripcionPermiso').val(descripcion);

            // Asignar la acción dinámica al formulario
            const actionUrl = `/permisos_acceso/${id}`;
            $('#editarPermisoForm').attr('action', actionUrl);
        });

    });
</script>

@endsection