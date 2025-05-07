<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Propiedad</title>
    <link rel="stylesheet" href="{{ asset('css/normalize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/propiedad.css') }}">
</head>
<body>

    <div class="titulo">
        <h1>Edita tu propiedad</h1>
    </div>

    <nav class="barra">
        <a href="{{ route('index') }}">Inicio</a>
        <a href="{{ route('propiedades') }}">Propiedades</a>
        <a href="{{ route('propiedades.create') }}">Crear Propiedad</a>
        <a href="{{ route('contacto') }}">Contacto</a>
        @auth
            <a href="{{ route('perfil') }}">Perfil</a>
            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                @csrf
                <button type="submit" style="background: none; border: none; color: blue; cursor: pointer;">Cerrar sesión</button>
            </form>
        @endauth
    </nav>

    <main class="cont-edit">
        @if (session('mensaje'))
            <div>
                {{ session('mensaje') }}
            </div>
        @endif

        @if (session('error'))
            <div>
                {{ session('error') }}
            </div>
        @endif

        <section class="cont-1">
            <h2 class="subtitulo">Administra tu propiedad</h2>
            <form class="formularioEdit" action="{{ route('propiedades.update', $propiedad->id) }}" method="POST">
                @csrf
                @method('PUT')

                <label>Tipo:</label>
                <select name="tipo" required>
                    @foreach(['Casa', 'Departamento', 'Local', 'Terreno'] as $tipo)
                        <option value="{{ $tipo }}" {{ $propiedad->tipo == $tipo ? 'selected' : '' }}>{{ $tipo }}</option>
                    @endforeach
                </select>

                <input type="hidden" name="propiedad_id" value="{{ $propiedad->id }}">

                <label>Dirección:</label>
                <input type="text" name="direccion" value="{{ $propiedad->direccion }}" required>

                <label>Referencias:</label>
                <input type="text" name="referencias" value="{{ $propiedad->referencias }}">

                <label>Descripción:</label>
                <textarea name="descripcion" required>{{ $propiedad->descripcion }}</textarea>

                <label>Precio:</label>
                <input type="number" step="0.01" name="precio" value="{{ $propiedad->precio }}" required>

                <label>Habitaciones:</label>
                <input type="number" name="habitaciones" value="{{ $propiedad->habitaciones }}">

                <label>Baños:</label>
                <input type="number" name="banos" value="{{ $propiedad->banos }}">

                <label>Dimensiones (m²):</label>
                <input type="number" step="0.1" name="dimensiones" value="{{ $propiedad->dimensiones }}" required>

                <label>Estado:</label>
                <select name="estado" required>
                    <option value="Venta" {{ $propiedad->estado == 'Venta' ? 'selected' : '' }}>Venta</option>
                    <option value="Renta" {{ $propiedad->estado == 'Renta' ? 'selected' : '' }}>Renta</option>
                </select>

                <label>¿Tiene cochera?</label>
                <select name="garage" required>
                    <option value="1" {{ $propiedad->garage ? 'selected' : '' }}>Sí</option>
                    <option value="0" {{ !$propiedad->garage ? 'selected' : '' }}>No</option>
                </select>

                <button type="submit">Guardar cambios</button>
                <!-- Botón para eliminar propiedad -->
                
            </form>

                <form action="{{ route('propiedades.destroy', $propiedad->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta propiedad? Esta acción no se puede deshacer.');" style="margin-top: 1rem;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="background-color: red; color: white; padding: 0.5rem 1rem; border: none; border-radius: 5px;">Eliminar Propiedad</button>
                </form>

        </section>

        <section class="cont-2">
            <h2 class="subtitulo">Imágenes actuales</h2>
            @foreach($propiedad->imagenes as $imagen)
                <div style="margin-bottom: 1rem;">
                    <img src="{{ asset($imagen->imagen_url) }}" alt="Imagen" style="max-width: 300px;"><br>

                    <!-- Eliminar imagen -->
                    <form action="{{ route('imagenes.destroy', $imagen->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Eliminar</button>
                    </form>

                    <!-- Reemplazar imagen -->
                    <form action="{{ route('imagenes.update', $imagen->id) }}" method="POST" enctype="multipart/form-data" style="display: inline;">
                        @csrf
                        @method('PUT')
                        <input type="file" name="imagen" accept="image/*" required>
                        <button type="submit">Actualizar</button>
                    </form>
                </div>
            @endforeach
        </section>

        <section class="cont-1">
            <h2 class="subtitulo">Subir nuevas imágenes</h2>
            <form action="{{ route('imagenes.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="propiedad_id" value="{{ $propiedad->id }}">
                <input type="file" name="imagenes[]" multiple accept="image/*" required>
                <button type="submit">Subir Imágenes</button>
            </form>
        </section>


        <section class="cont-1">
            <h2>Solicitar Representación a un Agente</h2>

            @foreach ($agentes as $agente)
                <div class="agente-card">
                    <p><strong>{{ $agente->nombre }}</strong> ({{ $agente->email }})</p>

                    @php
                        // Verificar si ya existe una solicitud para este agente y propiedad
                        $solicitud = \App\Models\SolicitudClienteAgente::where([
                            ['cliente_id', Auth::id()],
                            ['agente_id', $agente->id],
                            ['propiedad_id', $propiedad->id]
                        ])->first();
                    @endphp

                    @if ($solicitud)
                        <!-- Si la solicitud existe, muestra su estado -->
                        <p>Estado de la solicitud: {{ $solicitud->estado }}</p>
                        @if ($solicitud->estado == 'pendiente')
                            <button disabled>Ya has enviado una solicitud</button>
                        @elseif ($solicitud->estado == 'aprobada')
                            <button disabled>Solicitud aprobada</button>
                        @elseif ($solicitud->estado == 'rechazada')
                            <button disabled>Solicitud rechazada</button>
                        @endif
                    @else
                        <!-- Si no hay solicitud, permite enviar una nueva -->
                        <form action="{{ route('solicitar.agente') }}" method="POST">
                            @csrf
                            <input type="hidden" name="agente_id" value="{{ $agente->id }}">
                            <input type="hidden" name="propiedad_id" value="{{ $propiedad->id }}">

                            <!-- Campo para tipo de representación (Venta o Renta) -->
                            <label for="tipo_representacion">Tipo de representación:</label>
                            <select name="tipo_representacion" required>
                                <option value="Venta">Venta</option>
                                <option value="Renta">Renta</option>
                            </select>

                            <button type="submit">Enviar solicitud</button>
                        </form>
                    @endif
                </div>
            @endforeach
        </section>
        <section >
        <h2>Chat con el agente</h2>
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
        </div>


        </div>
        <form action="{{ route('mensajes.store') }}" method="POST">
            @csrf
            <input type="hidden" name="receptor_id" value="{{ $cliente->id }}">
            <input type="hidden" name="propiedad_id" value="{{ $propiedad->id }}">
            
            <textarea name="mensaje" class="form-control" placeholder="Escribe tu mensaje..." required></textarea>
            <button type="submit" class="btn btn-primary mt-2">Enviar</button>
        </form>

            <!-- Para aprovar la operacion por el cliente -->
            @if(!$solicitud->aprobado_por_cliente)
                <form action="{{ route('cliente.aprobarSolicitud', $solicitud->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de aprobar esta solicitud? Esto permitirá al agente registrar la venta o renta.')">
                    @csrf
                    <input type="hidden" name="mensaje" value="El cliente ha aprobado la solicitud.">
                    <button type="submit" class="btn btn-success">Aprobar Solicitud</button>
                </form>
            @else
                <p style="color: green;"><strong>Solicitud Aprobada</strong></p>
            @endif


        </section>



    </main>

    <footer class="pie">
        <p class="grande">Creado por Honey y Sunshine</p>
        <div class="icons"></div>
        <section class="cont-2">
            <div class="cont"></div>
        </section>
    </footer>

</body>
</html>
