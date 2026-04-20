<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\NegocioRequest;
use App\Models\ImagenNegocio;

class ComercianteController extends Controller
{
    public function account()
    {
        // Cargamos al usuario junto con su negocio relacionado
        $user = Auth::user()->load('negocio');
        
        return view('comerciante.account', compact('user'));
    }

    // Muestra el formulario para editar la info del negocio
    public function edit()
    {
        $negocio = Auth::user()->negocio;
        return view('comerciante.edit', compact('negocio'));
    }

    // Procesa la actualización
    public function update(NegocioRequest $request)
    {
        $negocio = Auth::user()->negocio;
        
        $negocio->nombre = $request->nombre;
        $negocio->nif = $request->nif;
        $negocio->telefono = $request->telefono;
        $negocio->descripcion = $request->descripcion;
        $negocio->numero_permiso = $request->numero_permiso;
        //logo
        if ($request->hasFile('imagen')) {
            if ($negocio->imagen) {
                Storage::disk('public')->delete($negocio->imagen);
            }
            $negocio->imagen = $request->file('imagen')->store('negocios/logos', 'public');
        }
        $negocio->save();
        
        //galeria del negocio (carrusel)
        if ($request->hasFile('imagenes_galeria')) {
            foreach ($request->file('imagenes_galeria') as $foto) {
                $ruta = $foto->store('negocios/galeria', 'public');
                
                // Creamos el registro en la tabla
                $negocio->imagenes()->create([
                    'ruta' => $ruta,
                    'orden' => 0
                ]);
            }
        }

        return redirect()->route('comerciante.account');
    }

    public function destroyImagen(ImagenNegocio $imagen) 
    {
        // Solo puede borrar si es su propio negocio
        if ($imagen->negocio_id === auth()->user()->negocio->id) {
            Storage::disk('public')->delete($imagen->ruta);
            $imagen->delete();
            return back();
        }
        return back();
    }
}
