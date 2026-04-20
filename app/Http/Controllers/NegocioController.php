<?php

namespace App\Http\Controllers;

use App\Models\Negocio;
use Illuminate\Http\Request;
use Carbon\Carbon;

class NegocioController extends Controller
{
    public function index(Request $request)
    {
        // 1. Obtener el día de la semana actual en español
        $diasSemana = [
            'Sunday' => 'domingo', 'Monday' => 'lunes', 'Tuesday' => 'martes',
            'Wednesday' => 'miercoles', 'Thursday' => 'jueves', 'Friday' => 'viernes', 'Saturday' => 'sabado'
        ];
        $diaHoy = $diasSemana[Carbon::now()->format('l')];

        // 2. Query con filtros
        $query = Negocio::with(['horarios', 'imagenes']);

        // Filtro por nombre o población
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nombre', 'like', "%$search%")
                  ->orWhereHas('horarios', function($q2) use ($search) {
                      $q2->where('poblacion', 'like', "%$search%");
                  });
            });
        }

        // Filtro por día
        $diaFiltro = $request->get('dia', $diaHoy);
        $query->whereHas('horarios', function($q) use ($diaFiltro) {
            $q->where('dia', $diaFiltro)->where('festivo_cerrado', false);
        });

        $negocios = $query->get();

        //datos para el mapa
        $puntosMapa = $negocios->map(function($n) use ($diaFiltro) {
            $h = $n->horarios->where('dia', $diaFiltro)->first();
            return [
                'id'     => $n->id,
                'nombre' => $n->nombre,
                'lat'    => $h->latitud,
                'lng'    => $h->longitud,
                'pob'    => $h->poblacion,
                'ubi'    => $h->ubicacion,
                'url'    => route('negocios.show', $n->id),
                'logo'   => $n->imagen ? asset('storage/'.$n->imagen) : 'https://via.placeholder.com/50'
            ];
        });

        return view('comerciante.negocio.index', compact('negocios', 'puntosMapa', 'diaHoy', 'diaFiltro'));
    }

    public function show(Negocio $negocio)
    {
        $negocio->load(['horarios', 'imagenes']);
        return view('comerciante.negocio.show', compact('negocio'));
    }
}
