<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;
use App\Models\SolicitudPropiedad;



class AdminController extends Controller
{

public function indexSubadmins()
{
    $subadmins = Usuario::where('tipo', 'Subadmin')->get();
    return view('admin.subadmins.index', compact('subadmins'));
}


public function dashboard()
{
    $subadmins = Usuario::where('tipo', 'Subadmin')->get();
    $agentes = Usuario::where('tipo', 'Agente')->get();
    $clientes = Usuario::where('tipo', 'Cliente')->get();

    return view('admin.dashboard', compact('subadmins', 'agentes', 'clientes'));
}

public function showSubadmin($id)
{
    $subadmin = Usuario::where('tipo', 'Subadmin')->findOrFail($id);
    return view('admin.usuarios.show', compact('subadmin'));
}

public function showAgente($id)
{
    $agente = Usuario::where('tipo', 'Agente')->findOrFail($id);

    // Obtener propiedades asignadas a este agente
    $propiedades = $agente->propiedades ?? [];  // relación debe definirse en el modelo

    // Obtener ventas realizadas por este agente
    $ventas = $agente->ventas ?? [];

    return view('admin.usuarios.show', compact('agente', 'propiedades', 'ventas'));
}


public function updateSubadmin(Request $request, $id)
{
    $subadmin = Usuario::where('tipo', 'Subadmin')->findOrFail($id);

    $request->validate([
        'nombre' => 'required',
        'email' => 'required|email|unique:usuarios,email,' . $subadmin->id,
        'username' => 'nullable|unique:usuarios,username,' . $subadmin->id,
    ]);

    $subadmin->update($request->only('nombre', 'email', 'telefono', 'username'));

    return redirect()->route('admin.subadmins.show', $subadmin->id)->with('success', 'Subadmin actualizado.');
}

public function updateAgente(Request $request, $id)
{
    $agente = Usuario::where('tipo', 'Agente')->findOrFail($id);

    $request->validate([
        'nombre' => 'required',
        'email' => 'required|email|unique:usuarios,email,' . $agente->id,
        'username' => 'nullable|unique:usuarios,username,' . $agente->id,
    ]);

    $data = $request->only('nombre', 'email', 'telefono', 'username');
$data['disponible'] = $request->has('disponible');

    $agente->update($data);

    return redirect()->route('admin.agentes.show', $agente->id)->with('success', 'Agente actualizado.');
}

public function destroySubadmin($id)
{
    Usuario::where('tipo', 'Subadmin')->findOrFail($id)->delete();
    return redirect()->route('admin.dashboard')->with('success', 'Subadmin eliminado.');
}

public function destroyAgente($id)
{
    Usuario::where('tipo', 'Agente')->findOrFail($id)->delete();
    return redirect()->route('admin.dashboard')->with('success', 'Agente eliminado.');
}


public function createSubadmin()
{
    $subadmin = new Usuario(['tipo' => 'Subadmin']);
    return view('admin.usuarios.show', compact('subadmin'));
}

public function createAgente()
{
    $agente = new Usuario(['tipo' => 'Agente']);
    return view('admin.usuarios.show', compact('agente'));
}

public function storeSubadmin(Request $request)
{
    $request->validate([
        'nombre' => 'required',
        'email' => 'required|email|unique:usuarios,email',
        'username' => 'nullable|unique:usuarios,username',
        'password' => 'required|min:6',
        'confirmar_password' => 'required|same:password',
    ]);

    Usuario::create([
        'tipo' => 'Subadmin',
        'nombre' => $request->nombre,
        'email' => $request->email,
        'telefono' => $request->telefono,
        'username' => $request->username,
        'password' => $request->password, 
    ]);

    return redirect()->route('admin.dashboard')->with('success', 'Subadmin creado correctamente.');
}


public function storeAgente(Request $request)
{
    $request->validate([
        'nombre' => 'required',
        'email' => 'required|email|unique:usuarios,email',
        'username' => 'nullable|unique:usuarios,username',
        'password' => 'required|min:6',
        'confirmar_password' => 'required|same:password',
    ]);

    Usuario::create([
        'tipo' => 'Agente',
        'nombre' => $request->nombre,
        'email' => $request->email,
        'telefono' => $request->telefono,
        'username' => $request->username,
        'password' => $request->password, 

        'disponible' => $request->has('disponible'),

    ]);

    return redirect()->route('admin.dashboard')->with('success', 'Agente creado correctamente.');
}

// ----------------------------- solicitud propiedades


public function VerSolicitudProp($id)
{
    $solicitud = SolicitudPropiedad::with('cliente')->findOrFail($id);
    return view('admin.solicitudes.show', compact('solicitud'));
}


public function mostrarSolicitudes()
{
    $solicitudes = SolicitudPropiedad::with('cliente')->latest()->get();
    return view('admin.solicitudes.solicitudesProp', compact('solicitudes'));
}


public function aprobar($id)
{
    $solicitud = SolicitudPropiedad::findOrFail($id);
    $solicitud->estado_solicitud = 'Aprobada';
    $solicitud->editable = false;
    $solicitud->admin_id = auth()->id();
    $solicitud->save();

    return redirect()->route('admin.solicitudes.aprobar')->with('success', 'Solicitud aprobada.');
}


public function rechazar(Request $request, $id)
{
    $solicitud = SolicitudPropiedad::findOrFail($id);
    $solicitud->estado_solicitud = 'Rechazada';
    $solicitud->editable = false;
    $solicitud->admin_id = auth()->id();
    $solicitud->mensaje_admin = $request->mensaje_admin ?? 'Rechazada por el administrador';
    $solicitud->save();

    return redirect()->route('admin.solicitudes.index')->with('success', 'Solicitud rechazada.');
}




}