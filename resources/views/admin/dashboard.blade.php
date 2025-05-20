<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administrador</title>
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
        <h1>Panel de Administración</h1>

        @if (session('success'))
            <div class="mensajeSuccess">
                {{ session('success') }}
            </div>
        @endif

        <!-- Agentes -->
        <section class="panelSection">
            <h2>Agentes</h2>
            <a href="{{ route('admin.agentes.create') }}" class="btn">➕ Crear Agente</a>
            <ul class="panelList">
                @foreach ($agentes as $agente)
                    <li class="panelItem">
                        {{ $agente->nombre }} ({{ $agente->email }})
                        <div class="btnGroup">
                            <a href="{{ route('admin.agentes.show', $agente->id) }}" class="btn">Editar</a>
                            <form method="POST" action="{{ route('admin.agentes.destroy', $agente->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('¿Eliminar este usuario?')">Eliminar</button>
                            </form>
                        </div>
                    </li>
                @endforeach
            </ul>
        </section>

        <!-- Clientes -->
        <section class="panelSection">
            <h2>Clientes</h2>
            <ul class="panelList">
                @foreach ($clientes as $cliente)
                    <li class="panelItem">
                        {{ $cliente->nombre }} ({{ $cliente->email }})
                        <div class="btnGroup">
                            <a href="{{ route('admin.clientes.show', $cliente->id) }}" class="btn">Editar</a>
                            <form method="POST" action="{{ route('admin.clientes.destroy', $cliente->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('¿Eliminar este usuario?')">Eliminar</button>
                            </form>
                        </div>
                    </li>
                @endforeach
            </ul>
        </section>
    </div>

</body>
</html>
