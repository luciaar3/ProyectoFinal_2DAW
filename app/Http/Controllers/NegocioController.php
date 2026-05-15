<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use App\Models\Negocio;
use App\Models\Etiqueta;
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
        if ($request->filled('categoria')) {
            $categoriaNombre = $request->categoria;
            $query->whereHas('productos.etiquetas', function($q) use ($categoriaNombre) {
                // Buscamos por el nombre en la tabla 'etiquetas'
                $q->where('nombre', $categoriaNombre);
            });
        }

        // 4. Aplicamos Filtro por día (Solo negocios que abren ese día y no es festivo)
        $query->whereHas('horarios', function($q) use ($diaFiltro) {
            $q->where('dia', $diaFiltro)->where('festivo_cerrado', false);
        });

        // 5. OBTENEMOS DATOS PARA EL MAPA (Todos los que cumplen el filtro, sin paginar)
        $puntosMapa = (clone $query)->get()->map(function($n) use ($diaFiltro) {
            // Buscamos el horario del día que estamos filtrando
            $h = $n->horarios->where('dia', $diaFiltro)->first();
            
            // Si por algún error ese día no tiene horario (aunque no debería pasar), evitamos que rompa
            if (!$h) return null;

            return [
                'id'             => $n->id,
                'nombre_negocio' => $n->nombre_negocio,
                'lat'            => $h->latitud,
                'lng'            => $h->longitud,
                'pob'            => $h->poblacion,
                'ubi'            => $h->ubicacion,
                'url'            => route('negocios.show', $n->id),
                // Si tienes una carpeta 'img' dentro de 'public', asegúrate de que la ruta sea correcta
                'logo'           => $n->imagen ? asset('storage/'.$n->imagen) : asset('img/default-logo.png')
            ];
        })->filter();

        // 6. EJECUTAMOS LA PAGINACIÓN PARA LA LISTA
        $negocios = $query->paginate(10)->withQueryString(); 

        $etiquetas = Etiqueta::all();

        return view('comerciante.negocio.index', compact('negocios', 'puntosMapa', 'diaHoy', 'diaFiltro', 'etiquetas'));
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

    public function misReservas()
    {
        // 1. Buscamos el negocio que pertenece al usuario autenticado
        $negocio = Negocio::where('user_id', auth()->id())->firstOrFail();

        // 2. Traemos las reservas de los productos de ese negocio
        // Usamos 'with' para cargar el producto y el cliente de golpe (evita lentitud)
        $reservas = Reserva::whereHas('producto', function($query) use ($negocio) {
            $query->where('negocio_id', $negocio->id);
        })->with(['producto', 'user', 'lugarRecogida'])->orderBy('created_at', 'desc')->get();

        return view('comerciante.negocio.reservas', compact('reservas', 'negocio'));
    }

    public function actualizarEstadoReserva(Request $request, Reserva $reserva)
    {
        // Validamos que el estado sea uno de los permitidos
        $request->validate([
            'estado' => 'required|in:pendiente,completada,cancelada'
        ]);

        // Opcional: Podrías verificar que la reserva pertenece al negocio del usuario actual
        // if ($reserva->producto->negocio->user_id !== auth()->id()) { abort(403); }

        $reserva->update([
            'estado' => $request->estado
        ]);

        return back()->with('success', 'Estado de la reserva actualizado a ' . $request->estado);
    }
}
