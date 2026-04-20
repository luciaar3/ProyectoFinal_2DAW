<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\NegocioRequest;
use App\Http\Requests\ImagenesNegocioRequest;

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
        $datos = $request->validated(); // Aquí ya vienen solo los datos limpios y validados

        if ($request->hasFile('imagen')) {
        if ($negocio->imagen) Storage::disk('public')->delete($negocio->imagen);
        $datos['imagen'] = $request->file('imagen')->store('negocios/logos', 'public');
    }

        $negocio->update($datos);
        return redirect()->route('comerciante.account');
    }

    public function storeImagenes(ImagenesNegocioRequest $request) 
    {
        $negocio = auth()->user()->negocio;

        foreach ($request->file('fotos') as $foto) {
            $ruta = $foto->store('negocios/galeria', 'public');
            $negocio->imagenes()->create(['ruta' => $ruta]);
        }

        return back();
    }
}
