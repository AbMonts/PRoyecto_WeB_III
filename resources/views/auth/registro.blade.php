<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

    <div  class="titulo">
        <h1 class="titulo">Registro</h1>
    </div>
    

    <nav class="barra">
        <a href="inicio">Inicio</a>
        <a href="propiedades">Propiedades</a>
        <a href="registrar_propiedad">Registrar Propiedad</a>
        <a href="contacto">Contacto</a>
        <a href="login">Login</a>
        <a href="perfil">Perfil</a>
    </nav>

    
        <section class="form-cont">
            <h2 class="subtitulo">Registro de Usuario</h2>
            <form action="" method="POST" class="formulario">
                <input type="text" name="nombre" placeholder="Nombre completo" required>
                <input type="email" name="email" placeholder="Correo electrónico" required>
                <input type="password" name="password" placeholder="Contraseña" required>
                <input type="password" name="confirmar_password" placeholder="Confirmar contraseña" required>
                <input type="tel" name="telefono" placeholder="Teléfono">
                <button type="submit">Registrarse</button>
            </form>
            <p>¿Ya tienes cuenta? <a href="login.html">Inicia sesión aquí</a></p>
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