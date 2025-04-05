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
}
