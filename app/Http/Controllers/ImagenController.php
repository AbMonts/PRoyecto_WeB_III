<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Imagen;
use App\Models\Propiedad;
use Illuminate\Support\Facades\Storage;

class ImagenController extends Controller
{
    public function destroy($id)
    {
        $imagen = Imagen::findOrFail($id);

        // Verificar que la imagen sea del usuario actual
        if ($imagen->propiedad->usuario_id !== auth()->id()) {
            abort(403, 'No puedes eliminar esta imagen.');
        }

        // Eliminar archivo físico
        Storage::disk('public')->delete(str_replace('storage/', '', $imagen->imagen_url));
        
        // Eliminar registro de la BD
        $imagen->delete();

        return back()->with('success', 'Imagen eliminada correctamente.');
    }

    public function update(Request $request, $id)
    {
        $imagen = Imagen::findOrFail($id);

        if ($imagen->propiedad->usuario_id !== auth()->id()) {
            abort(403, 'No puedes editar esta imagen.');
        }

        $request->validate([
            'nueva_imagen' => 'required|image|max:2048'
        ]);

        // Borrar imagen anterior
        Storage::disk('public')->delete(str_replace('storage/', '', $imagen->imagen_url));

        // Subir la nueva
        $path = $request->file('nueva_imagen')->store('imagenes', 'public');
        $imagen->update([
            'imagen_url' => 'storage/' . $path
        ]);

        return back()->with('success', 'Imagen actualizada correctamente.');
    }


    public function store(Request $request)
    {
        $request->validate([
            'propiedad_id' => 'required|exists:propiedades,id',
            'imagenes.*' => 'required|image|max:2048',
        ]);

        foreach ($request->file('imagenes') as $imagen) {
            $path = $imagen->store('imagenes', 'public');
            \App\Models\Imagen::create([
                'propiedad_id' => $request->propiedad_id,
                'imagen_url' => 'storage/' . $path,
            ]);
        }

        return back()->with('success', 'Imágenes subidas correctamente.');
    }

}
