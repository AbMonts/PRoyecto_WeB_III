<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MensajeInteraccion;
use App\Models\SolicitudClienteAgente;

use Illuminate\Support\Facades\Auth;

class MensajeInteraccionController extends Controller
{
    
    public function store(Request $request)
    {
        $request->validate([
            'receptor_id' => 'required|exists:usuarios,id',
            'mensaje' => 'required|string',
            'propiedad_id' => 'nullable|exists:propiedades,id',
        ]);
    
        MensajeInteraccion::create([
            'emisor_id' => Auth::id(),
            'receptor_id' => $request->receptor_id,
            'propiedad_id' => $request->propiedad_id,
            'mensaje' => $request->mensaje,
        ]);
     // Si el mensaje es una aprobación explícita, actualiza la solicitud
        if (
            $request->propiedad_id &&
            stripos($request->mensaje, 'apruebo') !== false // detecta aprobación en mensaje
        ) {
            $solicitud = SolicitudClienteAgente::where('cliente_id', Auth::id())
                ->where('agente_id', $request->receptor_id)
                ->where('propiedad_id', $request->propiedad_id)
                ->where('estado', 'Aprobado')
                ->first();

            if ($solicitud && !$solicitud->aprobado_por_cliente) {
                $solicitud->aprobado_por_cliente = true;
                // $solicitud->fecha_aprobacion_cliente = now(); // si tienes esta columna
                $solicitud->save();
            }
        }

        return redirect()->back()->with('success', 'Mensaje enviado');
    }
}
