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
        return view('profile.edit', [
            'user' => Auth::user()
        ]);
    }

    // Procesa el formulario y actualiza los datos
    public function updateProfile(ProfileRequest $request): RedirectResponse
    {
        $user = Auth::user();
        $user->nombre = $request->get('nombre');
        $user->primer_apellido = $request->get('primer_apellido');
        $user->segundo_apellido = $request->get('segundo_apellido');
        $user->email = $request->get('email');


        if ($user->rol === 'Comerciante') {
            $user->nombre_comercio = $request->get('nombre_comercio');
            $user->cif = $request->get('cif');
            $user->direccion = $request->get('direccion');
        }
        // Solo hasheamos y guardamos la contraseña si el usuario ha escrito algo
        if ($request->filled('password')) {
            $user->password = Hash::make($request->get('password'));
        }
        $user->save();

        return back();
    }
}
