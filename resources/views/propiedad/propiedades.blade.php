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
        <a href="{{ route('registro') }}">Registro</a>
        <a href="{{ route('login') }}">Login</a>
        <a href="{{ route('perfil') }}">Perfil</a>
    </nav>

    <main>
        <section class="cont-1">
            <h2 class="subtitulo">Buscar Propiedades</h2>
            <form class="filtros" method="GET" action="{{ route('propiedades.showAll') }}">
            <select>
                    <option>Venta</option>
                    <option>Renta</option>
                </select>
                <input type="text" placeholder="Ubicación">
                <input type="number" placeholder="Precio mínimo">
                <input type="number" placeholder="Precio máximo">
                <select>
                    <option>1 Habitación</option>
                    <option>2 Habitaciones</option>
                    <option>3+ Habitaciones</option>
                </select>
                <button>Buscar</button>
            </form>
        </section>
        
        <section class="cont-2">
            <h2 class="subtitulo">Propiedades Disponibles</h2>
            <div class="propiedades">
                @foreach($propiedades as $propiedad)
                    <div class="propiedad">
                        <!-- Muestra la primera imagen relacionada con la propiedad -->
                        <img src="{{ asset($propiedad->imagenes->first()->imagen_url ?? 'imgs/default.jpg') }}" alt="{{ $propiedad->descripcion }}">
                        <h3>{{ $propiedad->descripcion }}</h3>
                        <p>Precio: ${{ number_format($propiedad->precio, 2) }}</p>
                        <p>Ubicación: {{ $propiedad->direccion }}</p>
                        <!-- Enlace a los detalles de la propiedad -->
                        <a href="{{ route('propiedades.show', $propiedad->id) }}">Ver más</a>
                    </div>
                @endforeach
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
