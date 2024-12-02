@extends('layouts.main')

@section('content')
<div class="container">
    <div class="card mt-4">
        <div class="card-header">
            <h1 class="text-center">Gestión de Permisos por Rol</h1>
        </div>
        <div class="card-body">
            <!-- Selección de Rol -->
            <div class="form-group">
                <label for="selectRol" class="font-weight-bold">Selecciona un Rol</label>
                <select class="form-control" id="selectRol">
                    <option value="">-- Selecciona un Rol --</option>
                    @foreach ($roles as $rol)
                    <option value="{{ $rol->id }}">{{ $rol->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Permisos Asignados -->
            <div class="mt-4">
                <h4 class="font-weight-bold">Permisos Asignados</h4>
                <ul id="assignedPermisosList" class="list-group">
                    <li class="list-group-item text-muted">Selecciona un rol para ver sus permisos asignados.</li>
                </ul>
            </div>

            <!-- Asignar Permisos -->
            <div class="mt-4">
                <h4 class="font-weight-bold">Asignar Permisos al Rol</h4>
                <form id="formAssignPermisos">
                    @csrf
                    <div class="form-group">
                        @foreach ($permisos as $permiso)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="permisos[]" value="{{ $permiso->id }}" id="permiso-{{ $permiso->id }}">
                            <label class="form-check-label" for="permiso-{{ $permiso->id }}">
                                {{ $permiso->nombre }} - {{ $permiso->descripcion }}
                            </label>
                        </div>
                        @endforeach
                    </div>
                    <button type="button" class="btn btn-primary" id="btnAssignPermisos">Asignar Permisos</button>
                </form>
            </div>

            <!-- Revocar Permisos -->
            <div class="mt-4">
                <h4 class="font-weight-bold">Revocar Permisos</h4>
                <form id="formRevokePermisos">
                    @csrf
                    @method('DELETE')
                    <div id="revokePermisosList"></div>
                    <button type="button" class="btn btn-danger mt-2" id="btnRevokePermisos">Revocar Permisos</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Obtener permisos asignados al seleccionar un rol
        $('#selectRol').on('change', function() {
            const rolId = $(this).val();

            if (rolId) {
                $.ajax({
                    url: `/rols/${rolId}/permisos`,
                    method: 'GET',
                    success: function(data) {
                        const permisosList = $('#assignedPermisosList');
                        const revokeList = $('#revokePermisosList');

                        permisosList.empty();
                        revokeList.empty();

                        if (data.permisos.length > 0) {
                            data.permisos.forEach(function(permiso) {
                                permisosList.append(`<li class="list-group-item">${permiso.nombre} - ${permiso.descripcion}</li>`);
                                revokeList.append(`
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permisos[]" value="${permiso.id}" id="revoke-${permiso.id}">
                                        <label class="form-check-label" for="revoke-${permiso.id}">${permiso.nombre}</label>
                                    </div>
                                `);
                            });
                        } else {
                            permisosList.append('<li class="list-group-item text-muted">No hay permisos asignados.</li>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                        alert('Error al cargar los permisos asignados.');
                    }
                });
            } else {
                $('#assignedPermisosList').html('<li class="list-group-item text-muted">Selecciona un rol para ver sus permisos asignados.</li>');
                $('#revokePermisosList').empty();
            }
        });

        // Asignar permisos
        $('#btnAssignPermisos').on('click', function() {
            const rolId = $('#selectRol').val();
            const formData = $('#formAssignPermisos').serialize();

            if (!rolId) {
                alert('Por favor, selecciona un rol.');
                return;
            }

            $.ajax({
                url: `/rols/${rolId}/permisos`,
                method: 'POST',
                data: formData,
                success: function(response) {
                    alert(response.message);
                    $('#selectRol').trigger('change'); // Refrescar permisos asignados
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    alert('Error al asignar permisos.');
                }
            });
        });

        // Revocar permisos
        $('#btnRevokePermisos').on('click', function() {
            const rolId = $('#selectRol').val();
            const formData = $('#formRevokePermisos').serialize();

            if (!rolId) {
                alert('Por favor, selecciona un rol.');
                return;
            }

            $.ajax({
                url: `/rols/${rolId}/permisos`,
                method: 'DELETE',
                data: formData,
                success: function(response) {
                    alert(response.message);
                    $('#selectRol').trigger('change'); // Refrescar permisos asignados
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    alert('Error al revocar permisos.');
                }
            });
        });

        // Cargar permisos asignados al cargar la página si ya hay un rol seleccionado
        const preselectedRol = $('#selectRol').val();
        if (preselectedRol) {
            $('#selectRol').trigger('change');
        }
    });
</script>

@endsection