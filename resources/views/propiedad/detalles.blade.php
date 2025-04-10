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
        <a href="{{ route('propiedades') }}">Propiedades</a>
        <a href="{{ route('propiedades.create') }}">Crear Propiedad</a>
        <a href="{{ route('contacto') }}">Contacto</a>
        @guest
            <a href="{{ route('registro') }}">Registro</a>
            <a href="{{ route('login') }}">Login</a>
        @endguest

        @auth
            <a href="{{ route('perfil') }}">Perfil</a>
            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                @csrf
                <button type="submit" style="background: none; border: none; color: blue; cursor: pointer;">Cerrar sesión</button>
            </form>
        @endauth

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
                <p><strong>Vistas:</strong> {{ $propiedad->vistas }}</p>
                <p><strong>Destacada por:</strong> {{ $propiedad->destacadaPor()->count() }} usuarios</p>


                <a href="{{ route('contacto') }}" class="btn-contacto">Pide más información</a>
                <form action="{{ route('propiedades.destacar', $propiedad->id) }}" method="POST">
                    @csrf
                    <button type="submit">
                        @if(auth()->user() && auth()->user()->propiedadesDestacadas->contains($propiedad->id))
                            💔 Quitar de destacados
                        @else
                            ⭐ Marcar como destacado
                        @endif
                    </button>
                </form>

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
        <h2 class="subtitulo">Calculadora de Hipoteca</h2>
        <form id="hipotecaForm">
            <label for="precio">Precio de la propiedad:</label>
            <input type="number" id="precio" value="{{ $propiedad->precio }}" readonly>

            <label for="enganche">Enganche (en %):</label>
            <input type="number" id="enganche" value="20" min="0" max="100">

            <label for="interes">Tasa de interés anual (%):</label>
            <input type="number" id="interes" value="8.5" step="0.1" min="0">

            <label for="plazo">Plazo (años):</label>
            <input type="number" id="plazo" value="20" min="1" max="30">

            <button type="button" onclick="calcularHipoteca()">Calcular</button>
        </form>

        <div id="resultadoHipoteca" style="margin-top: 1rem; font-weight: bold;"></div>
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


























    <script>
        function calcularHipoteca() {
            const precio = parseFloat(document.getElementById('precio').value);
            const enganchePorcentaje = parseFloat(document.getElementById('enganche').value);
            const interesAnual = parseFloat(document.getElementById('interes').value) / 100;
            const plazoAnios = parseInt(document.getElementById('plazo').value);

            const enganche = precio * (enganchePorcentaje / 100);
            const montoPrestamo = precio - enganche;
            const interesMensual = interesAnual / 12;
            const totalPagos = plazoAnios * 12;

            const pagoMensual = montoPrestamo * interesMensual / (1 - Math.pow(1 + interesMensual, -totalPagos));

            const resultado = document.getElementById('resultadoHipoteca');
            resultado.innerHTML = isFinite(pagoMensual)
                ? `Pago mensual estimado: <strong>$${pagoMensual.toFixed(2)}</strong>`
                : `Por favor verifica los valores ingresados.`;
        }
</script>

</body>
</html>
