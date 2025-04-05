<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="titulo">
        <h1 >Inmobiliaria Uriangato</h1>
    </div>
    
    <nav class="barra">
        <a href="{{ route('propiedades') }}">Propiedades</a>
        <a href="{{ route('propiedades.create') }}">Crear Propiedad</a>
        <a href="{{ route('contacto') }}">Contacto</a>
        <a href="{{ route('registro') }}">Registro</a>
        <a href="{{ route('login') }}">Login</a>

        @auth
            <a href="{{ route('perfil') }}">Perfil</a>
        @endauth
    </nav>



    <main class="inicio-cont">

        <section class="cont-1">
            <h2 class="subtitulo">Encuentra tu hogar ideal</h2>
            <form class="filtros" action="{{ route('propiedades.showAll') }}" method="GET">
            <select name="tipo">
                    <option value="venta">Venta</option>
                    <option value="renta">Renta</option>
                </select>
                <input type="text" name="ubicacion" placeholder="Ubicación">
                <button type="submit">Buscar</button>
            </form>
        </section>

        <section class="cont-2">
    <h2 class="subtitulo">Propiedades destacadas</h2>
    <div class="propiedades">
        @foreach($propiedades as $propiedad)
            <div class="propiedad">
            <img src="{{ asset($propiedad->imagenes->first()->imagen_url ?? 'imgs/default.jpg') }}" alt="{{ $propiedad->descripcion }}">
            <h3>{{ $propiedad->descripcion }}</h3>
                <p>Precio: ${{ number_format($propiedad->precio, 2) }}</p>
                <p>Ubicación: {{ $propiedad->direccion }}</p>
                <a href="{{ route('propiedades.show', $propiedad->id) }}">Ver más</a>
                </div>
        @endforeach
    </div>
</section>


    </main>

    <footer class="pie">
        <p class="grande">Creado por Honey y Sunshine</p>

        <div class="icons">
            <a href="#"><img src="../iconos/facebook.svg" alt="Facebook"></a>
            <a href="#"><img src="../iconos/twitter.svg" alt="Twitter"></a>
            <a href="#"><img src="../iconos/instagram.svg" alt="Instagram"></a>
            <a href="#"><img src="../iconos/tik-tok.svg" alt="TikTok"></a>
            <a href="#"><img src="../iconos/youtube.svg" alt="YouTube"></a>
            <a href="#"><img src="../iconos/html5.svg" alt="HTML5"></a>
            <a href="#"><img src="../iconos/css3.svg" alt="CSS3"></a>
            <a href="#"><img src="../iconos/js.svg" alt="JavaScript"></a>
            <a href="#"><img src="../iconos/php.svg" alt="PHP"></a>
            <a href="#"><img src="../iconos/mysql.svg" alt="MySQL"></a>
            <a href="#"><img src="../iconos/visual-basic.svg" alt="Visual Basic"></a>
        </div>

            <section class="cont-2">
                <div class="cont">      
                <h3>Misión</h3> 
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Est, dolorem nulla magnam eaque libero facilis ex nostrum impedit suscipit ipsam.</p>
                        
                    <h3>Visión</h3>
                    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Officiis, quia eveniet? Recusandae voluptatem aspernatur quae molestias inventore sequi dolore placeat!</p>
                        
                    <h3>Valores</h3>
                    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Nisi vero ab repudiandae reprehenderit! Quisquam ab tempora molestias dolores iure voluptatem!</p>       
                </div>
        </section>

    </footer>

</body>
</html>