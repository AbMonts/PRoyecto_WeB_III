<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Propiedades</title>
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

    <div  class="titulo">
        <h1 class="titulo">Propiedades</h1>
    </div>
    

    <nav class="barra">
        <!-- Las rutas ahora usan Blade para generar las URLs correctas -->
        <a href="{{ route('index') }}">Inicio</a>
        <a href="{{ route('propiedades.create') }}">Registrar Propiedad</a>
        <a href="{{ route('contacto') }}">Contacto</a>
        @guest
        <a href="{{ route('registro') }}">Registro</a>
        <a href="{{ route('login') }}">Login</a>
        @endguest

        @auth
            <a href="{{ route('perfil') }}">Perfil</a>
        @endauth
    </nav>

    <main>
        <section class="cont-1">
            <h2 class="subtitulo">Buscar Propiedades</h2>
            <form class="filtros" method="GET" action="{{ route('propiedades') }}">
                <select name="Venta">
                    <option value="Venta">Venta</option>
                    <option value="Renta">Renta</option>
                </select>

                <input type="text" name="ubicacion" placeholder="Ubicación" value="{{ request('ubicacion') }}">
                
                <input type="number" name="precio_min" placeholder="Precio mínimo" value="{{ request('precio_min') }}">
                <input type="number" name="precio_max" placeholder="Precio máximo" value="{{ request('precio_max') }}">

                <select name="habitaciones">
                    <option value="">Habitaciones</option>
                    <option value="1">1 Habitación</option>
                    <option value="2">2 Habitaciones</option>
                    <option value="3">3+ Habitaciones</option>
                </select>

                <button type="submit">Buscar</button>
            </form>

        </section>
        
        <section class="cont-2">
        <h2 class="subtitulo">Propiedades destacadas</h2>
        <div class="propiedades">

                @if($propiedades->isEmpty())
                    <p>No hay coincidencias con los filtros seleccionados.</p>
                @else
                    @foreach($propiedades as $propiedad)
                    <div class="propiedad">
                    <img src="{{ asset($propiedad->imagenes->first()->imagen_url ?? 'imgs/default.jpg') }}" alt="{{ $propiedad->descripcion }}">
                    <h3><strong>{{ $propiedad->descripcion }}</strong></h3>
                        <p><strong>Precio:</strong> ${{ number_format($propiedad->precio, 2) }}</p>
                        <p><strong>Ubicación:</strong> {{ $propiedad->direccion }}</p>
                        <p><strong>Vistas:</strong> {{ $propiedad->vistas }}</p>
                        <p><strong>Destacada por:</strong> {{ $propiedad->total_destacados }} usuarios</p>

                        <a href="{{ route('propiedades.show', $propiedad->id) }}">Ver más</a>
                        </div>
                @endforeach
                @endif  
        </div>
    </section>
    </main>
   
    <footer class="pie">
        <p class="grande">Creado por Honey y Sunshine</p>

        <div class="icons">
            <!-- Aquí van los iconos de redes sociales si los tienes -->
        </div>

        <section class="cont-2">
            <div class="cont"></div>
        </section>

    </footer>

</body>
</html>
