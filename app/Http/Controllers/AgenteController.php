<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Propiedad;
use App\Models\Imagen;
use App\Models\SolicitudClienteAgente;
use Illuminate\Support\Facades\Auth;
use App\Models\Usuario;
use App\Models\Venta;
use App\Models\Renta;
use App\Models\InformacionClientePropiedad;
use App\Models\MensajeInteraccion;
use Illuminate\Support\Facades\Storage;



class AgenteController extends Controller
{


    public function dashboard()
    {
        $agenteId = Auth::id();
    
        $clientesAprobados = SolicitudClienteAgente::where('agente_id', $agenteId)
            ->where('estado', 'Aprobado')
            ->with('cliente') // Relación ya existe
            ->get()
            ->pluck('cliente');
    
        $solicitudesPendientes = SolicitudClienteAgente::where('agente_id', $agenteId)
            ->where('estado', 'Pendiente')
            ->with(['cliente', 'propiedad']) // Relación ya existe
            ->get();
    
        $historialVentas = Venta::where('agente_id', $agenteId)
            ->with(['cliente', 'propiedad']) // Relación ya existe
            ->orderBy('fecha_venta', 'desc')
            ->get();
    
        $propiedadesEnRenta = Propiedad::where('estado', 'Renta')
            ->whereHas('usuario', function($query) use ($agenteId) {
                $query->where('tipo', 'Cliente')
                      ->whereHas('solicitudesClienteAgente', function($q) use ($agenteId) {
                          $q->where('agente_id', $agenteId)
                            ->where('estado', 'Aprobado');
                      });
            })
            ->get();

            $propiedadesEnRenta = Venta::with('propiedad')
            ->whereHas('propiedad', function ($query) {
                $query->where('estado', 'Renta');
            })
            ->where('agente_id', $agenteId)
            ->get()
            ->pluck('propiedad');
        

    
        return view('agente.dashboard', compact(
            'clientesAprobados',
            'solicitudesPendientes',
            'historialVentas',
            'propiedadesEnRenta'
        ));
    }
    
    
    

    
    //el cliente le envia invitacion a asociarse
    public function enviarSolicitud(Request $request)
    {
        $request->validate([
            'agente_id' => 'required|exists:usuarios,id',
            'propiedad_id' => 'required|exists:propiedades,id',
        ]);

        $cliente_id = Auth::id();

        // Verifica si ya existe una solicitud igual pendiente
        $existe = SolicitudClienteAgente::where('cliente_id', $cliente_id)
            ->where('agente_id', $request->agente_id)
            ->where('propiedad_id', $request->propiedad_id)
            ->where('estado', 'Pendiente')
            ->exists();

        if ($existe) {
            return back()->with('warning', 'Ya has enviado una solicitud para esta propiedad.');
        }

        SolicitudClienteAgente::create([
            'cliente_id' => $cliente_id,
            'agente_id' => $request->agente_id,
            'propiedad_id' => $request->propiedad_id,
            'estado' => 'Pendiente',
        ]);

        return back()->with('success', 'Solicitud enviada correctamente.');
    }



    public function verSolicitudes()
    {
        return redirect()->route('agente.dashboard');
    }

    public function verDetalleSolicitud($id)
    {
        $solicitud = SolicitudClienteAgente::with(['cliente', 'propiedad'])->findOrFail($id);

        // Opcional: validar que el agente que accede sea el dueño de la solicitud
        if ($solicitud->agente_id !== auth()->id()) {
            abort(403, 'No tienes permiso para ver esta solicitud.');
        }

        return view('agente.detalle-solicitud', compact('solicitud'));
    }


    public function verPropiedadCliente($clienteId)
    {
        $agenteId = auth()->id();

        // Buscar la solicitud aprobada entre el agente y el cliente
        $solicitud = SolicitudClienteAgente::where('cliente_id', $clienteId)
            ->where('agente_id', $agenteId)
            ->where('estado', 'Aprobado')
            ->firstOrFail();

        // Obtener la propiedad asociada a esa solicitud
        $propiedad = Propiedad::findOrFail($solicitud->propiedad_id);

        // Obtener el cliente
        $cliente = Usuario::findOrFail($clienteId); // Asumo que tu modelo de usuarios se llama Usuario

        $mensajes = MensajeInteraccion::where('propiedad_id', $propiedad->id)
            ->with(['emisor', 'receptor']) // Cargar relaciones para mostrar nombres, etc.
            ->orderBy('enviado_en', 'asc') // Ordenar por el campo correcto
            ->get();


        return view('agente.propiedad-especifica', compact('propiedad', 'solicitud', 'cliente', 'mensajes'));
    }



    // Aceptar solicitud
    public function aceptarSolicitud($id)
    {
        $solicitud = SolicitudClienteAgente::findOrFail($id);

        if ($solicitud->agente_id !== auth()->id()) {
            abort(403, 'No tienes permiso para aceptar esta solicitud.');
        }

        $solicitud->estado = 'Aprobado';
        $solicitud->save();

        return redirect()->back()->with('success', 'Solicitud aceptada exitosamente.');
    }

