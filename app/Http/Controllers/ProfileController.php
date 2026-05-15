<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ProfileRequest;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ProfileController extends Controller
{
    public function edit(): View
    {
        // Cargamos al usuario junto con su negocio relacionado
        return view('profile.edit', [
            'user' => Auth::user()->load('negocio')
        ]);
    }

    // Procesa el formulario y actualiza los datos
    public function update(ProfileRequest $request): RedirectResponse
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

        if ($user->rol === 'Comerciante') {
            return redirect()->route('comerciante.account')->with('success');
        }

        // Si no es comerciante, lo mandamos a la cuenta de cliente
        return redirect()->route('cliente.account')->with('success');
    }

    public function destroy()
    {
        $user = Auth::user();
        Auth::logout();
        $user->delete();
        return redirect()->route('index');
    }
}
