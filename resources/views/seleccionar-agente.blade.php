<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agentes disponibles</title>
</head>
<body>
        @extends('layouts.app')

        @section('content')
            <h1>Selecciona un agente para tu propiedad</h1>

            <p>Propiedad: <strong>{{ $propiedad->direccion }}</strong></p>

            <form action="{{ route('solicitar.agente') }}" method="POST">
                @csrf
                <input type="hidden" name="cliente_id" value="{{ auth()->id() }}">
                <input type="hidden" name="propiedad_id" value="{{ $propiedad->id }}">

                <label for="agente_id">Selecciona un agente:</label>
                <select name="agente_id" required>
                    @foreach($agentes as $agente)
                        <option value="{{ $agente->id }}">{{ $agente->nombre }} - {{ $agente->email }}</option>
                    @endforeach
                </select>

                <br><br>
                <button type="submit" class="btn btn-primary">Enviar solicitud</button>
            </form>

            <br>
            <a href="{{ route('propiedades.edit', $propiedad->id) }}">← Volver a edición</a>
        @endsection

</body>
</html>