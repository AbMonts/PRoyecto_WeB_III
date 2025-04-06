<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function registro()
    {
        return view('auth.registro');
    }

    public function login()
    {
        return view('auth.login');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('index');
    }


    

public function registrarUsuario(Request $request)
{
    $request->validate([
        'nombre' => 'required|string|max:255',
        'email' => 'required|email|unique:usuarios,email',
        'password' => 'required|min:6',
        'confirmar_password' => 'required|same:password',
        'telefono' => 'nullable|string|max:20',
    ]);

    Usuario::create([
        'tipo' => 'Cliente',
        'nombre' => $request->nombre,
        'email' => $request->email,
        'telefono' => $request->telefono,
        'username' => $request->username,
        'password' => $request->password, // <- SIN Hash::make
    ]);
    
    return redirect()->route('login')->with('success', 'Registro exitoso. Ahora puedes iniciar sesión.');
}

public function autenticar(Request $request)
{
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $usuario = Usuario::where('email', $request->email)->first();

    if (!$usuario) {
        return back()->withErrors([
            'email' => 'No se encontró ningún usuario con este correo electrónico.',
        ])->withInput();
    }

    if (!Hash::check($request->password, $usuario->password)) {
        return back()->withErrors([
            'password' => 'La contraseña es incorrecta.',
        ])->withInput();
    }

    Auth::login($usuario);
    $request->session()->regenerate();
    return redirect()->intended(route('perfil'));
}




}
