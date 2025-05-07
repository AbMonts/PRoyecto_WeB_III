<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MensajeInteraccion;

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
    
        return redirect()->back()->with('success', 'Mensaje enviado');
    }
    
}
