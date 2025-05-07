<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Propiedad Asociada</title>
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
<a href="{{ route('agente.dashboard') }}" class="btn" style="margin-top: 20px;">← Volver al panel</a>

<div class="container">
    <h1>Propiedad Asociada</h1>

    <div class="form-group" style="background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0px 0px 8px #ccc;">
        <h2>{{ $propiedad->tipo }} en {{ $propiedad->direccion }}</h2>
        <p><strong>Precio:</strong> ${{ number_format($propiedad->precio, 2) }}</p>
        <p><strong>Descripción:</strong> {{ $propiedad->descripcion }}</p>
        <p><strong>Habitaciones:</strong> {{ $propiedad->habitaciones }}</p>
        <p><strong>Baños:</strong> {{ $propiedad->banos }}</p>
        <p><strong>Dimensiones:</strong> {{ $propiedad->dimensiones }} m²</p>
        <p><strong>Garage:</strong> {{ $propiedad->garage ? 'Sí' : 'No' }}</p>
        <p><strong>Estado:</strong> {{ $propiedad->estado }}</p>
    </div>

</div>

<div class="form-group" style="background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0px 0px 8px #ccc;">

    <!-- Botón de cancelar asociación -->
    @if($solicitud)
        <form action="{{ route('agente.cancelarAsociacion', $solicitud->id) }}" method="POST" onsubmit="return confirm('¿Seguro que quieres cancelar la asociación?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Cancelar Asociación</button>
        </form>
    @endif

    <section class="chat-box">
        <h2>Chat con el agente</h2>
        <div class="chat-messages">
        @foreach($mensajes as $mensaje)
            <div>
                <strong>{{ $mensaje->emisor->nombre }}:</strong> {{-- Mostrar nombre del emisor --}}
                <p>{{ $mensaje->mensaje }}</p>
                <small>{{ $mensaje->enviado_en->format('d/m/Y H:i') }}</small>
            </div>
        @endforeach

        </div>

        <form action="{{ route('agente.enviarMensaje') }}" method="POST">
            @csrf
            <input type="hidden" name="propiedad_id" value="{{ $propiedad->id }}">
            <textarea name="contenido" required></textarea>
            <button type="submit">Enviar mensaje</button>
        </form>

    </section>


        <!-- Formulario para vender o rentar -->
        @if($propiedad->estado === 'Disponible')
        <!-- Formulario para vender -->
        <form action="{{ route('agente.registrarVenta', $propiedad->id) }}" method="POST" style="margin-top: 20px;">
            @csrf
            <div>
                <label>Cliente:</label>
                <select name="cliente_id" required>
                    <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
                </select>
            </div>
            <div>
                <label>Precio Final:</label>
                <input type="number" name="precio_final" min="0" step="0.01" required>
            </div>
            <button type="submit" class="btn">Registrar Venta</button>
        </form>

    @elseif($propiedad->estado === 'Renta')
        <!-- Formulario para registrar renta -->
        <form action="{{ route('agente.guardarInfoCliente', $propiedad->id) }}" method="POST" enctype="multipart/form-data" style="margin-top: 20px;">
            @csrf
            <input type="hidden" name="cliente_id" value="{{ $cliente->id }}">
            
            <h3>Información adicional del cliente</h3>

            <div>
                <label>INE (PDF o Imagen):</label>
                <input type="file" name="ine" accept="application/pdf,image/*">
            </div>
            <div>
                <label>Comprobante de Ingresos (PDF o Imagen):</label>
                <input type="file" name="comprobante_ingresos" accept="application/pdf,image/*">
            </div>
            <div>
                <label>RFC:</label>
                <input type="text" name="rfc" maxlength="13">
            </div>
            <div>
                <label>Ocupación:</label>
                <input type="text" name="ocupacion">
            </div>
            <div>
                <label>Otros (opcional):</label>
                <textarea name="otros"></textarea>
            </div>

            <button type="submit" class="btn">Guardar Información</button>
        </form>


    @elseif($propiedad->estado === 'Vendida')
        <p style="color: red;"><strong>Esta propiedad ya fue vendida.</strong></p>
    @endif



</div>


</body>
</html>
