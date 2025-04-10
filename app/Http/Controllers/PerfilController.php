<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Propiedad;
use App\Models\HistorialVista;
use App\Models\Destacado;


class PerfilController extends Controller
{
    public function show()
    {
        $usuario = auth()->user();
    
        // Obtener sus propiedades
        $misPropiedades = Propiedad::where('usuario_id', $usuario->id)->get();
    
        // Historial de vistas del usuario (con la propiedad relacionada)
        $historial = HistorialVista::where('usuario_id', auth()->id())
            ->with('propiedad')
            ->latest('visto_en')
            ->get()
            ->unique('propiedad_id')
            ->values(); 

    
        // Propiedades destacadas (también con la propiedad relacionada)
        $destacados = Destacado::where('usuario_id', $usuario->id)->with('propiedad')->get();
    
        return view('perfil', compact('usuario', 'misPropiedades', 'historial', 'destacados'));
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



}

