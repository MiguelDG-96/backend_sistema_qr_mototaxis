<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('assets/login/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/login/css/style.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
    <link href="https://tresplazas.com/web/img/big_punto_de_venta.png" rel="shortcut icon">

    <title>Inicio de sesión</title>
</head>

<body>
    <!-- Fondo con imagen -->
    <img class="wave" src="{{ asset('assets/login/img/wave.png') }}">
    <div class="container">
        <div class="img">
            <img src="{{ asset('assets/login/img/MOTOTAXI.svg') }}">
        </div>
        <div class="login-content">
            <!-- Formulario de inicio de sesión -->
            <form method="POST" action="{{ route('login.submit') }}">
                @csrf
                <img src="{{ asset('assets/login/img/avatar.svg') }}">
                <h2 class="title ">Iniciar Sesión</h2>

                <!-- Campo Usuario -->
                <div class="input-div one">
                    <div class="i">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="div">
                        <h5>Correo Electrónico</h5>
                        <input id="usuario" type="email" class="input" name="email" required>
                    </div>
                </div>

                <!-- Campo Contraseña -->
                <div class="input-div pass">
                    <div class="i">
                        <i class="fas fa-lock"></i>
                    </div>
                    <div class="div">
                        <h5>Contraseña</h5>
                        <input type="password" id="input" class="input" name="password" required>
                    </div>
                </div>

                <!-- Icono para ver contraseña -->
                <div class="view">
                    <div class="fas fa-eye verPassword" onclick="vista()" id="verPassword"></div>
                </div>

                <!-- Botón de Iniciar Sesión -->
                <input name="btningresar" class="btn" type="submit" value="Ingresar">
            </form>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('assets/login/js/fontawesome.js') }}"></script>
    <script src="{{ asset('assets/login/js/main.js') }}"></script>
    <script src="{{ asset('assets/login/js/main2.js') }}"></script>
    <script src="{{ asset('assets/login/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/login/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/login/js/bootstrap.bundle.js') }}"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- <script integrity="sha384-YourIntegrityHashHere" crossorigin="anonymous"></script> -->

    <!-- Manejo de alertas con SweetAlert -->

    @if(session('alert'))
    <script>
        Swal.fire({
            icon: '{{ session("alert.type") }}', // Tipo de alerta: error, success, etc.
            title: '{{ session("alert.title") }}', // Título de la alerta
            text: '{{ session("alert.message") }}', // Mensaje de la alerta
            confirmButtonText: '{{ session("alert.confirmButtonText") ?? "Aceptar" }}' // Texto del botón
        });
    </script>
    @endif
    <!-- Suponiendo que el usuario ya está autenticado -->
    @if(Auth::check())
    <h3>Bienvenido, {{ Auth::user()->name }}!</h3>
    @endif

</body>

</html>