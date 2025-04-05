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
                $query->where('ubicacion', 'LIKE', '%' . $request->ubicacion . '%');
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
        return view('propiedad.detalles', compact('propiedad'));
    }

    // otro metodo para que muestre todas, en la vista propiedad/propiedades
    public function showAll()
    {
        $propiedades = Propiedad::with('imagenes')->get();
        return view('propiedad.listado', compact('propiedades'));
    }

 //  Mostrar propiedades con filtros y límite de 10 en vista propiedad/propiedades
 public function listado(Request $request)
    {
        $query = Propiedad::with('imagenes');

        // Aplicar filtros si existen
        if ($request->has('tipo') && $request->tipo !== null) {
            $query->where('tipo', $request->tipo);
        }

        if ($request->has('ubicacion') && $request->ubicacion !== null) {
            $query->where('ubicacion', 'LIKE', '%' . $request->ubicacion . '%');
        }

        // Cargar hasta 10 propiedades
        $propiedades = $query->take(10)->get();

        return view('propiedad.propiedades', compact('propiedades'));
    }
}