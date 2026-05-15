<?php

namespace App\Http\Controllers;

use App\Models\Foro;
use App\Models\Negocio;
use Illuminate\Http\Request;

class ForoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $negocios = Negocio::all();
        return view('foros.index', compact('negocios'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|max:100',
            'contenido' => 'required',
            'negocio_id' => 'required|exists:negocio,id',
            'parent_id' => 'nullable|exists:foros,id'
        ]);

        Foro::create([
            'titulo' => $request->titulo,
            'contenido' => $request->contenido,
            'user_id' => auth()->id(),
            'negocio_id' => $request->negocio_id,
            'parent_id' => $request->parent_id
        ]);

        return back()->with('success', 'Mensaje publicado correctamente.');
    }

    public function show($id)
    {
        $negocio = Negocio::with(['foros' => function($query) {
            $query->whereNull('parent_id')->with(['usuario', 'respuestas.usuario']);
        }])->findOrFail($id);
        
        return view('foros.show', compact('negocio'));
    }
}
