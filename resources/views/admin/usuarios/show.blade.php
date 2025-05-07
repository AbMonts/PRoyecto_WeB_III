<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar agente</title>
</head>
<body>


    <!-- En la parte superior -->
    <div style="margin-top: 20px;">
        <a href="{{ route('admin.dashboard') }}" class="btn">⬅ Volver al Dashboard</a>
    </div>

<div style="width: 50%; margin: 0 auto;">
    <h1>{{ isset($subadmin) ? 'Subadmin' : 'Agente' }} - {{ isset($subadmin) ? ($subadmin->id ? 'Editar' : 'Crear') : ($agente->id ? 'Editar' : 'Crear') }}</h1>

    <form method="POST" action="{{ isset($subadmin) 
        ? ($subadmin->id ? route('admin.subadmins.update', $subadmin->id) : route('admin.subadmins.store'))
        : ($agente->id ? route('admin.agentes.update', $agente->id) : route('admin.agentes.store')) }}">
        @csrf
        @if(isset($subadmin) && $subadmin->id || isset($agente) && $agente->id)
            @method('PUT')
        @endif

        <label for="nombre">Nombre:</label><br>
        <input type="text" name="nombre" value="{{ old('nombre', $subadmin->nombre ?? $agente->nombre ?? '') }}"><br><br>

        <label for="email">Email:</label><br>
        <input type="email" name="email" value="{{ old('email', $subadmin->email ?? $agente->email ?? '') }}"><br><br>

        <label for="telefono">Teléfono:</label><br>
        <input type="text" name="telefono" value="{{ old('telefono', $subadmin->telefono ?? $agente->telefono ?? '') }}"><br><br>

        <label for="username">Username:</label><br>
        <input type="text" name="username" value="{{ old('username', $subadmin->username ?? $agente->username ?? '') }}"><br><br>

        @if(!(isset($subadmin) && $subadmin->id) && !(isset($agente) && $agente->id))
            <label for="password">Contraseña:</label><br>
            <input type="password" name="password"><br><br>

            <label for="confirmar_password">Confirmar contraseña:</label><br>
            <input type="password" name="confirmar_password"><br><br>
        @endif


        @if(isset($agente))
            <label for="disponible">Disponible:</label>
            <input type="checkbox" name="disponible" {{ ($agente->disponible ?? true) ? 'checked' : '' }}><br><br>
        @endif

        <button type="submit">Guardar</button>
    </form>

    @if((isset($subadmin) && $subadmin->id) || (isset($agente) && $agente->id))
        <form method="POST" action="{{ isset($subadmin) 
            ? route('admin.subadmins.destroy', $subadmin->id)
            : route('admin.agentes.destroy', $agente->id) }}" style="margin-top: 20px;">
            @csrf
            @method('DELETE')
            <button type="submit" style="color: red;">Eliminar</button>
        </form>
    @endif
</div>


</body>
</html>