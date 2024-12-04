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
</style>

<div class="container-fluid">
    <!-- Título y botón de crear -->
    <div class="row mb-3">
        <div class="col-12">
            <h1 class="mb-3">Gestión de Roles</h1>
            <button class="btn btn-primary" data-toggle="modal" data-target="#crearRolModal">
                <i class="fas fa-plus"></i> Crear Rol
            </button>
        </div>
    </div>

    <!-- Tabla de roles -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Lista de Roles</h3>
                </div>
                <div class="card-body">
                    <table id="rolesTable" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $rol)
                            <tr>
                                <td>{{ $rol->id }}</td>
                                <td>{{ $rol->nombre }}</td>
                                <td>{{ $rol->descripcion }}</td>
                                <td>
                                    <!-- Botón Editar -->
                                    <button class="btn btn-warning btn-sm editar" data-toggle="modal" data-target="#editarRolModal"
                                        data-id="{{ $rol->id }}" data-nombre="{{ $rol->nombre }}" data-descripcion="{{ $rol->descripcion }}">
                                        <i class="fas fa-edit"></i> Editar
                                    </button>
                                    <!-- Botón Eliminar -->
                                    <form action="{{ route('rols.destroy', $rol->id) }}" method="POST" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm eliminar-rol">
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

<!-- Modal para Crear Rol -->
<div class="modal fade" id="crearRolModal" tabindex="-1" role="dialog" aria-labelledby="crearRolModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('rols.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="crearRolModalLabel">Crear Rol</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nombreRol">Nombre</label>
                        <input type="text" class="form-control" id="nombreRol" name="nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="descripcionRol">Descripción</label>
                        <textarea class="form-control" id="descripcionRol" name="descripcion" rows="3"></textarea>
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

<!-- Modal para Editar Rol -->
<div class="modal fade" id="editarRolModal" tabindex="-1" role="dialog" aria-labelledby="editarRolModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="" method="POST" id="editarRolForm">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarRolModalLabel">Editar Rol</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="editarRolId" name="id">
                    <div class="form-group">
                        <label for="editarNombreRol">Nombre</label>
                        <input type="text" class="form-control" id="editarNombreRol" name="nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="editarDescripcionRol">Descripción</label>
                        <textarea class="form-control" id="editarDescripcionRol" name="descripcion" rows="3"></textarea>
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
    $(document).ready(function() {

        /*$('#rolesTable').on('.edutar', function(event) {
            alert("aaa")
            const button = $(event.relatedTarget);
            const id = button.data('id');
            const nombre = button.data('nombre');
            const descripcion = button.data('descripcion');

            $('#editarRolId').val(id);
            $('#editarNombreRol').val(nombre);
            $('#editarDescripcionRol').val(descripcion);

            $('#editarRolForm').attr('action', `{{ url('/rols') }}/${id}`);
        });*/

        $('#rolesTable').DataTable({
            responsive: true,
            autoWidth: false,
            language: {
                url: "//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json"
            }
        });

        //Configuración de modal de edición
        $('#editarRolModal').on('show.bs.modal', function(event) {
            console.log('holaaa');
            const button = $(event.relatedTarget);
            const id = button.data('id');
            const nombre = button.data('nombre');
            const descripcion = button.data('descripcion');

            $('#editarRolId').val(id);
            $('#editarNombreRol').val(nombre);
            $('#editarDescripcionRol').val(descripcion);

            $('#editarRolForm').attr('action', `{{ url('/rols') }}/${id}`);
        });

    });

    // 
    //configura el anydesk, par que no
</script>

@endsection