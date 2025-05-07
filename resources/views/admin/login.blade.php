<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login Admin</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>

    <div class="navbar">
        <strong>Honey&Sunshine    ----- Login Administrador </strong>
    </div>

    <div class="containerlogin">
        <h2>Login de Administrador</h2>
        <form method="POST" action="{{ route('admin.login') }}">
            @csrf
            <div class="form-group">
                <label for="username">Usuario:</label>
                <input type="text" name="username" id="username" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" name="password" id="password" required>
            </div>
            <button type="submit">Ingresar</button>
        </form>

        @if ($errors->any())
            <div class="error">
                {{ $errors->first() }}
            </div>
        @endif
    </div>

</body>
</html>
