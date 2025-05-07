<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agente</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>

<div class="navbar">
    <div><strong>Panel del Agente</strong></div>
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="btn">Cerrar sesión</button>
    </form>
</div>

<div class="container">
    <h1>Bienvenido, {{ Auth::user()->nombre }}</h1>

    <!-- Clientes Asociados -->
    <section class="section-box">
        <h2>Clientes Asociados</h2>
        @forelse ($clientesAprobados as $cliente)
            <div class="form-group" style="background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0px 0px 8px #ccc;">
                <strong>{{ $cliente->nombre }}</strong> ({{ $cliente->email }})
                <a href="{{ route('agente.verPropiedadCliente', $cliente->id) }}" class="btn">Gestionar propiedad</a>
            </div>
        @empty
            <p>No hay clientes asociados.</p>
        @endforelse
    </section>

    <!-- Solicitudes Pendientes -->
    <section class="section-box">
        <h2>Solicitudes Pendientes</h2>
        @forelse ($solicitudesPendientes as $solicitud)
            <div class="form-group" style="background: #fff; padding: 15px; border-radius: 5px; box-shadow: 0px 0px 5px #ccc;">
                <p><strong>Cliente:</strong> {{ $solicitud->cliente->nombre }}</p>
                <p><strong>Propiedad:</strong> {{ $solicitud->propiedad->direccion }}</p>
                <p><strong>Estado:</strong> {{ $solicitud->estado }}</p>
                <p><strong>Fecha de Solicitud:</strong> {{ $solicitud->fecha_solicitud }}</p>
                <a href="{{ route('agente.solicitud.detalle', $solicitud->id) }}" class="btn">Ver Detalle</a>
            </div>
        @empty
            <p>No hay solicitudes pendientes.</p>
        @endforelse
    </section>

    <!-- Historial de Ventas/Rentas -->
    <section class="section-box">
        <h2>Historial de Ventas/Rentas</h2>
        @forelse ($historialVentas as $venta)
            <div class="form-group" style="background: #fff; padding: 15px; border-radius: 5px; box-shadow: 0px 0px 5px #ccc;">
                <p><strong>Propiedad:</strong> {{ $venta->propiedad->direccion }}</p>
                <p><strong>Cliente:</strong> {{ $venta->cliente->nombre }}</p>
                <p><strong>Fecha de {{ $venta->propiedad->estado == 'Venta' ? 'Venta' : 'Renta' }}:</strong> {{ $venta->fecha_venta }}</p>
                <p><strong>Precio Final:</strong> ${{ number_format($venta->precio_final, 2) }}</p>
            </div>
        @empty
            <p>No hay historial de ventas o rentas.</p>
        @endforelse
    </section>

   <!-- Propiedades en Renta actualmente -->
<section class="section-box">
    <h2>Propiedades Rentandose</h2>
    @forelse ($propiedadesEnRenta as $propiedad)
        <div class="form-group" style="background: #fff; padding: 15px; border-radius: 5px; box-shadow: 0px 0px 5px #ccc;">
            <p><strong>Dirección:</strong> {{ $propiedad->direccion }}</p>
            <p><strong>Precio de Renta:</strong> ${{ number_format($propiedad->precio, 2) }}</p>
            <p><strong>Descripción:</strong> {{ $propiedad->descripcion }}</p>
        </div>
    @empty
        <p>No hay propiedades en renta actualmente.</p>
    @endforelse
</section>


</div>

</body>
</html>
