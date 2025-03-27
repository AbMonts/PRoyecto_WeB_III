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
        <a href="inicio">Inicio</a>
        <a href="registrar_propiedad">Registrar Propiedad</a>
        <a href="contacto">Contacto</a>
        <a href="registro">Registro</a>
        <a href="login">Login</a>
        <a href="perfil">Perfil</a>
    </nav>

    <main>
        <section class="cont-1">
            <h2 class="subtitulo">Buscar Propiedades</h2>
            <form class="filtros">
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