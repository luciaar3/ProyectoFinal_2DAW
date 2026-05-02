<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Http\Requests\ProductoRequest;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{
    // Ver el catálogo
    public function index()
    {
        $negocio = auth()->user()->negocio;
        $productos = $negocio->productos()->latest()->get();
        return view('comerciante.negocio.productos.index', compact('productos'));
    }

    public function store(ProductoRequest $request)
    {
        $negocio = auth()->user()->negocio;

        if ($negocio->estado_validacion !== 'aprobado') {
            return back();
        }

        // Creamos la instancia del producto con los datos validados
        $producto = new Producto();
        $producto->negocio_id = $negocio->id;
        $producto->nombre      = $request->nombre;
        $producto->descripcion = $request->descripcion;
        $producto->precio      = $request->precio;
        $producto->stock       = $request->stock;
        $producto->categoria   = $request->categoria;

        // Gestión de la imagen tal como lo hacías en el Negocio
        if ($request->hasFile('imagen')) {
            $producto->imagen = $request->file('imagen')->store('productos', 'public');
        }

        $producto->save();

        return back();
    }

    public function update(ProductoRequest $request, Producto $producto)
    {
        // Seguridad: verificar que el producto es de Pepa
        if ($producto->negocio_id !== auth()->user()->negocio->id) {
            abort(403);
        }

        $producto->nombre = $request->nombre;
        $producto->descripcion = $request->descripcion;
        $producto->precio = $request->precio;
        $producto->stock = $request->stock;
        $producto->categoria = $request->categoria;

        if ($request->hasFile('imagen')) {
            // Borramos la vieja si existe
            if ($producto->imagen) {
                Storage::disk('public')->delete($producto->imagen);
            }
            $producto->imagen = $request->file('imagen')->store('productos', 'public');
        }

        $producto->save();

        return back();
    }

    public function destroy(Producto $producto)
    {
        // Verificamos que el producto pertenece al negocio del usuario
        if ($producto->negocio_id === auth()->user()->negocio->id) {
            
            // Borramos la imagen del disco si existe
            if ($producto->imagen) {
                Storage::disk('public')->delete($producto->imagen);
            }

            $producto->delete();
            return back();
        }

        return back();
    }
}
