<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>


        <h1>Perfil</h1>
  

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

        <section class="cont-2">
            <h2 class="subtitulo">Mi actividad</h2>
            <div class="propiedades">
                <div class="propiedad">
                    <img src="../imgs/casa3.jpg" alt="Casa en CDMX">
                    <h3>Casa en CDMX</h3>
                    <p>Precio: $2,500,000</p>
                    <p>Ubicación: Ciudad de México</p>
                    <a href="https://maps.app.goo.gl/gK8EUkmidGKGGDzd9">Ver más</a>
                </div>
    
                <div class="propiedad">
                    <img src="../imgs/casa1.jpg" alt="Departamento en Monterrey">
                    <h3>Departamento en Monterrey</h3>
                    <p>Precio: $1,800,000</p>
                    <p>Ubicación: Monterrey</p>
                    <a href="propiedad.html?id=2">Ver más</a>
                </div>
            </div>
        </section>

        <section class="cont-2">
            <h2 class="subtitulo">Mis Propiedades</h2>
            <div class="propiedades">
                <div class="propiedad">
                    <img src="../imgs/casa3.jpg" alt="Casa en CDMX">
                    <h3>Casa en CDMX</h3>
                    <p>Precio: $2,500,000</p>
                    <p>Ubicación: Ciudad de México</p>
                    <a href="https://maps.app.goo.gl/gK8EUkmidGKGGDzd9">Ver más</a>
                </div>
    
                <div class="propiedad">
                    <img src="../imgs/casa1.jpg" alt="Departamento en Monterrey">
                    <h3>Departamento en Monterrey</h3>
                    <p>Precio: $1,800,000</p>
                    <p>Ubicación: Monterrey</p>
                    <a href="propiedad.html?id=2">Ver más</a>
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
