<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Usuario;

class AgenteAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('agente.login');
    }



    public function loginAgente(Request $request)
{
    $request->validate([
        'username' => 'required',
        'password' => 'required',
    ]);

    $credentials = [
        'username' => $request->username,
        'password' => $request->password,
        'tipo' => 'Agente'
    ];

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->route('agente.dashboard'); // Redirección correcta
    }

    return back()->withErrors([
        'username' => 'Credenciales incorrectas o no eres un agente autorizado.',
    ]);
}




    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('agente.login');
    }
}
