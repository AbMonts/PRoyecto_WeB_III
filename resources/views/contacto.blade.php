<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto</title>
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="{{ asset('css/propiedad.css') }}">
</head>
<body>

    <div class="titulo">
        <h1>Contacto</h1>
    </div>
    

    <nav class="barra">
        <a href="{{ route('index') }}">Inicio</a>
        <a href="{{ route('propiedades') }}">Propiedades</a>
        <a href="{{ route('propiedades.create') }}">Registrar Propiedad</a>
        @guest
        <a href="{{ route('registro') }}">Registro</a>
        <a href="{{ route('login') }}">Login</a>
        @endguest

        @auth
            <a href="{{ route('perfil') }}">Perfil</a>
        @endauth
    </nav>

    <section class="form-cont">
        <h2 class="subtitulo">Contáctanos</h2>
        
        @if(session('success'))
            <div class="alerta-exito">
                {{ session('success') }}
            </div>
        @endif

        @php
            $mensajePredeterminado = '';
            if (isset($propiedad)) {
                $prop = App\Models\Propiedad::find($propiedad);
                if ($prop) {
                    $mensajePredeterminado = "Hola, estoy interesado en la propiedad '{$prop->tipo}' ubicada en '{$prop->direccion}'. ¿Podría darme más información?";
                }
            }
        @endphp

        <form action="{{ route('enviar.mensaje') }}" method="POST" class="formulario">
            @csrf
            <input type="text" name="nombre" placeholder="Tu nombre" required>
            <input type="email" name="email" placeholder="Tu correo" required>
            <input type="tel" name="telefono" placeholder="Tu teléfono (opcional)">
            <textarea name="mensaje" placeholder="Escribe tu mensaje aquí" required>{{ old('mensaje', $mensajePredeterminado) }}</textarea>
            <button type="submit">Enviar</button>
        </form>
    </section>


    <section class="cont-contacto">
        <h2 class="subtitulo">Información de contacto</h2>
        <p>📍 Dirección: Av. Principal #123, Ciudad</p>
        <p>📞 Teléfono: 555-123-4567</p>
        <p>✉️ Correo: info@inmobiliariaxyz.com</p>
        <p>🕒 Horario: Lunes a Viernes, 9:00 AM - 6:00 PM</p>
    </section>

    
    <section>
        <h2 class="subtitulo">Ubicación</h2>
        <iframe 
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1000..."
            width="100%" height="300" style="border:0;" allowfullscreen>
        </iframe>
    </section>

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