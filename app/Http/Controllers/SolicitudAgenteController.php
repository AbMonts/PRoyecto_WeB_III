<?php


namespace App\Http\Controllers;

use App\Models\SolicitudClienteAgente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SolicitudAgenteController extends Controller
{   //el usuario envia solicitud de asociarse a agente
    public function enviar(Request $request)
    {
        $request->validate([
            'agente_id' => 'required|exists:usuarios,id',
            'propiedad_id' => 'required|exists:propiedades,id',
            'tipo_representacion' => 'required|in:Venta,Renta',
        ]);

        // Evitar duplicados
        $existe = SolicitudClienteAgente::where([
            ['cliente_id', Auth::id()],
            ['agente_id', $request->agente_id],
            ['propiedad_id', $request->propiedad_id],
        ])->first();

        if ($existe) {
            return back()->with('mensaje', 'Ya has enviado una solicitud a este agente para esta propiedad.');
        }

        // Guardar la solicitud
        SolicitudClienteAgente::create([
            'cliente_id' => Auth::id(),
            'agente_id' => $request->agente_id,
            'propiedad_id' => $request->propiedad_id,
            'tipo_representacion' => $request->tipo_representacion,
            'estado' => 'pendiente', // si aplica
            'aprobado_por_subadmin' => null, // si aplica
        ]);

        return back()->with('mensaje', 'Solicitud enviada correctamente.');
    }
}



