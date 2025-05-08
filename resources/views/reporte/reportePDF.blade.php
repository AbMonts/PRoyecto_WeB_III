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

        .contenido p{
            font-size: 15px
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
    Reporte inmobiliario - Periodo {{ now()->format('d/m/Y')}}
</div>

<div class="seccion">
    <div class="titulo">1. Información General de la Propiedad</div>
    <div class="contenido">
        <p><strong>Ubicación:</strong> {{ $propiedad->direccion }}</p>
        <p><strong>Tipo de inmueble:</strong> {{ $propiedad->tipo }}</p>
        <p><strong>Superficie:</strong> {{ $propiedad->dimensiones }} m²</p>
        <p><strong>Habitaciones:</strong> {{ $propiedad->habitaciones }}</p>
        <p><strong>Baños:</strong> {{ $propiedad->banos }}</p>
        <p><strong>Estado:</strong> {{ $propiedad->estado_actual }}</p>
    </div>
</div>

<div class="seccion gris">
    <div class="titulo">2. Descripción del Entorno</div>
    <div class="contenido">
        <ul>
            <li>Zona residencial con alta demanda</li>
            <li>Cercanía a transporte público, escuelas y centros comerciales</li>
            <li>Seguridad media-alta en el barrio</li>
            <li>Desarrollo urbano estable con proyectos futuros de mejora</li>
        </ul>
    </div>
</div>

<div class="seccion">
    <div class="titulo">3. Datos Financieros</div>
    <div class="contenido">
        <p><strong>Precio de venta:</strong> ${{ number_format($propiedad->precio, 0) }} USD</p>
        <p><strong>Precio por m²:</strong> ${{ number_format($propiedad->precio / $propiedad->dimensiones, 0) }} MXN</p>
        <p><strong>Gastos mensuales de mantenimiento:</strong> $150 USD</p>
        <p><strong>Ingresos potenciales por alquiler:</strong> $900 USD mensuales</p>
        <p><strong>Tiempo promedio en mercado:</strong> 45 días</p>
    </div>
</div>

<div class="seccion gris">
    <div class="row">
        <div class="col">
            <div class="titulo">4. Indicadores Clave</div>
            <div class="contenido">
                <p><strong>Unidades vendidas en el último trimestre en la zona:</strong> {{ $ventasEnZona }}</p>
                <p><strong>Precio medio de venta en la zona:</strong> ${{ $precioPromedioZona }} MXN/m²</p>
                <p><strong>Variación de precios interanual:</strong> +3%</p>
                <p><strong>Ratio gastos/ingresos:</strong> {{ $ratioGastosIngresos }}%</p>
            </div>
        </div>
        <div class="col">
            <div class="titulo">5. Análisis de Mercado</div>
            <div class="contenido">
                <p>El mercado local muestra una demanda estable con ligera tendencia al alza en precios.</p>
                <p>Competencia directa con propiedades similares en el rango de $140,000 a $160,000 MXN.</p>
                <p>Recomendación: mantener precio competitivo para acelerar la venta.</p>
            </div>
        </div>
    </div>
</div>

<div class="seccion">
    <div class="titulo">6. Acciones Realizadas (seguimientto)</div>
    <div class="contenido">
        <ul>
            <li>Publicación en portales inmobiliarios destacados.</li>
            <li>Realización de 5 visitas presenciales en las últimas dos semanas.</li>
            <li>Feedback recibido: buena iluminación, precio competitivo, interés en negociación.</li>
        </ul>
    </div>
</div>

<div class="footer">
    Inmobiliaria Uriangato
</div>

</body>
</html>
