<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Solicitud</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>

    <!-- Navbar Admin -->
    <div class="navbarAdmin">
        <div>
            <strong>Panel de Admin</strong>
            <a href="{{ route('admin.dashboard') }}" class="btnAdmin">Inicio</a>
            <a href="{{ route('admin.reportes') }}" class="btnAdmin">📄 Reportes y propiedades</a>
            <a href="{{ route('admin.solicitudes') }}" class="btn">Solicitudes de Propiedades</a>
        </div>
        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" style="background: transparent; border: none; color: white; cursor: pointer;">Cerrar sesión</button>
        </form>
    </div>

    <!-- Contenido principal -->
    <div style="width: 80%; margin: 0 auto;">
        <h1>Revisión de Solicitud de Propiedad</h1>

        <form method="POST" action="{{ route('admin.solicitudes.actualizar', $solicitud->id) }}" style="margin-top: 20px;">
            @csrf
            @method('PUT')

            <label>Tipo:</label>
            <select name="tipo">
                @foreach (['Casa', 'Departamento', 'Local', 'Terreno'] as $tipo)
                    <option value="{{ $tipo }}" {{ $solicitud->tipo === $tipo ? 'selected' : '' }}>{{ $tipo }}</option>
                @endforeach
            </select><br>

            <label>Dirección:</label>
            <input type="text" name="direccion" value="{{ $solicitud->direccion }}"><br>

            <label>Descripción:</label>
            <textarea name="descripcion">{{ $solicitud->descripcion }}</textarea><br>

            <label>Precio:</label>
            <input type="number" step="0.01" name="precio" value="{{ $solicitud->precio }}"><br>

            <label>Estado:</label>
            <select name="estado">
                <option value="Venta" {{ $solicitud->estado === 'Venta' ? 'selected' : '' }}>Venta</option>
                <option value="Renta" {{ $solicitud->estado === 'Renta' ? 'selected' : '' }}>Renta</option>
            </select><br>

            <label>Dimensiones (m²):</label>
            <input type="number" name="dimensiones" value="{{ $solicitud->dimensiones }}"><br>

            <label>Garage:</label>
            <select name="garage">
                <option value="1" {{ $solicitud->garage ? 'selected' : '' }}>Sí</option>
                <option value="0" {{ !$solicitud->garage ? 'selected' : '' }}>No</option>
            </select><br>

            <label>Habitaciones:</label>
            <input type="number" name="habitaciones" value="{{ $solicitud->habitaciones }}"><br>

            <label>Baños:</label>
            <input type="number" name="banos" value="{{ $solicitud->banos }}"><br>

            <label>Estado de la solicitud:</label>
            <select name="estado_solicitud">
                <option value="Aprobada">Aprobar</option>
                <option value="Rechazada">Rechazar</option>
            </select><br>

            <label>Mensaje del administrador:</label>
            <textarea name="mensaje_admin">{{ $solicitud->mensaje_admin }}</textarea><br>

            <button type="submit" class="btn">Guardar Cambios y Finalizar</button>
            <a href="{{ route('admin.solicitudes') }}" class="btn btn-danger">Cancelar</a>
        </form>
    </div>

</body>
</html>
