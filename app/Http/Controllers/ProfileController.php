<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ProfileRequest;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\User;

class ProfileController extends Controller
{
    public function editProfile(): View
    {
        // Cargamos al usuario junto con su negocio relacionado
        return view('profile.edit', [
            'user' => Auth::user()->load('negocio')
        ]);
    }

    // Procesa el formulario y actualiza los datos
    public function updateProfile(ProfileRequest $request, User $user): RedirectResponse
    {
        $user = Auth::user();
        $user->nombre = $request->input('nombre');
        $user->primer_apellido = $request->input('primer_apellido');
        $user->segundo_apellido = $request->input('segundo_apellido');
        $user->email = $request->input('email');


        // Actualización de la tabla NEGOCIO_COMERCIO
        // Como ahora todos son vendedores ambulantes, actualizamos o creamos siempre.
        // Asumimos que tienes la relación 'negocio()' definida en tu modelo User.
        $user->negocio()->updateOrCreate(
            ['ID_usuario' => $user->ID_usuario], // Buscamos por el ID del usuario
            [
                'Nombre'      => $request->get('nombre_negocio'),
                'Descripcion' => $request->get('descripcion'),
                'Ciudad'      => $request->get('ciudad'),
                'Calle'       => $request->get('calle'),
                'Numero'      => $request->get('numero'),
                'Telefono'    => $request->get('telefono'),
            ]
        );

        // Solo hasheamos y guardamos la contraseña si el usuario ha escrito algo
        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }
        $user->save();
        return back()->with('success', 'Perfil actualizado');
    }
}