    // Rechazar solicitud
    public function rechazarSolicitud($id)
    {
        $solicitud = SolicitudClienteAgente::findOrFail($id);

        if ($solicitud->agente_id !== auth()->id()) {
            abort(403, 'No tienes permiso para rechazar esta solicitud.');
        }

        $solicitud->estado = 'Rechazado';
        $solicitud->save();

        return redirect()->back()->with('success', 'Solicitud rechazada exitosamente.');
    }





    // Método para cancelar una asociación
    public function cancelarAsociacion($solicitud_id)
    {
        $solicitud = SolicitudClienteAgente::findOrFail($solicitud_id);

        // Puedes validar aquí que sea el agente correcto
        if ($solicitud->agente_id != auth()->id()) {
            abort(403, 'No tienes permiso para cancelar esta asociación.');
        }

        $solicitud->delete(); // o puedes actualizar el estado en vez de eliminarlo

        return redirect()->route('agente.dashboard')
            ->with('success', 'Asociación cancelada correctamente.');
    }

    // Método para registrar una venta
    public function registrarVenta(Request $request, $propiedadId)
    {
        $request->validate([
            'cliente_id' => 'required|exists:usuarios,id',
            'precio_final' => 'required|numeric|min:0',
        ]);
    
        $propiedad = Propiedad::findOrFail($propiedadId);
    
        if ($propiedad->estado_actual !== 'Disponible') {
            return back()->with('error', 'La propiedad no está disponible para la venta.');
        }
    
        Venta::create([
            'propiedad_id' => $propiedad->id,
            'agente_id' => auth()->id(),
            'cliente_id' => $request->cliente_id,
            'precio_final' => $request->precio_final,
        ]);
    
        // Actualizar estado de la propiedad
        $propiedad->estado_actual = 'Vendida';
        $propiedad->save();
    
        return redirect()->back()->with('success', 'Venta registrada correctamente.');
    }
    

    public function registrarRenta(Request $request, $propiedadId)
    {
        $request->validate([
            'cliente_id' => 'required|exists:usuarios,id',
            'monto_mensual' => 'required|numeric|min:0',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
        ]);
    
        $propiedad = Propiedad::findOrFail($propiedadId);
    
        if ($propiedad->estado_actual !== 'Disponible') {
            return back()->with('error', 'La propiedad no está disponible para renta.');
        }
    
        Renta::create([
            'propiedad_id' => $propiedad->id,
            'agente_id' => auth()->id(),
            'cliente_id' => $request->cliente_id,
            'monto_mensual' => $request->monto_mensual,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
        ]);
    
        // Actualizar estado de la propiedad
        $propiedad->estado_actual = 'En renta';
        $propiedad->save();
    
        return redirect()->back()->with('success', 'Renta registrada correctamente.');
    }
    
    

public function guardarInfoCliente(Request $request, $propiedadId)
{
    $request->validate([
        'cliente_id' => 'required|exists:usuarios,id',
        'ine' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        'comprobante_ingresos' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        'rfc' => 'nullable|string|max:13',
        'ocupacion' => 'nullable|string|max:100',
        'otros' => 'nullable|string',
    ]);

    $ine_url = null;
    $comprobante_url = null;

    if ($request->hasFile('ine')) {
        $ine_url = $request->file('ine')->store('documentos/ine', 'public');
    }

    if ($request->hasFile('comprobante_ingresos')) {
        $comprobante_url = $request->file('comprobante_ingresos')->store('documentos/comprobantes', 'public');
    }

    InformacionClientePropiedad::updateOrCreate(
        [
            'cliente_id' => $request->cliente_id,
            'propiedad_id' => $propiedadId,
        ],
        [
            'ine_url' => $ine_url,
            'comprobante_ingresos_url' => $comprobante_url,
            'rfc' => $request->rfc,
            'ocupacion' => $request->ocupacion,
            'otros' => $request->otros,
        ]
    );

    return redirect()->back()->with('success', 'Información adicional guardada correctamente.');
}

    // Agente crea una propuesta
    public function crearPropuesta(Request $request, $propiedadId)
    {
        $request->validate([
            'cliente_id' => 'required|exists:usuarios,id',
            'tipo_movimiento' => 'required|in:Venta,Renta',
            'precio_sugerido' => 'required|numeric|min:0',
            'descripcion' => 'nullable|string',
        ]);

        $propuesta = PropuestaAgente::create([
            'propiedad_id' => $propiedadId,
            'agente_id' => Auth::id(),
            'cliente_id' => $request->cliente_id,
            'tipo_movimiento' => $request->tipo_movimiento,
            'precio_sugerido' => $request->precio_sugerido,
            'descripcion' => $request->descripcion,
        ]);

        return back()->with('success', 'Propuesta enviada al cliente.');
    }

    public function enviarMensaje(Request $request)
{
    $request->validate([
        'propiedad_id' => 'required|exists:propiedades,id',
        'contenido' => 'required|string|max:1000',
    ]);

    MensajeInteraccion::create([
        'emisor_id' => Auth::id(),
        'propiedad_id' => $request->propiedad_id,
        'contenido' => $request->contenido,
    ]);

    return back()->with('mensaje', 'Mensaje enviado');
}

    

}
