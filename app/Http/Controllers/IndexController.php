<?php

namespace App\Http\Controllers;

use App\Models\Etiqueta;
use Illuminate\Http\Request;
use Illuminate\View\View;

class IndexController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
       // Traemos todas las etiquetas de la base de datos
        $etiquetas = Etiqueta::all();

        // Se las pasamos a la vista 'index'
        return view('index', compact('etiquetas'));
    }
}
