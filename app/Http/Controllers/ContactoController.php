<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mensaje;
use Illuminate\Support\Facades\Mail;
use App\Mail\MensajeContacto;

class ContactoController extends Controller
{
    public function index()
    {
        return view('contacto');
    }

    public function enviar(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'telefono' => 'nullable|string|max:15',
            'mensaje' => 'required|string|max:1000',
        ]);
    
        Mail::to('infoimbobiliariau@gmail.com')->send(new MensajeContacto($request->all()));
    
        return redirect()->back()->with('success', 'Mensaje enviado correctamente');
    }
}
