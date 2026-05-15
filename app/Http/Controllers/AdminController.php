<?php

namespace App\Http\Controllers;

use App\Models\Negocio;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function account()
    {
        $totalPendientes = Negocio::where('estado_validacion', 'pendiente')->count();

        $totalUsuarios = \App\Models\User::count();
        $totalDenuncias = 0; 

        return view('admin.account', compact('totalPendientes', 'totalUsuarios', 'totalDenuncias'));
    }

    public function index()
    {
        $pendientes = Negocio::where('estado_validacion', 'pendiente')->with('user')->get();
        return view('admin.validaciones', compact('pendientes'));
    }

    public function aprobar($id)
    {
        $negocio = Negocio::findOrFail($id);
        $negocio->update(['estado_validacion' => 'aprobado']);

        return back();
    }
    
    public function rechazar($id)
    {
        $negocio = Negocio::findOrFail($id);
        $negocio->update(['estado_validacion' => 'rechazado']);

        return back();
    }

    public function usersIndex()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    public function userDestroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return back();
    }
}
