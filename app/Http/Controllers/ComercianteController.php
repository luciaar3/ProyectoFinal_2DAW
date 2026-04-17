<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

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
    public function update(Request $request)
{
    $negocio = Auth::user()->negocio;
    
    $validated = $request->validate([
        'nombre'         => 'required|string|max:50',
        'descripcion'    => 'required|string|max:500',
        'nif'            => 'required|string|size:9|unique:negocio,nif,' . $negocio->id,
        'numero_permiso' => 'required|integer',
        'telefono'       => 'required|integer',
    ]);

    $negocio->update($validated);
    return redirect()->route('comerciante.account');
}
}
