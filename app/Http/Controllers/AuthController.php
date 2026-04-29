<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Negocio;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\RegistroRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AuthController extends Controller
{
    // 1. Muestra el formulario de registro
    public function showRegistro(): View
    {
        return view('auth.registro');
    }

    // 2. Procesa el formulario de registro
    public function registrar(RegistroRequest $request): RedirectResponse
    {
        // Usamos una transacción para que si el negocio falla, el usuario no se guarde
        $user = DB::transaction(function () use ($request) {
            $user = new User();
            $user->nombre = $request->get('nombre');
            $user->primer_apellido = $request->get('primer_apellido');
            $user->segundo_apellido = $request->get('segundo_apellido');
            $user->email = $request->get('email');
            $user->password = Hash::make($request->get('password'));
            $user->rol = $request->get('rol'); // 'Cliente' o 'Comerciante'
            $user->save();

            if ($user->rol === 'Comerciante') {
                $negocio = new Negocio();
                $negocio->user_id = $user->id; // Ajustado a minúsculas
                $negocio->nombre_negocio = $request->get('nombre_negocio');
                $negocio->descripcion = $request->get('descripcion');
                $negocio->nif = $request->get('nif'); 
                $negocio->numero_permiso = $request->get('numero_permiso');
                $negocio->telefono = $request->get('telefono');
                $negocio->save();
            }

            return $user;
        });

        Auth::login($user);

        // Redirección por roles
        if ($user->rol === 'Comerciante') {
            return redirect()->route('comerciante.account');
        }
        
        return redirect()->route('cliente.account');
    }

    // 3. Muestra el formulario de login (Con comprobación previa)
    public function showLogin()
    {
        if (Auth::viaRemember() || Auth::check()) {
            // Si ya está logueado, lo mandamos a su panel según su rol
            $rol = Auth::user()->rol;
            if ($rol === 'Admin') {
                return redirect()->route('admin.account');
            } elseif ($rol === 'Comerciante') {
                return redirect()->route('comerciante.account');
            }
            return redirect()->route('account');
        } else {
            return view('auth.login');
        }
    }

    // 4. Procesa el inicio de sesión
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('web')->attempt($credentials)) {
            $request->session()->regenerate();
            
            // Redirección por rol
            $rol = Auth::user()->rol;
            if ($rol === 'Admin') {
                return redirect()->intended('/admin/account');
            } elseif ($rol === 'Comerciante') {
                return redirect()->intended('/comerciante/account');
            }
            return redirect()->intended('/account');
        } else {
            // Retornamos hacia atrás con el error para que lo pinte Blade
            return back()->withErrors([
                'email' => 'Error al acceder a la aplicación. Las credenciales no coinciden.',
            ])->onlyInput('email');
        }
    }

    // 5. Cerrar sesión
    public function logout(Request $request): RedirectResponse
    {

       // dd('logout');
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/');
    }

    // 6. vistas
    public function accountCliente(): View {
        // Traemos todos los negocios para poder listarlos
        $negocios = Negocio::all(); 
        return view('cliente.account', compact('negocios'));
    }

    public function accountAdmin(): View {
        return view('admin.account');
    }
}