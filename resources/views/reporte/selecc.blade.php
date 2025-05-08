<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>reporte</title>
</head>
<body>

<div class="container">
    <h2 class="mb-4">Selecciona una propiedad para generar su reporte</h2>

    <div class="row">
        @foreach ($propiedades as $propiedad)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">{{ $propiedad->tipo }}</h5>
                        <p class="card-text"><strong>Dirección:</strong> {{ $propiedad->direccion }}</p>
                        <p class="card-text"><strong>Precio:</strong> ${{ number_format($propiedad->precio, 2) }}</p>
                        <a href="{{ route('reporte.mostrar', $propiedad->id) }}" class="btn btn-primary mt-2">
    Generar Reporte
</a>
@if (!app()->runningInConsole())
    <a href="{{ route('reporte.pdf', $propiedad->id) }}" class="btn btn-success">
        Descargar PDF
    </a>
@endif


                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>


</body>
</html>