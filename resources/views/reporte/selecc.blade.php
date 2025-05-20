<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/normalize.css">
        <!-- <link rel="stylesheet" href="../css/style.css"> -->
        
    <title>reporte</title>
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
            <a href="{{ route('admin.solicitudes') }}"class="btn"> Solicitudes de Propiedades</a>

        </div>
        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" style="background: transparent; border: none; color: white; cursor: pointer;">Cerrar sesión</button>
        </form>
    </div>

<div class="">
    <h2 class="">Selecciona una propiedad para generar su reporte</h2>

    <div class="propiedad">
        @foreach ($propiedades as $propiedad)
            <div class="">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $propiedad->tipo }}</h5>
                        <p class="card-text"><strong>Dirección:</strong> {{ $propiedad->direccion }}</p>
                        <p class="card-text"><strong>Precio:</strong> ${{ number_format($propiedad->precio, 2) }}</p>
                        <a href="{{ route('reporte.mostrar', $propiedad->id) }}" class="btn">Generar Reporte</a>
                        @if (!app()->runningInConsole())
                            <a href="{{ route('reporte.pdf', $propiedad->id) }}" class="btn btn-success">
                                Descargar PDF
                            </a>
                        @endif
<a href="{{ route('admin.propiedad.editAdmin', $propiedad->id) }}" class="btn btn-warning">
    Editar Propiedad
</a>



                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>


</body>
</html>