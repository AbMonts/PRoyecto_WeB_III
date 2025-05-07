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
            'nombre' => 'required|string|max:100',
            'email' => 'required|email|unique:usuarios,email',
            'password' => 'required|min:6',
            'confirmar_password' => 'required|same:password',
            'telefono' => 'required|string|max:10',
        ]);
    
        Usuario::create([
            'tipo' => 'Cliente', // 🔒 Se fuerza a cliente
            'nombre' => $request->nombre,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'username' => $request->email, // puedes dejarlo igual al correo o generar uno
            'password' => $request->password
        ]);
    
        return redirect()->route('login')->with('success', 'Registro exitoso. Ahora puedes iniciar sesión.');
    }
    



// iniciar secion
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
