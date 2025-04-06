<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PerfilController extends Controller
{
    public function show()
    {
        $usuario = Auth::user();
        return view('perfil', compact('usuario'));
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

