<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Propiedad</title>
    <link rel="stylesheet" href="{{ asset('css/normalize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    <div class="titulo">
        <h1>Edita tu propiedad</h1>
    </div>

    <nav class="barra">
        <a href="{{ route('index') }}">Inicio</a>
        <a href="{{ route('propiedades') }}">Propiedades</a>
        <a href="{{ route('propiedades.create') }}">Crear Propiedad</a>
        <a href="{{ route('contacto') }}">Contacto</a>
        @auth
            <a href="{{ route('perfil') }}">Perfil</a>
            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                @csrf
                <button type="submit" style="background: none; border: none; color: blue; cursor: pointer;">Cerrar sesión</button>
            </form>
        @endauth
    </nav>

    <main class="cont-edit">
        <section class="cont-1">
            <h2 class="subtitulo">Edita tu propiedad</h2>
            <form class="formulario" action="{{ route('propiedades.update', $propiedad->id) }}" method="POST">
                @csrf
                @method('PUT')

                <label>Tipo:</label>
                <select name="tipo" required>
                    @foreach(['Casa', 'Departamento', 'Local', 'Terreno'] as $tipo)
                        <option value="{{ $tipo }}" {{ $propiedad->tipo == $tipo ? 'selected' : '' }}>{{ $tipo }}</option>
                    @endforeach
                </select>

                <label>Dirección:</label>
                <input type="text" name="direccion" value="{{ $propiedad->direccion }}" required>

                <label>Referencias:</label>
                <input type="text" name="referencias" value="{{ $propiedad->referencias }}">

                <label>Descripción:</label>
                <textarea name="descripcion" required>{{ $propiedad->descripcion }}</textarea>

                <label>Precio:</label>
                <input type="number" step="0.01" name="precio" value="{{ $propiedad->precio }}" required>

                <label>Habitaciones:</label>
                <input type="number" name="habitaciones" value="{{ $propiedad->habitaciones }}">

                <label>Baños:</label>
                <input type="number" name="banos" value="{{ $propiedad->banos }}">

                <label>Dimensiones (m²):</label>
                <input type="number" step="0.1" name="dimensiones" value="{{ $propiedad->dimensiones }}" required>

                <label>Estado:</label>
                <select name="estado" required>
                    <option value="Venta" {{ $propiedad->estado == 'Venta' ? 'selected' : '' }}>Venta</option>
                    <option value="Renta" {{ $propiedad->estado == 'Renta' ? 'selected' : '' }}>Renta</option>
                </select>

                <label>¿Tiene cochera?</label>
                <select name="garage" required>
                    <option value="1" {{ $propiedad->garage ? 'selected' : '' }}>Sí</option>
                    <option value="0" {{ !$propiedad->garage ? 'selected' : '' }}>No</option>
                </select>

                <button type="submit">Guardar cambios</button>
            </form>
        </section>

        <section class="cont-2">
            <h2 class="subtitulo">Imágenes actuales</h2>
            @foreach($propiedad->imagenes as $imagen)
                <div style="margin-bottom: 1rem;">
                    <img src="{{ asset($imagen->imagen_url) }}" alt="Imagen" style="max-width: 300px;"><br>

                    <!-- Eliminar imagen -->
                    <form action="{{ route('imagenes.destroy', $imagen->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Eliminar</button>
                    </form>

                    <!-- Reemplazar imagen -->
                    <form action="{{ route('imagenes.update', $imagen->id) }}" method="POST" enctype="multipart/form-data" style="display: inline;">
                        @csrf
                        @method('PUT')
                        <input type="file" name="imagen" accept="image/*" required>
                        <button type="submit">Actualizar</button>
                    </form>
                </div>
            @endforeach
        </section>

        <section class="cont-1">
            <h2 class="subtitulo">Subir nuevas imágenes</h2>
            <form action="{{ route('imagenes.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="propiedad_id" value="{{ $propiedad->id }}">
                <input type="file" name="imagenes[]" multiple accept="image/*" required>
                <button type="submit">Subir Imágenes</button>
            </form>
        </section>
    </main>

    <footer class="pie">
        <p class="grande">Creado por Honey y Sunshine</p>
        <div class="icons"></div>
        <section class="cont-2">
            <div class="cont"></div>
        </section>
    </footer>

</body>
</html>
