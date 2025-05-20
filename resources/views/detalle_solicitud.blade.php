<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle de Solicitud</title>
    <link rel="stylesheet" href="{{ asset('css/normalize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/propiedad.css') }}">
</head>
<body>
    <div class="titulo">
        <h1>Detalle de Solicitud</h1>
    </div>

    <nav class="barra">
        <a href="{{ route('index') }}">Inicio</a>
        <a href="{{ route('propiedades') }}">Propiedades</a>
        <a href="{{ route('solicitud.create') }}">Registrar Propiedad</a>
        <a href="{{ route('contacto') }}">Contacto</a>
        <a href="{{ route('logout') }}"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            Cerrar sesión
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </nav>

    <main class="contPerfil">
        <section class="cont-1 perfil">
            <h2 class="subtitulo">Información de la Solicitud</h2>

            <div class="propiedad">
                <img src="{{ $solicitud->imagen_url ?? '../imgs/default.jpg' }}" alt="{{ $solicitud->tipo }}">
                <h3>{{ $solicitud->tipo }}</h3>
                <p><strong>Precio:</strong> ${{ number_format($solicitud->precio) }}</p>
                <p><strong>Dirección:</strong> {{ $solicitud->direccion }}</p>
                <p><strong>Descripción:</strong> {{ $solicitud->descripcion }}</p>
                <p><strong>Estado:</strong> 
                    @if($solicitud->estado == 'pendiente')
                        <span style="color: orange;">Pendiente</span>
                    @elseif($solicitud->estado == 'aprobada')
                        <span style="color: green;">Aprobada</span>
                    @elseif($solicitud->estado == 'rechazada')
                        <span style="color: red;">Rechazada</span>
                    @endif
                </p>

                @if ($solicitud->mensaje_admin)
                    <div class="mensaje-admin">
                        <strong>Mensaje del Administrador:</strong>
                        <p>{{ $solicitud->mensaje_admin }}</p>
                    </div>
                @endif

                <div style="margin-top: 1rem;">
                    <a href="{{ route('perfil') }}" class="btn-agregar-propiedad">Volver al perfil</a>
                </div>
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
