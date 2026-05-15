<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Reserva;
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
            // Se le asigna el rol 'customer' ya que la tabla lo requiere según el enum
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

        // 1. RECOGER LAS VARIANTES
        // Buscamos todos los campos que empiecen por "variante_"
        $opcionesSeleccionadas = [];
        foreach ($request->all() as $key => $value) {
            if (str_contains($key, 'variante_')) {
                // Limpiamos el nombre (de "variante_talla" a "Talla")
                $nombreAtributo = ucfirst(str_replace('variante_', '', $key));
                $opcionesSeleccionadas[] = "$nombreAtributo: $value";
            }
        }
        
        // Convertimos el array ["Talla: L", "Color: Rojo"] en un string "Talla: L, Color: Rojo"
        $varianteTexto = implode(', ', $opcionesSeleccionadas);

        // 2. DESCONTAR STOCK
        $producto->stock -= $cantidad;
        $producto->save();

        // 3. CREAR LA RESERVA (Añadimos la nueva columna)
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

    public function misFavoritos()
    {
        // Obtener los productos favoritos del usuario
        $favoritos = auth()->user()->favoritos()->with('negocio')->get();
        return view('cliente.favoritos', compact('favoritos'));
    }
}
