<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

    <div class="titulo">
        <h1 class="titulo">Registro</h1>
    </div>

    <nav class="barra">
        <a href="{{ route('index') }}">Inicio</a>
        <a href="{{ route('contacto') }}">Contacto</a>
        <a href="contacto">Contacto</a>
        <a href="{{ route('login') }}">Login</a>
    </nav>

    <section class="form-cont">
        <h2 class="subtitulo">Registro de Usuario</h2>

        {{-- Mostrar errores si existen --}}
        @if ($errors->any())
            <div class="errores">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('registro.store') }}" method="POST" class="formulario">
            @csrf

            <input type="text" name="nombre" placeholder="Nombre completo" value="{{ old('nombre') }}" required>
            <input type="email" name="email" placeholder="Correo electrónico" value="{{ old('email') }}" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <input type="password" name="confirmar_password" placeholder="Confirmar contraseña" required>
            <input type="tel" name="telefono" placeholder="Teléfono" value="{{ old('telefono') }}">

            <button type="submit">Registrarse</button>
        </form>

        <p>¿Ya tienes cuenta? <a href="{{ route('login') }}">Login</a></p>
    </section>

    <footer class="pie">
        <p class="grande">Creado por Honey y Sunshine</p>
        <div class="icons"></div>
        <section class="cont-2">
            <div class="cont"></div>
        </section>
    </footer>

</body>
</html>
