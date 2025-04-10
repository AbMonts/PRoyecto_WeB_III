<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi perfil</title>
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div class="titulo">
        <h1 >Perfil</h1>
    </div>

    <nav class="barra">
        <a href="{{ route('index') }}">Inicio</a>
        <a href="{{ route('propiedades') }}">Propiedades</a>
        <a href="{{ route('propiedades.create') }}">Registrar Propiedad</a>
        <a href="{{ route('contacto') }}">Contacto</a>
        <a href="{{ route('logout') }}"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Cerrar sesión
            </a>
        
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>

    </nav>
    <h1>Bienvenido {{ auth()->user()->nombre }}</h1>
        


    <main>
        <section class="cont-1">
            <h2 class="subtitulo">Mi Perfil</h2>
            <div class="perfil">
            @if (session('success'))
                <p style="color: green;">{{ session('success') }}</p>
            @endif

            <form method="POST" action="{{ route('perfil.actualizar') }}">
                @csrf
                @method('PUT')

                <p><strong>Nombre:</strong> 
                    <input type="text" name="nombre" value="{{ auth()->user()->nombre }}" required>
                </p>
                <p><strong>Correo:</strong> 
                    <input type="email" value="{{ auth()->user()->email }}" disabled>
                </p>
                <p><strong>Teléfono:</strong> 
                    <input type="text" name="telefono" value="{{ auth()->user()->telefono }}">
                </p>
                <p><strong>Usuario:</strong> 
                    <input type="text" name="username" value="{{ auth()->user()->username }}">
                </p>

                <button type="submit">Guardar Cambios</button>
            </form>

            </div>
        </section>

                <!-- Mi actividad (historial de vistas) -->
        <section class="cont-2">
            <h2 class="subtitulo">Mi Historial de Vistas</h2>
            <div class="propiedades">
                @forelse ($historial as $item)
                    <div class="propiedad">
                        <img src="{{ $item->propiedad->imagen_url ?? '../imgs/default.jpg' }}" alt="{{ $item->propiedad->tipo }}">
                        <h3>{{ $item->propiedad->tipo }}</h3>
                        <p>Precio: ${{ number_format($item->propiedad->precio) }}</p>
                        <p>Ubicación: {{ $item->propiedad->direccion }}</p>
                        <a href="{{ route('propiedades.show', $item->propiedad->id) }}">Ver más</a>
                    </div>
                @empty
                    <p>No hay historial de vistas.</p>
                @endforelse
            </div>
        </section>

        <!-- Mis propiedades -->
        <section class="cont-2">
            <h2 class="subtitulo">Mis Propiedades</h2>
            <div class="propiedades">
                @forelse ($misPropiedades as $prop)
                    <div class="propiedad">
                        <img src="{{ $prop->imagen_url ?? '../imgs/default.jpg' }}" alt="{{ $prop->tipo }}">
                        <h3>{{ $prop->tipo }}</h3>
                        <p>Precio: ${{ number_format($prop->precio) }}</p>
                        <p>Ubicación: {{ $prop->direccion }}</p>
                        <a href="{{ route('propiedades.edit', $prop->id) }}">Editar</a>
                    </div>
                @empty
                    <p>No has registrado propiedades.</p>
                @endforelse
            </div>
        </section>

        <!-- Mis propiedades destacadas -->
        <section class="cont-2">
            <h2 class="subtitulo">Propiedades Destacadas</h2>
            <div class="propiedades">
                @forelse ($destacados as $dest)
                    <div class="propiedad">
                        <img src="{{ $dest->propiedad->imagen_url ?? '../imgs/default.jpg' }}" alt="{{ $dest->propiedad->tipo }}">
                        <h3>{{ $dest->propiedad->tipo }}</h3>
                        <p>Precio: ${{ number_format($dest->propiedad->precio) }}</p>
                        <p>Ubicación: {{ $dest->propiedad->direccion }}</p>
                        <a href="{{ route('propiedades.show', $dest->propiedad->id) }}">Ver más</a>
                    </div>
                @empty
                    <p>No tienes propiedades destacadas.</p>
                @endforelse
            </div>
        </section>


    </main>

    <footer class="pie">
        <p class="grande">Creado por Honey y Sunshine</p>

        <div class="icons">
           
        </div>

            <section class="cont-2">
                <div class="cont"></div>
        </section>

    </footer>
    
</body>
</html>
