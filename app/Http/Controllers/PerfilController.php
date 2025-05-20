<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Propiedad;
use App\Models\HistorialVista;
use App\Models\Destacado;
use App\Models\SolicitudPropiedad;
use App\Models\Usuario;

class PerfilController extends Controller
{
    public function show()
    {
        $usuario = auth()->user();
        $misSolicitudes = SolicitudPropiedad::where('cliente_id', $usuario->id)->latest()->get();
        // Obtener sus propiedades
        $misPropiedades = Propiedad::where('usuario_id', $usuario->id)->get();

        $tieneSolicitudPendiente = SolicitudPropiedad::where('cliente_id', $usuario->id)
        ->where('estado_solicitud', 'Pendiente')
        ->exists();

        $tienePropiedad = Propiedad::where('usuario_id', $usuario->id)->exists();
    
        // Historial de vistas del usuario (con la propiedad relacionada)
        $historial = HistorialVista::where('usuario_id', $usuario->id)
            ->with('propiedad')
            ->latest('visto_en')
            ->get()
            ->unique('propiedad_id')
            ->values(); 

    
        // Propiedades destacadas (también con la propiedad relacionada)
        $destacados = Destacado::where('usuario_id', $usuario->id)->with('propiedad')->get();
    
        return view('perfil', compact('usuario', 'misPropiedades', 'historial', 'destacados', 'misSolicitudes', 'tieneSolicitudPendiente', 'tienePropiedad'));
    }

    public function actualizar(Request $request)
        {
            $request->validate([
                'nombre' => 'required|string|max:255',
                'telefono' => 'nullable|string|max:20',
                'username' => 'required|string|max:255',
            ]);

            $usuario = auth()->user();

            $usuario->update([
                'nombre' => $request->nombre,
                'telefono' => $request->telefono,
                'username' => $request->username,
            ]);

            return redirect()->route('perfil')->with('success', 'Perfil actualizado correctamente.');
        }


        public function destroy($id)
    {
        $cliente = Usuario::findOrFail($id); // O Cliente::findOrFail($id)
        $cliente->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Cliente eliminado correctamente.');
    }

    public function showCliente($id)
{
    $cliente = Usuario::findOrFail($id); // O Cliente::findOrFail($id)
    $propiedades = Propiedad::where('usuario_id', $id)->get();

    return view('admin.usuarios.showClientes', compact('cliente', 'propiedades'));
}
}

