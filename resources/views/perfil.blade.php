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
        <a href="inicio">Inicio</a>
        <a href="propiedades">Propiedades</a>
        <a href="registrar_propiedad">Registrar Propiedad</a>
        <a href="contacto">Contacto</a>
        <a href="registro">Registro</a>
        <a href="login">Login</a>
       
    </nav>
    <h1>Bienvenido {{ auth()->user()->nombre }}</h1>
        <a href="{{ route('logout') }}"
        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            Cerrar sesión
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>


    <main>
        <section class="cont-1">
            <h2 class="subtitulo">Mi Perfil</h2>
            <div class="perfil">
              
                <p><strong>Nombre:</strong> <span id="nombre"></span></p>
                <p><strong>Correo:</strong> <span id="correo"></span></p>
                <p><strong>Teléfono:</strong> <span id="telefono"></span></p>
                <p><strong>Usuario:</strong> <span id="usuario"></span></p>
                <p><strong>Tipo de Usuario:</strong> <span id="tipo"></span></p>
                <button>Editar Perfil</button>
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
