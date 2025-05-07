<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Usuario;

class AdminLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login'); // crea esta vista luego
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        $usuario = Usuario::where('username', $credentials['username'])
                          ->where('tipo', 'Admin')
                          ->first();

        if ($usuario && \Hash::check($credentials['password'], $usuario->password)) {
            Auth::login($usuario);
            return redirect()->route('admin.dashboard'); // crea esta ruta y vista luego
        }

        return back()->withErrors([
            'username' => 'Credenciales inválidas o no eres un administrador.',
        ]);
    }
}
