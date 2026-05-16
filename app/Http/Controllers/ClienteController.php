<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Reserva;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function toggleFavorito(Request $request, Producto $producto)
    {
        $user = auth()->user();
        
        // Verifica si ya es favorito
        if ($user->favoritos()->where('producto_id', $producto->id)->exists()) {
            $user->favoritos()->detach($producto->id);
            $message = 'Producto eliminado de favoritos.';
            $is_favorite = false;
        } else {
            $user->favoritos()->attach($producto->id, ['rol' => 'Cliente']);
            $message = 'Producto añadido a favoritos.';
            $is_favorite = true;
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'message' => $message, 'is_favorite' => $is_favorite]);
        }

        return back()->with('success', $message);
    }

    public function reservar(Request $request, Producto $producto)
    {
        $request->validate([
            'cantidad' => 'required|integer|min:1|max:' . $producto->stock,
            'horario_negocio_id' => 'required|exists:horario_negocio,id', // Validamos que el mercado exista
        ]);

        $cantidad = $request->input('cantidad');

        $opcionesSeleccionadas = [];
        foreach ($request->all() as $key => $value) {
            if (str_contains($key, 'variante_')) {
                $nombreAtributo = ucfirst(str_replace('variante_', '', $key));
                $opcionesSeleccionadas[] = "$nombreAtributo: $value";
            }
        }
        
        $varianteTexto = implode(', ', $opcionesSeleccionadas);

        $producto->stock -= $cantidad;
        $producto->save();

        Reserva::create([
            'fecha_expiracion' => now()->addDays(7),
            'fecha_creacion'   => now(),
            'estado'           => 'pendiente',
            'coste_total'      => $producto->precio * $cantidad,
            'user_id'          => auth()->id(),
            'producto_id'      => $producto->id,
            'cantidad'         => $cantidad,
            'variante_elegida' => $varianteTexto ?: 'Sin variantes', 
            'horario_negocio_id' => $request->input('horario_negocio_id'),
        ]);

        $message = 'Reserva realizada con éxito.';

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'message' => $message, 'new_stock' => $producto->stock]);
        }

        return back()->with('success', $message);
    }

    public function misReservas()
    {
        // Obtener las reservas del usuario con el producto y el negocio asociado
        $reservas = auth()->user()->reservas()->with(['producto.negocio', 'lugarRecogida']) ->orderBy('fecha_creacion', 'desc')->get();
        return view('cliente.reservas', compact('reservas'));
    }

    public function cancelarReserva($id)
    {
        $reserva = Reserva::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        if ($reserva->estado !== 'pendiente') {
            return back()->with('error', 'Esta reserva ya no se puede cancelar porque está ' . $reserva->estado . '.');
        }

        if ($reserva->producto) {
            $reserva->producto->increment('stock', $reserva->cantidad);
        }

        $reserva->estado = 'cancelada';
        $reserva->save();

        return back()->with('success', 'La reserva ha sido cancelada correctamente.');
    }

    public function misFavoritos()
    {
        // Obtener los productos favoritos del usuario
        $favoritos = auth()->user()->favoritos()->with('negocio')->get();
        return view('cliente.favoritos', compact('favoritos'));
    }
}
