<?php

namespace App\Http\Controllers;

use App\Models\Negocio;
use Illuminate\Http\Request;

class NegocioController extends Controller
{
    public function index(Request $request)
    {
        // 1. Configuración de fechas
        $diasSemana = [
            'Sunday' => 'domingo', 'Monday' => 'lunes', 'Tuesday' => 'martes',
            'Wednesday' => 'miercoles', 'Thursday' => 'jueves', 'Friday' => 'viernes', 'Saturday' => 'sabado'
        ];
        $diaHoy = $diasSemana[now()->format('l')];
        $diaFiltro = $request->get('dia', $diaHoy);

        // 2. Iniciamos la Query
        $query = Negocio::with(['horarios', 'imagenes']);

        // 3. Aplicamos Filtro por nombre o población
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nombre_negocio', 'like', "%$search%")
                ->orWhereHas('horarios', function($q2) use ($search) {
                    $q2->where('poblacion', 'like', "%$search%");
                });
            });
        }

        // 4. Aplicamos Filtro por día (Solo negocios que abren ese día y no es festivo)
        $query->whereHas('horarios', function($q) use ($diaFiltro) {
            $q->where('dia', $diaFiltro)->where('festivo_cerrado', false);
        });

        // 5. OBTENEMOS DATOS PARA EL MAPA (Todos los que cumplen el filtro, sin paginar)
        // Usamos clone para no ensuciar la query original que luego paginaremos
        $puntosMapa = (clone $query)->get()->map(function($n) use ($diaFiltro) {
            $h = $n->horarios->where('dia', $diaFiltro)->first();
            return [
                'id'     => $n->id,
                'nombre_negocio' => $n->nombre_negocio,
                'lat'    => $h->latitud,
                'lng'    => $h->longitud,
                'pob'    => $h->poblacion,
                'ubi'    => $h->ubicacion,
                'url'    => route('negocios.show', $n->id),
                'logo'   => $n->imagen ? asset('storage/'.$n->imagen) : 'https://via.placeholder.com/50'
            ];
        });

        // 6. EJECUTAMOS LA PAGINACIÓN PARA LA LISTA
        $negocios = $query->paginate(10)->withQueryString(); 

        return view('comerciante.negocio.index', compact('negocios', 'puntosMapa', 'diaHoy', 'diaFiltro'))->findOrFail($id);
    }

    public function show(Negocio $negocio)
    {
        // 1. Cargamos las relaciones sobre el objeto YA EXISTENTE
        // Usamos load(), NO with(). load() mantiene el objeto como Modelo.
        $negocio->load(['horarios', 'productos', 'imagenes']);

        // 2. Definimos el día de hoy (puedes usar este helper rápido)
        $diasSemana = [
            'Sunday' => 'domingo', 'Monday' => 'lunes', 'Tuesday' => 'martes',
            'Wednesday' => 'miercoles', 'Thursday' => 'jueves', 'Friday' => 'viernes', 'Saturday' => 'sabado'
        ];
        $diaHoy = $diasSemana[now()->format('l')];

        // 3. Enviamos a la vista
        return view('comerciante.negocio.show', compact('negocio', 'diaHoy'));
    }
}
