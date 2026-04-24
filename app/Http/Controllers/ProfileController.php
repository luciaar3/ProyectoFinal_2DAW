<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ProfileRequest;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ProfileController extends Controller
{
    public function editProfile(): View
    {
        // Cargamos al usuario junto con su negocio relacionado
        return view('profile.edit', [
            'user' => Auth::user()
        ]);
    }

    // Procesa el formulario y actualiza los datos
    public function updateProfile(ProfileRequest $request): RedirectResponse
    {
        $user = Auth::user();

        // 1. Actualización de datos del usuario
        $user->nombre = $request->get('nombre');
        $user->primer_apellido = $request->get('primer_apellido');
        $user->segundo_apellido = $request->get('segundo_apellido');
        $user->email = $request->get('email');

        if ($request->filled('password')) {
            $user->password = Hash::make($request->get('password'));
        }
        $user->save();

        // 2. Actualización de la tabla NEGOCIO
        // Solo si el usuario es Comerciante
        if ($user->rol === 'Comerciante') {
            $user->negocio()->updateOrCreate(
                ['user_id' => $user->id], // Buscamos por el ID del usuario
                [
                    'nombre'         => $request->get('nombre'),
                    'descripcion'    => $request->get('descripcion'),
                    'nif'            => $request->get('nif'),         // Nuevo campo obligatorio
                    'numero_permiso' => $request->get('numero_permiso'), // Nuevo campo
                    'telefono'       => $request->get('telefono'),
                ]
            );
        }
        return back();
    }
}
