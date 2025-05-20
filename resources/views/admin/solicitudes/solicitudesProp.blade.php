<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Solicitudes de Propiedades</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">

</head>
<body>

    <div class="navbarAdmin">
        <div>
            <strong>Panel de Admin</strong>
            <a href="{{ route('admin.dashboard') }}" class="btnAdmin">Inicio</a>
            <a href="{{ route('admin.reportes') }}" class="btnAdmin">📄 Reportes y propiedades</a>
        </div>
        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" style="background: transparent; border: none; color: white; cursor: pointer;">Cerrar sesión</button>
        </form>
    </div>

    <div style="width: 90%; margin: 0 auto;">
        <h1>Solicitudes de Propiedades</h1>

        @if (session('success'))
            <div class="mensajeSuccess">
                {{ session('success') }}
            </div>
        @endif

        <div class="solicitudes-container">
            <!-- Aprobadas -->
            <div class="columna">
                <h2>✅ Aprobadas</h2>
                @forelse ($solicitudes->where('estado_solicitud', 'Aprobada') as $solicitud)
                    <div class="solicitud-card">
                        <h3>{{ $solicitud->tipo }} en {{ $solicitud->estado }} - ${{ number_format($solicitud->precio, 2) }}</h3>
                        <p><strong>Cliente:</strong> {{ $solicitud->cliente->nombre ?? 'Desconocido' }}</p>
                        <p><strong>Dirección:</strong> {{ $solicitud->direccion }}</p>
                        <p><strong>Referencias:</strong> {{ $solicitud->referencias }}</p>
                        <p><strong>Descripción:</strong> {{ $solicitud->descripcion }}</p>
                        <p><strong>Habitaciones:</strong> {{ $solicitud->habitaciones }} | <strong>Baños:</strong> {{ $solicitud->banos }}</p>
                        <p><strong>Dimensiones:</strong> {{ $solicitud->dimensiones }} m²</p>
                        <p><strong>Garage:</strong> {{ $solicitud->garage ? 'Sí' : 'No' }}</p>
                        <p><strong>Estado de solicitud:</strong> <span style="color: green;">Aprobada</span></p>
                        <div style="margin-top: 10px;">
                            <a href="{{ route('admin.solicitudes.editar', $solicitud->id) }}" class="btn">✔️ Editar</a>
                        </div>
                    </div>
                @empty
                    <p>No hay solicitudes aprobadas.</p>
                @endforelse
            </div>

            <!-- Pendientes -->
            <div class="columna">
                <h2>🕒 Pendientes</h2>
                @forelse ($solicitudes->where('estado_solicitud', 'Pendiente') as $solicitud)
                    <div class="solicitud-card">
                        <h3>{{ $solicitud->tipo }} en {{ $solicitud->estado }} - ${{ number_format($solicitud->precio, 2) }}</h3>
                        <p><strong>Cliente:</strong> {{ $solicitud->cliente->nombre ?? 'Desconocido' }}</p>
                        <p><strong>Dirección:</strong> {{ $solicitud->direccion }}</p>
                        <p><strong>Referencias:</strong> {{ $solicitud->referencias }}</p>
                        <p><strong>Descripción:</strong> {{ $solicitud->descripcion }}</p>
                        <p><strong>Habitaciones:</strong> {{ $solicitud->habitaciones }} | <strong>Baños:</strong> {{ $solicitud->banos }}</p>
                        <p><strong>Dimensiones:</strong> {{ $solicitud->dimensiones }} m²</p>
                        <p><strong>Garage:</strong> {{ $solicitud->garage ? 'Sí' : 'No' }}</p>
                        <p><strong>Estado de solicitud:</strong> <span style="color: orange;">Pendiente</span></p>
                        <div style="margin-top: 10px;">
                            <a href="{{ route('admin.solicitudes.editar', $solicitud->id) }}" class="btn">✔️ Editar</a>
                        </div>
                    </div>
                @empty
                    <p>No hay solicitudes pendientes.</p>
                @endforelse
            </div>

            <!-- Rechazadas -->
            <div class="columna">
                <h2>X Rechazadas</h2>
                @forelse ($solicitudes->where('estado_solicitud', 'Rechazada') as $solicitud)
                    <div class="solicitud-card">
                        <h3>{{ $solicitud->tipo }} en {{ $solicitud->estado }} - ${{ number_format($solicitud->precio, 2) }}</h3>
                        <p><strong>Cliente:</strong> {{ $solicitud->cliente->nombre ?? 'Desconocido' }}</p>
                        <p><strong>Dirección:</strong> {{ $solicitud->direccion }}</p>
                        <p><strong>Referencias:</strong> {{ $solicitud->referencias }}</p>
                        <p><strong>Descripción:</strong> {{ $solicitud->descripcion }}</p>
                        <p><strong>Habitaciones:</strong> {{ $solicitud->habitaciones }} | <strong>Baños:</strong> {{ $solicitud->banos }}</p>
                        <p><strong>Dimensiones:</strong> {{ $solicitud->dimensiones }} m²</p>
                        <p><strong>Garage:</strong> {{ $solicitud->garage ? 'Sí' : 'No' }}</p>
                        <p><strong>Estado de solicitud:</strong> <span style="color: orange;">Pendiente</span></p>
                        <div style="margin-top: 10px;">
                            <a href="{{ route('admin.solicitudes.editar', $solicitud->id) }}" class="btn">✔️ Editar</a>
                        </div>
                    </div>
                @empty
                    <p>No hay solicitudes rechazadas.</p>
                @endforelse
            </div>
            
        </div>

    </div>

</body>
</html>
