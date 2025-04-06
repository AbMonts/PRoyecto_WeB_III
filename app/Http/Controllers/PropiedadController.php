<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Propiedad;

class PropiedadController extends Controller
{
    public function index(Request $request)
        {
            $query = Propiedad::query();

            // Si hay filtros, aplicarlos
            if ($request->has('tipo')) {
                $query->where('tipo', $request->tipo);
            }

            if ($request->has('ubicacion')) {
                $query->where('direccion', 'LIKE', '%' . $request->ubicacion . '%');
            }
            

            // Obtener máximo 5 propiedades
            $propiedades = $query->take(5)->get();

            return view('index', compact('propiedades'));
        }


    public function create()
    {
        
        return view('propiedad.registrarPropiedad');
    }

  

    public function store(Request $request)
    {
        $request->validate([
            'tipo' => 'required',
            'direccion' => 'required',
            'descripcion' => 'required',
            'precio' => 'required|numeric',
            'estado' => 'required',
            'garage' => 'required|boolean',
            'usuario_id' => 'required|exists:usuarios,id'
        ]);

        Propiedad::create($request->all());

        return redirect()->route('propiedades')->with('success', 'Propiedad registrada correctamente');
    }

    public function show($id)
    {
        $propiedad = Propiedad::with('imagenes')->findOrFail($id);


            // Incrementar vistas
        $propiedad->increment('vistas');

        // Guardar historial si el usuario está logueado
        if (auth()->check()) {
            $usuario = auth()->user();

            // Guardar sólo si no ha visto antes hoy (opcional)
            \DB::table('historial_vistas')->insert([
                'usuario_id' => $usuario->id,
                'propiedad_id' => $propiedad->id,
                'visto_en' => now(),
            ]);
        }
        return view('propiedad.detalles', compact('propiedad'));
    }

    // otro metodo para que muestre todas, en la vista propiedad/propiedades
    public function showAll()
    {
        $propiedades = Propiedad::with('imagenes')->get();
        return view('propiedad.listado', compact('propiedades'));
    }

    public function listado(Request $request)
    {
        $query = Propiedad::with('imagenes');
    
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }
    
        if ($request->filled('ubicacion')) {
            $query->where('direccion', 'LIKE', '%' . $request->ubicacion . '%');
        }
    
        if ($request->filled('precio_min')) {
            $query->where('precio', '>=', $request->precio_min);
        }
    
        if ($request->filled('precio_max')) {
            $query->where('precio', '<=', $request->precio_max);
        }
    
        if ($request->filled('habitaciones')) {
            if ($request->habitaciones == '3') {
                $query->where('habitaciones', '>=', 3);
            } else {
                $query->where('habitaciones', $request->habitaciones);
            }
        }
    
        $propiedades = $query->take(10)->get();
    
        return view('propiedad.propiedades', compact('propiedades'));
    }
    


    public function toggleDestacado($id)
    {
        $usuario = Auth::user();
        $propiedad = Propiedad::findOrFail($id);

        if ($usuario->propiedadesDestacadas()->where('propiedad_id', $id)->exists()) {
            // Ya está destacado, eliminar
            $usuario->propiedadesDestacadas()->detach($id);
        } else {
            // Agregar a destacados
            $usuario->propiedadesDestacadas()->attach($id);
        }

        return back()->with('success', 'Destacado actualizado.');
    }
}