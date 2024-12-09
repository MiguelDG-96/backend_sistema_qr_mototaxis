<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistema de Permisos Circulación | Dashboard</title>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" href="{{ asset('adminlte/dist/img/municipalidad.png') }}" type="image/x-icon">

</head>
<style>
    /* Personalizar el fondo del sidebar */
    .sidebar-custom {
        background-color: #081A3F !important;
        /* Fondo celeste */
        color: #fff;
        /* Texto blanco */
    }

    /* Estilizar el logo y el nombre */
    .sidebar .brand-link {
        background-color: #009fc7;
        /* Color ligeramente más oscuro */
        border-bottom: 1px solid #007ea8;
        /* Línea de separación */
        color: #fff;
    }

    .sidebar .brand-link:hover {
        background-color: black;
        /* Oscurecer al hover */
    }

    .titulo-sidebar {
        color: white;
        text-transform: uppercase;
        font-size: larger;
        font-family: 'Times New Roman', Times, serif;
        text-decoration-color: #fff;
    }

    .sidebar-divider {
        border: 0;
        height: 1px;
        background: white;
        /* Gradiente sutil */
        margin: 10px 0;
        /* Espaciado superior e inferior */
    }

    /* Estilizar el panel de usuario */
    .user-panel {
        color: black;
        border-bottom: 1px solid #007ea8;
        /* Separador debajo del usuario */
    }

    .user-panel img {
        border: 2px solid #fff;
        /* Aumentar contraste del avatar */
    }

    .user-panel .info {
        color: #fff;

    }

    /* Espaciado y mejora de enlaces */
    .nav-sidebar .nav-item {
        margin: 5px 0;
        /* Espaciado entre elementos */
    }

    .nav-sidebar .nav-link {
        color: #fff;
        /* Texto blanco */
        border-radius: 5px;
        /* Bordes redondeados */
        transition: background-color 0.3s, color 0.3s;
        /* Transiciones suaves */
    }

    .nav-sidebar .nav-link i {
        margin-right: 10px;
        /* Separar íconos del texto */
    }

    /* Estilo para el ítem activo */
    .nav-sidebar .nav-link.active {
        background-color: #005f80;
        /* Fondo más oscuro para ítem activo */
        color: #fff;
        font-weight: bold;
        /* Texto en negrita */
        border-left: 5px solid #003f53;
        /* Indicador de sección activa */
    }

    .nav-sidebar .nav-link:hover {
        background-color: #007ea8;
        /* Fondo más oscuro al pasar el mouse */
        color: #f4f4f4;
        /* Texto más claro */
    }

    /* Submenús */
    .nav-treeview .nav-link {
        font-size: 14px;
        /* Texto más pequeño para submenús */
        padding-left: 30px;
        /* Aumentar indentación */
    }

    .nav-treeview .nav-link:hover {
        background-color: #007ea8;
        /* Fondo al hover */
    }
</style>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>
            <!-- Texto animado "Bienvenido, juntos trabajamos por el cambio de nuestro distrito" -->
            <div class="animated-text ml-auto">
                @if(Auth::check()) <!-- Verifica si hay un usuario autenticado -->
                <h3>Bienvenido, {{ Auth::user()->name }}!</h3>
                @else
                <h1>Bienvenido, invitado. Inicia sesión para obtener acceso completo.</h1>
                @endif
            </div>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="nav-link btn btn-link" role="button">
                            <i class="fas fa-sign-out-alt"></i> Cerrar sesión
                        </button>
                    </form>
                </li>
            </ul>
        </nav>

        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-custom elevation-4">
            <!-- Brand Logo -->
            <a href="#" class="brand-link mt-1 pb-3 mb-2 d-flex"">
                <img src=" {{ asset('adminlte/dist/img/municipalidad.png') }}" alt="municipalidad Logo"
                class="brand-image img-circle elevation-3">
                <span class="titulo-sidebar">MDM-2024</span>
            </a>
            <hr class="sidebar-divider">
            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel -->
                <!-- <div class="user-panel mt-0 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{ asset('adminlte/dist/img/muni.ico') }}" class="img-circle elevation-2"
                            alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">{{ Auth::user()->name }}</a>
                    </div>
                </div> -->

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                        <li class="nav-item">
                            <a href="{{ url('/dashboard') }}" class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}">
                                <i class=" nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item has-treeview {{ Request::is('rols*') || Request::is('permisos_acceso*') || Request::is('roles/permisos*') || Request::is('users*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ Request::is('rols*') || Request::is('permisos_acceso*') || Request::is('roles/permisos*') || Request::is('users*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    Usuarios
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ url('/rols') }}" class="nav-link {{ Request::is('rols*') ? 'active' : '' }}">
                                        <i class="fas fa-user-tag nav-icon"></i> <!-- Ícono relacionado con roles -->
                                        <p>Roles</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('/permisos_acceso') }}" class="nav-link {{ Request::is('permisos_acceso*') ? 'active' : '' }}">
                                        <i class="fas fa-key nav-icon"></i> <!-- Ícono relacionado con permisos -->
                                        <p>Permisos</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('/roles/permisos') }}" class="nav-link {{ Request::is('roles/permisos*') ? 'active' : '' }}">
                                        <i class="fas fa-lock nav-icon"></i> <!-- Ícono relacionado con asignar permisos -->
                                        <p>Asignar Permisos</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('/users') }}" class="nav-link {{ Request::is('users*') ? 'active' : '' }}">
                                        <i class="fas fa-users-cog nav-icon"></i> <!-- Ícono relacionado con gestión de usuarios -->
                                        <p>Gestión de Usuarios</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url('/asociaciones') }}" class="nav-link {{ Request::is('asociaciones') ? 'active' : '' }}">
                                <i class=" nav-icon fas fa-building"></i>
                                <p>Asociaciones</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/conductores') }}" class="nav-link {{ Request::is('conductores') ? 'active' : '' }}">
                                <i class=" nav-icon fas fa-id-card"></i>
                                <p>Transportista</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/vehiculos') }}" class="nav-link {{ Request::is('vehiculos') ? 'active' : '' }}">
                                <i class=" nav-icon fas fa-car"></i>
                                <p>Vehículos</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/permisos') }}" class="nav-link {{ Request::is('permisos') ? 'active' : '' }}">
                                <i class=" nav-icon fas fa-file"></i>
                                <p>Permisos Circulación</p>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">

                </div>
            </div>
            <div class="content">
                <div class="container-fluid">
                    @yield('content') <!-- Aquí va el contenido dinámico -->
                </div>
            </div>
        </div>
        <!-- /.content-wrapper -->

        <footer class="main-footer">
            <strong>Copyright &copy; 2024 <a href="/dashboard">Gestión de Permisos de Conducir - MDM</a>.</strong>
            Todos los derechos reservados.
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- Scripts -->
    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
    <script>
        // Aplica automáticamente el contenedor table-responsive a todas las tablas
        $(document).ready(function() {
            $('table').each(function() {
                if (!$(this).parent().hasClass('table-responsive')) {
                    $(this).wrap('<div class="table-responsive"></div>');
                }
            });
        });
    </script>



</body>

</html>