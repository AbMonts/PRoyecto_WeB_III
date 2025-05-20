<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte Inmobiliario</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }
        .header {
            background-color: #4A4A4A;
            color: #fff;
            text-align: center;
            padding: 15px;
            font-size: 25px;
            font-weight: bold;
        }
        .seccion {
            padding: 20px;
            border-bottom: 1px solid #ccc;
        }
        .gris {
            background-color: #f9f9f9;
        }
        .titulo {
            font-weight: bold;
            margin-bottom: 10px;
            font-size: 15px;
        }
        .contenido p, .contenido ul {
            margin: 3px 0;
        }
        .contenido p {
            font-size: 15px;
        }
        .contenido ul {
            padding-left: 20px;
        }
        .row {
            display: flex;
            gap: 20px;
        }
        .col {
            flex: 1;
        }
        .footer {
            background-color: #4A4A4A;
            color: white;
            text-align: center;
            padding: 10px;
            font-size: 25px;
            position: relative;
            bottom: 0;
        }
    </style>
</head>
<body>

<div class="header">
    Reporte inmobiliario - Periodo {{ now()->format('d/m/Y') }}
</div>

<div class="seccion">
    <div class="titulo">1. Información General de la Propiedad</div>
    <div class="contenido">
        <p><strong>Ubicación:</strong> {{ $propiedad->direccion }}</p>
        <p><strong>Tipo de inmueble:</strong> {{ $propiedad->tipo }}</p>
        <p><strong>Superficie:</strong> {{ $propiedad->dimensiones }} m²</p>
        <p><strong>Habitaciones:</strong> {{ $propiedad->habitaciones }}</p>
        <p><strong>Baños:</strong> {{ $propiedad->banos }}</p>
        <p><strong>Estado:</strong> {{ $propiedad->estado }}</p>
    </div>
</div>

<div class="seccion gris">
    <div class="titulo">2. Descripción del Entorno</div>
    <div class="contenido">
        <p>{{ $propiedad->descripcion }}</p>
    </div>
</div>

<div class="seccion">
    <div class="titulo">3. Datos Financieros</div>
    <div class="contenido">
        <p><strong>Precio de venta:</strong> ${{ number_format($propiedad->precio, 0) }} MXN</p>
        <p><strong>Precio por m²:</strong> ${{ number_format($propiedad->precio / max(1, $propiedad->dimensiones), 0) }} MXN</p>

        @php
            $ventas = $propiedad->ventas;
            $tiempo_promedio = $ventas->count() > 0
                ? round($ventas->avg(fn($v) => \Carbon\Carbon::parse($v->fecha_fin)->diffInDays($v->fecha_inicio)))
                : null;
        @endphp

        @if ($tiempo_promedio)
            <p><strong>Tiempo promedio en mercado:</strong> {{ $tiempo_promedio }} días</p>
        @else
            <p><strong>Tiempo promedio en mercado:</strong> No disponible (puede ser calculado manualmente)</p>
        @endif
    </div>
</div>

<div class="seccion gris">
    <div class="row">
        <div class="col">
            <div class="titulo">4. Indicadores Clave</div>
            <div class="contenido">
                <p><strong>Total de vistas:</strong> {{ $propiedad->historialVistas->count() }}</p>
                <p><strong>Personas que destacaron:</strong> {{ $propiedad->destacadaPor->count() }}</p>
                <p><strong>Veces rentada/vendida:</strong> {{ $propiedad->ventas->count() }}</p>
                <!-- Puedes agregar más indicadores si tienes más métricas -->
            </div>
        </div>
        <div class="col">
            <div class="titulo">5. Análisis de Mercado</div>
            <div class="contenido">
                @if ($ventasEnZona && $precioPromedioZona)
                    <p><strong>Ventas en zona:</strong> {{ $ventasEnZona }}</p>
                    <p><strong>Precio promedio por m² en la zona:</strong> ${{ number_format($precioPromedioZona, 0) }} MXN</p>
                @else
                    <p>Información no disponible. Puedes agregar un análisis aquí.</p>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="seccion">
    <div class="titulo">6. Acciones Realizadas (seguimiento)</div>
    <div class="contenido">
        <p><strong>Dueño actual:</strong> {{ $propiedad->usuario->nombre }}, Usuario: {{ $propiedad->usuario->username }}, Correo: {{ $propiedad->usuario->email }}</p>

        @if($solicitudAgente)
            <p><strong>Agente asignado:</strong> {{ $solicitudAgente->agente->nombre }}</p>
            <p><strong>Email del agente:</strong> {{ $solicitudAgente->agente->email }}</p>
            <p><strong>Teléfono del agente:</strong> {{ $solicitudAgente->agente->telefono ?? 'No disponible' }}</p>
        @else
            <p><strong>Agente asignado:</strong> No asignado</p>
        @endif

        <ul>
            <!-- Aquí debe ir el historial de ventas o renta de la propiedad -->
        </ul>
    </div>
</div>

<div class="footer">
    Inmobiliaria Uriangato
</div>

</body>
</html>
