<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <title>Login agentes</title>
</head>
<body>
<div class="containerloginagente">
        <h2>Login de Agente</h2>

        <form method="POST" action="{{ route('agente.login') }}" class="form-box">
            @csrf
            <label for="username">Usuario:</label>
            <input type="text" name="username" id="username" class="input-field" required>

            <label for="password">Contraseña:</label>
            <input type="password" name="password" id="password" class="input-field" required>

            <button type="submit" class="btn">Ingresar</button>
        </form>

        @if ($errors->any())
            <div class="alert alert-error">
                {{ $errors->first() }}
            </div>
        @endif
    </div>
</body>
</html>