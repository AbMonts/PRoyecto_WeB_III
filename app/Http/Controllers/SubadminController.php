<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Usuario;

class SubadminController extends Controller
{
    public function index()
    {
        $subadmins = Usuario::where('tipo', 'Subadmin')->get();
        return view('admin.subadmins.index', compact('subadmins'));
    }

    public function create() {
        return view('admin.subadmins.create');
    }
    
    public function store(Request $request) {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'email' => 'required|email|unique:usuarios,email',
            'telefono' => 'nullable|string|max:10',
            'username' => 'required|string|unique:usuarios,username',
            'password' => 'required|string|min:6|confirmed',
        ]);
    
        $validated['password'] = bcrypt($validated['password']);
        $validated['tipo'] = 'Subadmin';
    
        Usuario::create($validated);
    
        return redirect()->route('admin.subadmins.index')->with('success', 'Subadmin creado correctamente.');
    }
    

    public function show($id)
    {
        $subadmin = Usuario::with('agentes')->findOrFail($id);
        $agentesDisponibles = Usuario::where('tipo', 'Agente')->where('disponible', true)->get();

        return view('admin.subadmins.show', compact('subadmin', 'agentesDisponibles'));
    }

    public function edit($id)
    {
        $subadmin = Usuario::findOrFail($id);
        return view('admin.subadmins.edit', compact('subadmin'));
    }

    public function update(Request $request, $id)
    {
        $subadmin = Usuario::findOrFail($id);

        $request->validate([
            'nombre' => 'required',
            'email' => 'required|email|unique:usuarios,email,' . $subadmin->id,
            'username' => 'nullable|unique:usuarios,username,' . $subadmin->id
        ]);

        $subadmin->update($request->only('nombre', 'email', 'telefono', 'username'));

        return redirect()->route('subadmins.index')->with('success', 'Subadmin actualizado');
    }

    public function destroy($id)
    {
        $subadmin = Usuario::findOrFail($id);
        $subadmin->delete();

        return redirect()->route('subadmins.index')->with('success', 'Subadmin eliminado');
    }

    public function asignarAgentes(Request $request, $id)
    {
        $subadmin = Usuario::findOrFail($id);

        $request->validate([
            'agentes' => 'array',
            'agentes.*' => 'exists:usuarios,id'
        ]);

        foreach ($request->agentes as $agenteId) {
            \DB::table('subadmin_agente')->updateOrInsert([
                'subadmin_id' => $subadmin->id,
                'agente_id' => $agenteId
            ]);
        }

        return back()->with('success', 'Agentes asignados correctamente');
    }
}
