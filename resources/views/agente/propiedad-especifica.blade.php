<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Propiedad Asociada</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
    @php
        $aprobadoPorCliente = $solicitud && $solicitud->aprobado_por_cliente;
    @endphp
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

  
    @if(session('success'))
    <div style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
        <div style="background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
            {{ session('error') }}
        </div>
    @endif

    @if(session('warning'))
        <div style="background-color: #fff3cd; color: #856404; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
            {{ session('warning') }}
        </div>
    @endif

    @if(session('mensaje'))
        <div style="background-color: #cce5ff; color: #004085; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
            {{ session('mensaje') }}
        </div>
    @endif


    <section >
        <h2>Chat con el Cliente</h2>
        <div class="chat-box">
            @foreach($mensajes as $mensaje)
                <div class="{{ $mensaje->emisor_id === auth()->id() ? 'text-right' : 'text-left' }}">
                    <strong>{{ $mensaje->emisor->nombre }}:</strong> {{ $mensaje->mensaje }} <br>
                    <small>
                        {{ $mensaje->enviado_en ? $mensaje->enviado_en->format('d/m/Y H:i') : '' }}
                    </small>

                </div>
                <hr>
            @endforeach


            <div>
                <form action="{{ route('mensajes.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="receptor_id" value="{{ $cliente->id }}">
                    <input type="hidden" name="propiedad_id" value="{{ $propiedad->id }}">
                    
                    <textarea name="mensaje" class="form-control" placeholder="Escribe tu mensaje..." required></textarea>
                    <button type="submit" class="btn btn-primary mt-2">Enviar</button>
                </form>
            </div>


        


    </section>

    @if(!$aprobadoPorCliente)
        <p style="color: red;"><strong>El cliente aún no ha aprobado la solicitud.</strong></p>
    @endif

        <!-- Formulario para vender -->
    @if($propiedad->estado === 'Venta')
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
            <button type="submit" {{ !$aprobadoPorCliente ? 'disabled' : '' }}>Registrar Venta</button>

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

            <button type="submit" class="btn" {{ !$aprobadoPorCliente ? 'disabled' : '' }}>
                Guardar Información
            </button>

        </form>

    @endif

    @if($propiedad->estado === 'Renta')
        <form action="{{ route('agente.registrarRenta', $propiedad->id) }}" method="POST" style="margin-top: 20px;">
            @csrf
            <input type="hidden" name="cliente_id" value="{{ $cliente->id }}">

            <h3>Registrar Renta</h3>

            <div>
                <label>Monto mensual (MXN):</label>
                <input type="number" name="monto_mensual" min="0" step="0.01" required {{ !$aprobadoPorCliente ? 'disabled' : '' }}>
            </div>

            <div>
                <label>Fecha de inicio:</label>
                <input type="date" name="fecha_inicio" required {{ !$aprobadoPorCliente ? 'disabled' : '' }}>
            </div>

            <div>
                <label>Fecha de fin (opcional):</label>
                <input type="date" name="fecha_fin" {{ !$aprobadoPorCliente ? 'disabled' : '' }}>
            </div>

            <button type="submit" class="btn btn-primary" {{ !$aprobadoPorCliente ? 'disabled' : '' }}>
                Registrar Renta
            </button>

            @if(!$aprobadoPorCliente)
                <p style="color: red; margin-top:10px;"><strong>El cliente aún no ha aprobado la solicitud. No puedes registrar la renta todavía.</strong></p>
            @endif
        </form>
    @endif

    @if($propiedad->estado_actual === 'Vendida')
        <p style="color: red;"><strong>Esta propiedad ya fue vendida.</strong></p>
    @elseif($propiedad->estado_actual === 'En renta')
        <p style="color: red;"><strong>Esta propiedad esta siendo rentada.</strong></p>
    @endif



</div>


</body>
</html>
