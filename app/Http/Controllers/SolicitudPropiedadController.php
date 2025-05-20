<?php

namespace App\Http\Controllers;

use App\Models\Propiedad;
use Illuminate\Http\Request;
use App\Models\SolicitudPropiedad;
use Illuminate\Support\Facades\Auth;

class SolicitudPropiedadController extends Controller
{
    public function create()
    {
        $clienteId = Auth::id();

        $tieneSolicitudPendiente = SolicitudPropiedad::where('cliente_id', $clienteId)
            ->where('estado_solicitud', 'Pendiente')
            ->exists();

        $tienePropiedad = Propiedad::where('usuario_id', $clienteId)->exists();

        if ($tieneSolicitudPendiente || $tienePropiedad) {
            return redirect()->route('perfil')->with('error', 'Ya tienes una propiedad registrada o una solicitud pendiente. Espera la autorización del administrador.');
        }

        return view('propiedad.registrarPropiedad');
    }


    public function store(Request $request)
    {
        $request->validate([
            'tipo' => 'required|in:Casa,Departamento,Local,Terreno',
            'direccion' => 'required|max:250',
            'descripcion' => 'required|max:500',
            'precio' => 'required|numeric|min:0',
            'estado' => 'required|in:Venta,Renta',
            'dimensiones' => 'required|numeric|min:0',
            'garage' => 'required|boolean',
            'habitaciones' => 'nullable|integer|min:0',
            'banos' => 'nullable|integer|min:0',
            'referencias' => 'nullable|max:300',
        ]);

        SolicitudPropiedad::create([
            'cliente_id' => Auth::id(),
            'tipo' => $request->tipo,
            'direccion' => $request->direccion,
            'referencias' => $request->referencias,
            'descripcion' => $request->descripcion,
            'precio' => $request->precio,
            'habitaciones' => $request->habitaciones,
            'banos' => $request->banos,
            'dimensiones' => $request->dimensiones,
            'estado' => $request->estado,
            'garage' => $request->garage,
            'estado_solicitud' => 'Pendiente',
            'editable' => true
        ]);

        return redirect()->route('perfil')->with('mensaje', 'Solicitud enviada correctamente.');
    }


    public function actualizar(Request $request, $id)
    {
        $solicitud = SolicitudPropiedad::findOrFail($id);

        $request->validate([
            'tipo' => 'required|in:Casa,Departamento,Local,Terreno',
            'direccion' => 'required|max:250',
            'descripcion' => 'required|max:500',
            'precio' => 'required|numeric|min:0',
            'estado' => 'required|in:Venta,Renta',
            'dimensiones' => 'required|numeric|min:0',
            'garage' => 'required|boolean',
            'habitaciones' => 'nullable|integer|min:0',
            'banos' => 'nullable|integer|min:0',
            'estado_solicitud' => 'required|in:Aprobada,Rechazada',
            'mensaje_admin' => 'nullable|max:500'
        ]);

        $solicitud->fill($request->all());
        $solicitud->editable = false;
        $solicitud->admin_id = auth()->id();

        if ($request->estado_solicitud === 'Rechazada') {
            $solicitud->mensaje_admin = $request->mensaje_admin ?? 'Rechazada por el administrador, pongase en contacto por medio de correo para revisar su situacion';
        } elseif ($request->estado_solicitud === 'Aprobada') {
            $solicitud->mensaje_admin = $request->mensaje_admin ?? 'Solicitud aprobada exitosamente, ya se publico y puede asociarse con un agente';
        }

        $solicitud->save();


        //'''''............crear si se aprueba y si ya se creo o no ''''''''''''''''''''''''''''''''
        if ($request->estado_solicitud === 'Aprobada') {
            $solicitud->mensaje_admin = $request->mensaje_admin ?? 'Solicitud aprobada exitosamente, ya se publicó y puede asociarse con un agente';

            // Verifica si ya existe una propiedad con la misma dirección del cliente
            $propiedadExistente = Propiedad::where('direccion', $solicitud->direccion)
                ->where('usuario_id', $solicitud->cliente_id)
                ->first();

            if ($propiedadExistente) {
                // Actualizar la propiedad existente
                $propiedadExistente->update([
                    'tipo' => $solicitud->tipo,
                    'descripcion' => $solicitud->descripcion,
                    'precio' => $solicitud->precio,
                    'estado' => $solicitud->estado,
                    'dimensiones' => $solicitud->dimensiones,
                    'garage' => $solicitud->garage,
                    'habitaciones' => $solicitud->habitaciones,
                    'banos' => $solicitud->banos,
                    'referencias' => $solicitud->referencias,
                ]);
            } else {
                // Crear nueva propiedad
                Propiedad::create([
                    'usuario_id' => $solicitud->cliente_id,
                    'tipo' => $solicitud->tipo,
                    'direccion' => $solicitud->direccion,
                    'descripcion' => $solicitud->descripcion,
                    'precio' => $solicitud->precio,
                    'estado' => $solicitud->estado,
                    'dimensiones' => $solicitud->dimensiones,
                    'garage' => $solicitud->garage,
                    'habitaciones' => $solicitud->habitaciones,
                    'banos' => $solicitud->banos,
                    'referencias' => $solicitud->referencias,
                    'vistas' => 0 // inicializamos vistas si es necesario
                ]);
            }
        }

        return redirect()->route('admin.solicitudes')->with('success', 'Solicitud actualizada.');
    }

    public function detalle($id)
    {
        $solicitud = SolicitudPropiedad::where('id', $id)
                            ->where('cliente_id', auth()->id())
                            ->firstOrFail();

        return view('detalle_solicitud', compact('solicitud'));
    }


    public function editar($id)
    {
        $solicitud = SolicitudPropiedad::with('cliente')->findOrFail($id);
        return view('admin.solicitudes.editar', compact('solicitud'));
    }


}
