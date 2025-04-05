<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mensaje;

class ContactoController extends Controller
{
    public function index()
    {
        return view('contacto');
    }

    public function send(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'email' => 'required|email',
            'telefono' => 'required|digits:10',
            'mensaje' => 'required'
        ]);

        Mensaje::create($request->all());

        return redirect()->route('contacto')->with('success', 'Mensaje enviado correctamente');
    }
}
