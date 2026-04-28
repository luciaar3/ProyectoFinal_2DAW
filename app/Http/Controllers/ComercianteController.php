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
        
        $negocio->nombre_negocio = $request->nombre_negocio;
        $negocio->nif = $request->nif;
        $negocio->telefono = $request->telefono;
        $negocio->descripcion = $request->descripcion;
        
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

        if ($request->has('horarios')) {
        foreach ($request->horarios as $dia => $datosDia) {
            // Guardamos solo si hay población o apertura indicada
            if (!empty($datosDia['poblacion']) || !empty($datosDia['apertura'])) {
                $negocio->horarios()->updateOrCreate(
                    ['dia' => $dia],
                    [
                        'poblacion'       => $datosDia['poblacion'],
                        'ubicacion'       => $datosDia['ubicacion'],
                        'latitud'         => $datosDia['latitud'] ?? null,
                        'longitud'        => $datosDia['longitud'] ?? null,
                        'apertura'        => $datosDia['apertura'],
                        'cierre'          => $datosDia['cierre'],
                        'festivo_cerrado' => isset($datosDia['festivo_cerrado']), 
                    ]
                );
            } else {
                // Si el usuario borra los datos de un día, lo eliminamos de la BD
                $negocio->horarios()->where('dia', $dia)->delete();
            }
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
