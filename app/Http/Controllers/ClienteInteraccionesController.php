<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ClienteInteraccionesController extends Controller
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
            // Se le asigna el rol 'customer' ya que la tabla lo requiere según el enum
            $user->favoritos()->attach($producto->id, ['rol' => 'customer']);
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
        ]);

        $cantidad = $request->input('cantidad');

        // Descontamos el stock
        $producto->stock -= $cantidad;
        $producto->save();

        // Se crea la reserva
        Reservation::create([
            'expiraton' => now()->addDays(7),
            'creation' => now(),
            'state' => 'sent',
            'cost' => $producto->precio * $cantidad,
            'user_id' => auth()->id(),
            'product_id' => $producto->id,
            'quantity' => $cantidad,
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
        $reservas = auth()->user()->reservations()->with(['producto.negocio'])->orderBy('created_at', 'desc')->get();
        return view('cliente.reservas', compact('reservas'));
    }

    public function misFavoritos()
    {
        // Obtener los productos favoritos del usuario
        $favoritos = auth()->user()->favoritos()->with('negocio')->get();
        return view('cliente.favoritos', compact('favoritos'));
    }
}
