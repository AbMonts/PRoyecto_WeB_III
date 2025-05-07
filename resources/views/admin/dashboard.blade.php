<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administrador</title>
    <style>
        .navbar {
            background-color: #333;
            color: white;
            padding: 10px;
            display: flex;
            justify-content: space-between;
        }
        .btn {
            padding: 5px 10px;
            background-color: #3490dc;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-right: 5px;
        }
        .btn-danger {
            background-color: #e3342f;
        }
    </style>
</head>
<body>

    <div class="navbar">
        <div>
            <strong>Panel de Admin</strong>
            <a href="{{ route('admin.dashboard') }}" class="btn">Inicio</a>
        </div>
        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" style="background: transparent; border: none; color: white; cursor: pointer;">Cerrar sesión</button>
        </form>
    </div>

    <div style="width: 80%; margin: 0 auto;">
        <h1>Panel de Administración</h1>

        @if (session('success'))
            <div style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-top: 20px;">
                {{ session('success') }}
            </div>
        @endif

        <!-- Subadmins -->
        <section style="margin-top: 40px;">
            <h2>Subadmins</h2>
            <a href="{{ route('admin.subadmins.create') }}" class="btn">➕ Crear Subadmin</a>
            <ul style="list-style: none; padding: 0;">
                @foreach ($subadmins as $subadmin)
                    <li style="margin: 10px 0; padding: 10px; border: 1px solid #ccc;">
                        {{ $subadmin->nombre }} ({{ $subadmin->email }})
                        <div style="float: right;">
                            <a href="{{ route('admin.subadmins.show', $subadmin->id) }}" class="btn">Editar</a>
                            <form method="POST" action="{{ route('admin.subadmins.destroy', $subadmin->id) }}" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('¿Eliminar este usuario?')">Eliminar</button>
                            </form>
                        </div>
                    </li>
                @endforeach
            </ul>
        </section>

        <!-- Agentes -->
        <section style="margin-top: 40px;">
            <h2>Agentes</h2>
            <a href="{{ route('admin.agentes.create') }}" class="btn">➕ Crear Agente</a>
            <ul style="list-style: none; padding: 0;">
                @foreach ($agentes as $agente)
                    <li style="margin: 10px 0; padding: 10px; border: 1px solid #ccc;">
                        {{ $agente->nombre }} ({{ $agente->email }})
                        <div style="float: right;">
                            <a href="{{ route('admin.agentes.show', $agente->id) }}" class="btn">Editar</a>
                            <form method="POST" action="{{ route('admin.agentes.destroy', $agente->id) }}" style="display: inline;">
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
