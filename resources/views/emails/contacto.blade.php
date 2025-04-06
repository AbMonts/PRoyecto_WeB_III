<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Nuevo Mensaje de Contacto</title>
</head>
<body>
    <h1>Nuevo mensaje de contacto</h1>

    <p><strong>Nombre:</strong> {{ $datos['nombre'] }}</p>
    <p><strong>Email:</strong> {{ $datos['email'] }}</p>
    <p><strong>Teléfono:</strong> {{ $datos['telefono'] ?? 'No proporcionado' }}</p>
    <p><strong>Mensaje:</strong><br>{{ $datos['mensaje'] }}</p>
</body>
</html>
