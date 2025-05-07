<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalle de la Solicitud</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>

<div class="container">
    <a href="{{ route('solicitudes') }}" class="btn" style="margin-bottom: 20px;">← Regresar a solicitudes</a>

    <h1>Detalle de Solicitud</h1>

    <div class="form-group">
        <p><strong>Cliente:</strong> {{ $solicitud->cliente->nombre }}</p>
        <p><strong>Propiedad:</strong> {{ $solicitud->propiedad->direccion }}</p>
        <p><strong>Estado:</strong> {{ $solicitud->estado }}</p>
        <p><strong>Fecha de Solicitud:</strong> {{ $solicitud->fecha_solicitud }}</p>
    </div>

    @if ($solicitud->estado === 'Pendiente')
        <form action="{{ route('agente.solicitud.aceptar', $solicitud->id) }}" method="POST" style="display:inline-block;">
            @csrf
            <button type="submit" class="btn">Aceptar</button>
        </form>

        <form action="{{ route('agente.solicitud.rechazar', $solicitud->id) }}" method="POST" style="display:inline-block; margin-left:10px;">
            @csrf
            <button type="submit" class="btn btn-danger">Rechazar</button>
        </form>
    @endif
</div>

</body>
</html>
