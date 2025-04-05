<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de la Propiedad</title>
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

    <div class="titulo">
        <h1>Detalles</h1>
    </div>

    <nav class="barra">
        <a href="{{ route('index') }}">Inicio</a>
        <a href="{{ route('propiedades.index') }}">Propiedades</a>
        <a href="{{ route('propiedades.create') }}">Registrar Propiedad</a>
        <a href="{{ route('contacto') }}">Contacto</a>
        <a href="{{ route('registro') }}">Registro</a>
        <a href="{{ route('login') }}">Login</a>
        <a href="{{ route('perfil') }}">Perfil</a>
    </nav>

    <main class="cont-detalles">
        <section class="cont-1">
            <h2 class="subtitulo">Detalles de la Propiedad</h2>
            <div class="propiedad">
                <p><strong>Tipo:</strong> {{ $propiedad->tipo }}</p>
                <p><strong>Dirección:</strong> {{ $propiedad->direccion }}</p>
                <p><strong>Referencias:</strong> {{ $propiedad->referencias }}</p>
                <p><strong>Descripción:</strong> {{ $propiedad->descripcion }}</p>
                <p><strong>Precio:</strong> ${{ number_format($propiedad->precio, 2) }}</p>
                <p><strong>Habitaciones:</strong> {{ $propiedad->habitaciones }}</p>
                <p><strong>Baños:</strong> {{ $propiedad->banos }}</p>
                <p><strong>Dimensiones:</strong> {{ $propiedad->dimensiones }} m²</p>
                <p><strong>Estado:</strong> {{ $propiedad->estado }}</p>
                <p><strong>Cochera:</strong> {{ $propiedad->garage ? 'Sí' : 'No' }}</p>
                <button>Solicitar Información</button>
            </div>
        </section>
    </main>

    <section class="cont-1">
        <h2 class="subtitulo">Fotos de la propiedad</h2>
        <!-- Mostrar las imágenes de la propiedad -->
        @foreach($propiedad->imagenes as $imagen)
            <img src="{{ asset($imagen->imagen_url) }}" alt="Imagen de la propiedad">
        @endforeach
    </section>

    <section class="cont">
        <h2 class="subtitulo">Calculadora</h2>
        <!-- Aquí podrías implementar una calculadora de precios si lo deseas -->
    </section>

    <footer class="pie">
        <p class="grande">Creado por Honey y Sunshine</p>

        <div class="icons">
            <!-- Aquí irían los iconos de redes sociales -->
        </div>

        <section class="cont-2">
            <div class="cont"></div>
        </section>
    </footer>

</body>
</html>
