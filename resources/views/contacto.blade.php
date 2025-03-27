<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto</title>
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

    <div class="titulo">
        <h1>Contacto</h1>
    </div>
    

    <nav class="barra">
        <a href="inicio">Inicio</a>
        <a href="propiedades">Propiedades</a>
        <a href="registrar_propiedad">Registrar Propiedad</a>
        <a href="registro">Registro</a>
        <a href="login">Login</a>
        <a href="perfil">Perfil</a>
    </nav>

    <section class="form-cont">
        <h2 class="subtitulo">Contáctanos</h2>
        <form action="enviar_mensaje.php" method="POST" class="formulario">
            <input type="text" name="nombre" placeholder="Tu nombre" required>
            <input type="email" name="email" placeholder="Tu correo" required>
            <input type="tel" name="telefono" placeholder="Tu teléfono (opcional)">
            <textarea name="mensaje" placeholder="Escribe tu mensaje aquí" required></textarea>
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