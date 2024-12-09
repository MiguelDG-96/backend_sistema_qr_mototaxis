@extends('layouts.main')

@section('content')
<style>

</style>
<div class="container">
    <div class="card mt-4">
        <div class="card-header">
            <h1 class="text-center">Gestión de Usuarios</h1>
        </div>
        <div class="card-body">
            <!-- Botón para abrir el modal de registro -->
            <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#registerUserModal">
                <i class="fas fa-user-plus"></i> Registrar Usuario
            </button>

            <!-- Tabla de usuarios -->
            <table class="table table-bordered table-striped table-hover" id="usersTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->rol->nombre }}</td>
                        <td>
                            <!-- Botón Editar -->
                            <div class="d-flex justify-content-evenly ">
                                <button class="btn btn-warning btn-sm mx-3" data-toggle="modal" data-target="#editUserModal"
                                    data-id="{{ $user->id }}"
                                    data-name="{{ $user->name }}"
                                    data-email="{{ $user->email }}"
                                    data-rol="{{ $user->id_rol }}">
                                    <i class="fas fa-edit"></i> Editar
                                </button>

                                <!-- Botón Desactivar -->
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm ">
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

<!-- Modal para registrar usuario -->
<div class="modal fade" id="registerUserModal" tabindex="-1" role="dialog" aria-labelledby="registerUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('users.register') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="registerUserModalLabel">Registrar Usuario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="registerName">Nombre</label>
                        <input type="text" name="name" id="registerName" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="registerEmail">Email</label>
                        <input type="email" name="email" id="registerEmail" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="registerPassword">Contraseña</label>
                        <input type="password" name="password" id="registerPassword" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="registerRol">Rol</label>
                        <select name="id_rol" id="registerRol" class="form-control" required>
                            <option value="">-- Seleccionar Rol --</option>
                            @foreach ($roles as $rol)
                            <option value="{{ $rol->id }}">{{ $rol->nombre }}</option>
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

<!-- Modal para editar usuario -->
<div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="" method="POST" id="editUserForm">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">Editar Usuario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="editName">Nombre</label>
                        <input type="text" name="name" id="editName" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="editEmail">Email</label>
                        <input type="email" name="email" id="editEmail" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="editRol">Rol</label>
                        <select name="id_rol" id="editRol" class="form-control" required>
                            @foreach ($roles as $rol)
                            <option value="{{ $rol->id }}">{{ $rol->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="editPassword">Nueva Contraseña (Opcional)</label>
                        <input type="password" name="password" id="editPassword" class="form-control">
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.3/sweetalert2.all.min.js"></script>

<script>
    $(document).ready(function() {
        $('#usersTable').DataTable({
            responsive: true,
            autoWidth: false,
            language: {
                url: "//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json"
            }
        });

        $('#editUserModal').on('show.bs.modal', function(event) {
            const button = $(event.relatedTarget);
            const id = button.data('id');
            const name = button.data('name');
            const email = button.data('email');
            const rol = button.data('rol');

            $('#editName').val(name);
            $('#editEmail').val(email);
            $('#editRol').val(rol);

            $('#editUserForm').attr('action', `/users/${id}`);
        });
    });
</script>
@if(session('alert'))
<script>
    Swal.fire({
        icon: "{{ session('alert.type') }}",
        title: "{{ session('alert.title') }}",
        text: "{{ session('alert.message') }}",
        confirmButtonText: "{{ session('alert.confirmButtonText') }}"
    });
</script>
@endif
@endsection