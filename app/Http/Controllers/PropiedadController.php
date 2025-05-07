<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Propiedad;
use Illuminate\Support\Facades\Storage;
use App\Models\Imagen;
use Illuminate\Support\Facades\Auth;
use App\Models\Usuario;
use App\Models\SolicitudClienteAgente;



class PropiedadController extends Controller
{
    
    public function index(Request $request)//busca en index y muestra resultados en index
    {
        $query = Propiedad::query();
    
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }
    
        if ($request->filled('ubicacion')) {
            $query->where('direccion', 'LIKE', '%' . $request->ubicacion . '%');
        }
    
        $propiedades = $query->take(5)->get();
    
        return view('index', compact('propiedades'));
    }
    


    public function edit($id)
    {
        $propiedad = Propiedad::findOrFail($id);
    
        $agentes = Usuario::where('tipo', 'Agente')->where('disponible', true)->get();

        // Verifica que la propiedad sea del usuario autenticado
        if ($propiedad->usuario_id !== auth()->id()) {
            abort(403, 'No tienes permiso para editar esta propiedad.');
        }
    
        // Buscar si ya hay una solicitud activa del cliente actual para esta propiedad
        $clienteId = auth()->id();
    
        $tieneSolicitudActiva = SolicitudClienteAgente::where('cliente_id', $clienteId)
            ->where('propiedad_id', $id)
            ->where('estado', 'pendiente') // o 'activo', según tu lógica
            ->exists();
    
         // Obtener mensajes relacionados con la propiedad
        $mensajes = \App\Models\MensajeInteraccion::where('propiedad_id', $id)
        ->where(function ($query) {
            $query->where('emisor_id', auth()->id())
                ->orWhere('receptor_id', auth()->id());
        })
        ->orderBy('enviado_en', 'asc')
        ->get();

        return view('propiedad.edit', compact('propiedad', 'agentes', 'mensajes'));
}
    


    public function create()
    {
        
        return view('propiedad.registrarPropiedad');
    }


    public function update(Request $request, $id)
    {
        $propiedad = Propiedad::findOrFail($id);

        if ($propiedad->usuario_id !== auth()->id()) {
            abort(403, 'No puedes editar esta propiedad.');
        }

        $data = $request->validate([
            'tipo' => 'required',
            'direccion' => 'required',
            'referencias' => 'nullable',
            'descripcion' => 'required',
            'precio' => 'required|numeric',
            'habitaciones' => 'nullable|integer',
            'banos' => 'nullable|integer',
            'dimensiones' => 'required|numeric',
            'estado' => 'required',
            'garage' => 'required|boolean',
            'imagenes' => 'nullable|array',
            'imagenes.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $propiedad->update($data);

        // Agregar nuevas imágenes si existen
        if ($request->hasFile('imagenes')) {
            foreach ($request->file('imagenes') as $imagen) {
                $path = $imagen->store('imagenes', 'public');
                Imagen::create([
                    'propiedad_id' => $propiedad->id,
                    'imagen_url' => 'storage/' . $path,
                ]);
            }
        }

        return redirect()->route('propiedades')->with('success', 'Propiedad actualizada correctamente.');
    }



    public function store(Request $request)
    {
        $request->validate([
            'tipo' => 'required',
            'direccion' => 'required',
            'referencias' => 'nullable|string',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric',
            'habitaciones' => 'nullable|integer',
            'banos' => 'nullable|integer',
            'dimensiones' => 'required|numeric',
            'estado' => 'required',
            'garage' => 'nullable|boolean',
            'usuario_id' => 'required|exists:usuarios,id'
        ]);
        

        $propiedad = Propiedad::create($request->all());

        // luego subes imágenes si las hay
        if ($request->hasFile('imagenes')) {
            foreach ($request->file('imagenes') as $imagen) {
                $path = $imagen->store('imagenes', 'public');
                Imagen::create([
                    'propiedad_id' => $propiedad->id,
                    'imagen_url' => 'storage/' . $path,
                ]);
            }
        }


        return redirect()->route('propiedades')->with('success', 'Propiedad registrada correctamente');
    }



    public function destroy($id)
    {
        $propiedad = Propiedad::findOrFail($id);

        // Elimina imágenes relacionadas si es necesario
        foreach ($propiedad->imagenes as $imagen) {
            // Puedes borrar también el archivo físico si está en el disco
            Storage::delete($imagen->imagen_url); // si usas Storage
            $imagen->delete();
        }

        $propiedad->delete();

        return redirect()->route('perfil')->with('success', 'Propiedad eliminada correctamente.');
    }


    public function show($id) //para una propiedad
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