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
            ->with('cliente')
            ->get()
            ->map(function ($solicitud) {
                return $solicitud->cliente;
            });

    
        $solicitudesPendientes = SolicitudClienteAgente::where('agente_id', $agenteId)
            ->where('estado', 'Pendiente')
            ->with(['cliente', 'propiedad']) 
            ->get();
    
        $historialVentas = Venta::where('agente_id', $agenteId)
            ->with(['cliente', 'propiedad']) 
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
        

            // Obtiene las ventas
        $ventas = Venta::where('agente_id', $agenteId)
            ->with(['cliente', 'propiedad'])
            ->orderBy('fecha_venta', 'desc')
            ->get()
            ->map(function ($venta) {
                $venta->tipo = 'Venta';
                $venta->fecha = $venta->fecha_venta;
                return $venta;
            });

        // Obtiene las rentas
        $rentas = Renta::where('agente_id', $agenteId)
            ->with(['cliente', 'propiedad'])
            ->orderBy('fecha_inicio', 'desc')
            ->get()
            ->map(function ($renta) {
                $renta->tipo = 'Renta';
                $renta->fecha = $renta->fecha_inicio;
                $renta->precio_final = $renta->monto_mensual; // Para reutilizar la misma vista
                return $renta;
            });

        // datos de ventas y rentas (todos)
        $historialVentas = $ventas->merge($rentas)->sortByDesc('fecha')->values();
    
        return view('agente.dashboard', compact(
            'clientesAprobados',
            'solicitudesPendientes',
            'historialVentas',
            'propiedadesEnRenta'
        ));

        //falta mandar datos especificamente de propiedades rentandore
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
    
        // Verificar si el cliente ha aprobado la solicitud
        $solicitud = SolicitudClienteAgente::where('cliente_id', $request->cliente_id)
            ->where('agente_id', auth()->id())
            ->where('propiedad_id', $propiedad->id)
            ->where('aprobado_por_cliente', true)
            ->first();

        if (!$solicitud) {
            return back()->with('error', 'El cliente aún no ha aprobado la solicitud.');
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
    
        //ver si se autoriza para rentar
        $solicitud = SolicitudClienteAgente::where('cliente_id', $request->cliente_id)
            ->where('agente_id', auth()->id())
            ->where('propiedad_id', $propiedad->id)
            ->where('aprobado_por_cliente', true)
            ->first();

        if (!$solicitud) {
            return back()->with('error', 'El cliente aún no ha aprobado la solicitud.');
        }

       Renta::create([
            'propiedad_id' => $propiedadId,   // lo tomas del parámetro, NO del request
            'agente_id' => auth()->id(),       // es el agente autenticado
            'cliente_id' => $request->cliente_id,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'monto_mensual' => $request->monto_mensual,
        ]);



    
        // Actualizar estado de la propiedad
        $propiedad->estado_actual = 'En renta';
        $propiedad->save();
    
        return redirect()->back()->with('success', 'Renta registrada correctamente.');
    }
    
    


//el cliente interesado en comprar o alquilar
   public function guardarInfoCliente(Request $request, $propiedadId)
    {
        $request->validate([
            'cliente_id' => 'required|exists:usuarios,id',
            'rfc' => 'nullable|string|max:13',
            'ocupacion' => 'nullable|string|max:255',
            'otros' => 'nullable|string',
            'ine' => 'nullable|file|mimes:pdf,jpeg,png,jpg',
            'comprobante_ingresos' => 'nullable|file|mimes:pdf,jpeg,png,jpg',
        ]);

        $clienteId = $request->cliente_id;

        // Verificar si ya existe la información
        $info = InformacionClientePropiedad::where('cliente_id', $clienteId)
            ->where('propiedad_id', $propiedadId)
            ->first();

        // Manejo opcional de archivos (INE, comprobante de ingresos)
        $inePath = null;
        $comprobantePath = null;

        if ($request->hasFile('ine')) {
            $inePath = $request->file('ine')->store('documentos/ine');
        }

        if ($request->hasFile('comprobante_ingresos')) {
            $comprobantePath = $request->file('comprobante_ingresos')->store('documentos/comprobantes');
        }

        if ($info) {
            // Si existe, actualiza
            $info->update([
                'rfc' => $request->rfc,
                'ocupacion' => $request->ocupacion,
                'otros' => $request->otros,
                // Solo actualiza los archivos si se subieron nuevos
                'ine' => $inePath ?? $info->ine,
                'comprobante_ingresos' => $comprobantePath ?? $info->comprobante_ingresos,
            ]);
        } else {
            // Si no existe, crea
            InformacionClientePropiedad::create([
                'propiedad_id' => $propiedadId,
                'cliente_id' => $clienteId,
                'rfc' => $request->rfc,
                'ocupacion' => $request->ocupacion,
                'otros' => $request->otros,
                'ine' => $inePath,
                'comprobante_ingresos' => $comprobantePath,
            ]);
        }

        return back()->with('success', 'Información guardada correctamente.');
    }



    //a cliente asociado
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

   //-------------------------------el cliente le envia invitacion a asociarse
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
    

}
