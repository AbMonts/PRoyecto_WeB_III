<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del cliente</title>
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
    <h1>Detalles del Cliente</h1>

    <div class="panelSection">
        <p><strong>Nombre:</strong> {{ $cliente->nombre }}</p>
        <p><strong>Email:</strong> {{ $cliente->email }}</p>
        <p><strong>Teléfono:</strong> {{ $cliente->telefono ?? 'No especificado' }}</p>
        <p><strong>Username:</strong> {{ $cliente->username }}</p>
        <p><strong>Tipo de Usuario:</strong> {{ $cliente->tipo }}</p>

        <form action="{{ route('admin.clientes.destroy', $cliente->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este cliente?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">❌ Eliminar Cliente</button>
        </form>
    </div>

    <div class="panelSection">
        <h2>Propiedades Asociadas</h2>
        @if ($propiedades->isEmpty())
            <p>Este cliente no tiene propiedades registradas.</p>
        @else
            <ul class="panelList">
                @foreach ($propiedades as $propiedad)
                    <li class="panelItem">
                        <strong>{{ $propiedad->titulo }}</strong> - {{ $propiedad->estado }} - {{ $propiedad->tipo }}
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>




</body>
</html>