<?php

namespace App\Http\Controllers;

use App\Models\Negocio;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function account()
{
    // 1. Contamos cuántos negocios hay pendientes de validar
    $totalPendientes = Negocio::where('estado_validacion', 'pendiente')->count();

    // 2. Contamos el total de usuarios (puedes filtrar por rol si quieres)
    $totalUsuarios = \App\Models\User::count();

    // 3. Denuncias (si aún no tienes la tabla, lo dejamos en 0 o estático por ahora)
    $totalDenuncias = 0; 

    return view('admin.account', compact('totalPendientes', 'totalUsuarios', 'totalDenuncias'));
}
    // Mostrar todos los negocios pendientes de validar
    public function index()
    {
        $pendientes = Negocio::where('estado_validacion', 'pendiente')->with('user')->get();
        return view('admin.validaciones', compact('pendientes'));
    }

    // Aprobar un negocio
    public function aprobar($id)
    {
        $negocio = Negocio::findOrFail($id);
        $negocio->update(['estado_validacion' => 'aprobado']);

        return back();
    }

    // Rechazar un negocio (opcional, podrías borrarlo o cambiar estado)
    public function rechazar($id)
    {
        $negocio = Negocio::findOrFail($id);
        $negocio->update(['estado_validacion' => 'rechazado']);

        return back();
    }
}
