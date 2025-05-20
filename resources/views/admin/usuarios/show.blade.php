<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar agente</title>
     <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
    <div class="navbarAdmin">
        <div>
            <strong>Panel de Admin</strong>
            <a href="{{ route('admin.dashboard') }}" class="btnAdmin">Inicio</a>
            <a href="{{ route('admin.reportes') }}" class="btnAdmin">📄 Reportes y propiedades</a>
            <a href="{{ route('admin.solicitudes') }}" class="btnAdmin">Solicitudes de Propiedades</a>
        </div>
        <form action="{{ route('logout') }}" method="POST" class="logoutForm">
            @csrf
            <button type="submit" class="logoutBtn">Cerrar sesión</button>
        </form>
    </div>


   
<div class="adminContainer">
    

    <h1>{{ isset($subadmin) ? 'Subadmin' : 'Agente' }} - {{ isset($subadmin) ? ($subadmin->id ? 'Editar' : 'Crear') : ($agente->id ? 'Editar' : 'Crear') }}</h1>

    <form method="POST" action="{{ isset($subadmin) 
        ? ($subadmin->id ? route('admin.subadmins.update', $subadmin->id) : route('admin.subadmins.store'))
        : ($agente->id ? route('admin.agentes.update', $agente->id) : route('admin.agentes.store')) }}">
        @csrf
        @if((isset($subadmin) && $subadmin->id) || (isset($agente) && $agente->id))
            @method('PUT')
        @endif

        <div class="panelSection">
            <label>Nombre:</label>
            <input type="text" name="nombre" value="{{ old('nombre', $subadmin->nombre ?? $agente->nombre ?? '') }}" class="form-control">

            <label>Email:</label>
            <input type="email" name="email" value="{{ old('email', $subadmin->email ?? $agente->email ?? '') }}" class="form-control">

            <label>Teléfono:</label>
            <input type="text" name="telefono" value="{{ old('telefono', $subadmin->telefono ?? $agente->telefono ?? '') }}" class="form-control">

            <label>Username:</label>
            <input type="text" name="username" value="{{ old('username', $subadmin->username ?? $agente->username ?? '') }}" class="form-control">

            @if(!(isset($subadmin) && $subadmin->id) && !(isset($agente) && $agente->id))
                <label>Contraseña:</label>
                <input type="password" name="password" class="form-control">

                <label>Confirmar contraseña:</label>
                <input type="password" name="confirmar_password" class="form-control">
            @endif

            @if(isset($agente))
                <label>Disponible:</label>
                <input type="checkbox" name="disponible" {{ ($agente->disponible ?? true) ? 'checked' : '' }}>
            @endif

            <button type="submit" class="btn">Guardar</button>
        </div>
    </form>

    @if((isset($subadmin) && $subadmin->id) || (isset($agente) && $agente->id))
        <form method="POST" action="{{ isset($subadmin) 
            ? route('admin.subadmins.destroy', $subadmin->id)
            : route('admin.agentes.destroy', $agente->id) }}" style="margin-top: 20px;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">❌ Eliminar</button>
        </form>
    @endif

    @if(isset($agente))
        <div class="panelSection">
            <h2>Propiedades Asignadas</h2>
            @if($propiedades->count())
                <ul class="panelList">
                    @foreach($propiedades as $prop)
                        <li class="panelItem">{{ $prop->titulo }} - {{ $prop->direccion }}</li>
                    @endforeach
                </ul>
            @else
                <p>Este agente no tiene propiedades asignadas.</p>
            @endif

            <h2>Ventas Realizadas</h2>
            @if($ventas->count())
                <ul class="panelList">
                    @foreach($ventas as $venta)
                        <li class="panelItem">ID Venta: {{ $venta->id }} - Propiedad: {{ $venta->propiedad->direccion ?? 'Sin título' }}</li>
                    @endforeach
                </ul>
            @else
                <p>No hay ventas registradas por este agente.</p>
            @endif
        </div>
    @endif
</div>



</body>
</html>