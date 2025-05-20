<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Propiedad</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
    <div class="navbarAdmin">
        <div>
            <strong>Panel de Admin</strong>
            <a href="{{ route('admin.dashboard') }}" class="btnAdmin">Inicio</a>
            <a href="{{ route('admin.reportes') }}" class="btnAdmin">📄 Reportes y propiedades</a>
            <a href="{{ route('admin.solicitudes') }}" class="btn">Solicitudes de Propiedades</a>
        </div>
        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" style="background: transparent; border: none; color: white;">Cerrar sesión</button>
        </form>
    </div>

    <div style="width: 80%; margin: 20px auto;">
        <h2>Editar Propiedad</h2>
         @if (session('success'))
            <div class= "mensajeSuccess">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.propiedad.updateAdmin', $propiedad->id) }}" method="POST" enctype="multipart/form-data" class="formContainer">
            @csrf
            @method('PUT')

            <label>Tipo:</label>
            <select name="tipo" required>
                @foreach (['Casa', 'Departamento', 'Local', 'Terreno'] as $tipo)
                    <option value="{{ $tipo }}" {{ $propiedad->tipo == $tipo ? 'selected' : '' }}>{{ $tipo }}</option>
                @endforeach
            </select>

            <label>Dirección:</label>
            <input type="text" name="direccion" value="{{ $propiedad->direccion }}" required>

            <label>Referencias:</label>
            <input type="text" name="referencias" value="{{ $propiedad->referencias }}">

            <label>Descripción:</label>
            <textarea name="descripcion" required>{{ $propiedad->descripcion }}</textarea>

            <label>Precio:</label>
            <input type="number" name="precio" step="0.01" value="{{ $propiedad->precio }}" required>

            <label>Habitaciones:</label>
            <input type="number" name="habitaciones" value="{{ $propiedad->habitaciones }}">

            <label>Baños:</label>
            <input type="number" name="banos" value="{{ $propiedad->banos }}">

            <label>Dimensiones (m²):</label>
            <input type="number" name="dimensiones" step="0.01" value="{{ $propiedad->dimensiones }}" required>

            <label>Tipo de operación:</label>
            <select name="estado" required>
                <option value="Venta" {{ $propiedad->estado == 'Venta' ? 'selected' : '' }}>Venta</option>
                <option value="Renta" {{ $propiedad->estado == 'Renta' ? 'selected' : '' }}>Renta</option>
            </select>

            <label>Estado actual:</label>
            <select name="estado_actual">
                <option value="Disponible" {{ $propiedad->estado_actual == 'Disponible' ? 'selected' : '' }}>Disponible</option>
                <option value="Vendida" {{ $propiedad->estado_actual == 'Vendida' ? 'selected' : '' }}>Vendida</option>
                <option value="En renta" {{ $propiedad->estado_actual == 'En renta' ? 'selected' : '' }}>En renta</option>
            </select>

            <label>Garage:</label>
            <select name="garage">
                <option value="1" {{ $propiedad->garage ? 'selected' : '' }}>Sí</option>
                <option value="0" {{ !$propiedad->garage ? 'selected' : '' }}>No</option>
            </select>

            <p>Publicado por: {{ $propiedad->usuario->nombre }} ({{ $propiedad->usuario->email }})</p>

            <label>Agente asignado:</label>
            <select name="agente_id">
                <option value="">Sin asignar</option>
                @foreach ($agentes as $agente)
                    <option value="{{ $agente->id }}" {{ $propiedad->agente_id == $agente->id ? 'selected' : '' }}>
                        {{ $agente->nombre }} (ID: {{ $agente->id }})
                    </option>
                @endforeach
            </select>

            <label>Documentos:</label>
            <input type="file" name="documentos">
            @if ($propiedad->documentos)
                <p>Documento actual: <a href="{{ asset('storage/' . $propiedad->documentos) }}" target="_blank">Ver documento</a></p>
            @endif

            <button type="submit" class="btn btn-primary">Guardar cambios</button>
        </form>

        <!-- Información de Venta o Renta -->
        @if ($ventas)
            <h3>Ventas</h3>
            @forelse ($ventas as $venta)
                <p>Vendido a: {{ $venta->comprador_nombre }} el {{ $venta->fecha_venta }}</p>
            @empty
                <p>No hay registros de venta.</p>
            @endforelse
        @endif

        @if ($rentas)
            <h3>Rentas</h3>
            @forelse ($rentas as $renta)
                <p>Rentado a: {{ $renta->arrendatario_nombre }} desde {{ $renta->fecha_inicio }} hasta {{ $renta->fecha_fin }}</p>
            @empty
                <p>No hay registros de renta.</p>
            @endforelse
        @endif

        <!-- Solicitudes asociadas a esta propiedad -->
        @if ($propiedad->solicitudes && $propiedad->solicitudes->count())
            <h3>Solicitudes de Asociación</h3>
            <ul>
                @foreach ($propiedad->solicitudes as $solicitud)
                    <li>
                        Cliente: {{ $solicitud->cliente->nombre }} ({{ $solicitud->cliente->email }})<br>
                        Agente: {{ $solicitud->agente->nombre }}<br>
                        Representación: {{ $solicitud->tipo_representacion }}<br>
                        Estado: {{ $solicitud->estado }}<br>
                        Aprobado por subadmin: {{ $solicitud->aprobado_por_subadmin ? 'Sí' : 'No' }}<br>
                    </li>
                @endforeach
            </ul>
        @else
            <p>No hay solicitudes para esta propiedad.</p>
        @endif

        <!-- Eliminar propiedad -->
        <form action="{{ route('admin.propiedad.destroy', $propiedad->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar esta propiedad?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Eliminar Propiedad</button>
        </form>
    </div>
</body>
</html>
