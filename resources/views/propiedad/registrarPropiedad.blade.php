<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Propiedad</title>
    <link rel="stylesheet" href="{{ asset('css/normalize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    <div class="titulo">
        <h1>Registrar Propiedad</h1>
    </div>

    <nav class="barra">
        <a href="{{ route('index') }}">Inicio</a>
        <a href="{{ route('propiedades') }}">Propiedades</a>
        <a href="{{ route('contacto') }}">Contacto</a>
        <a href="{{ route('registro') }}">Registro</a>
        <a href="{{ route('login') }}">Login</a>
        <a href="{{ route('perfil') }}">Perfil</a>
    </nav>

    <section class="form-cont">
        <h2 class="subtitulo">Registra una Propiedad</h2>

        @if ($errors->any())
            <div>
                <strong>Errores:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form class="formulario" action="{{ route('propiedades.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div>
                <label for="tipo">Tipo:</label>
                <select name="tipo" required>
                    <option value="Venta">Venta</option>
                    <option value="Renta">Renta</option>
                </select>

                <label for="estado">Estado:</label>
                <select name="estado" required>
                    <option value="Casa">Casa</option>
                    <option value="Departamento">Departamento</option>
                    <option value="Local">Local</option>
                    <option value="Terreno">Terreno</option>
                </select>

                <label for="garage">Garage:</label>
                <input type="checkbox" name="garage" value="1">
            </div>

            <label for="imagenes">Imágenes:</label>
            <input type="file" name="imagenes[]" multiple accept="image/*">

            <input type="text" name="direccion" placeholder="Dirección" required>
            <input type="number" name="precio" placeholder="Precio" step="0.01" required>
            <input type="text" name="referencias" placeholder="Referencias">
            <input type="number" name="habitaciones" placeholder="Habitaciones">
            <input type="number" name="banos" placeholder="Baños">
            <input type="text" name="dimensiones" placeholder="Dimensiones (ej: 100m²)">
            <textarea name="descripcion" placeholder="Descripción de la propiedad" required></textarea>

            <input type="hidden" name="usuario_id" value="{{ auth()->check() ? auth()->user()->id : '' }}">

            <button type="submit">Registrar Propiedad</button>
        </form>
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
