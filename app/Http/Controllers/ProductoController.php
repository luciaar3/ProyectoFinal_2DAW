<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Etiqueta; 
use App\Models\ProductoVariante;
use App\Models\AtributoValor;
use App\Models\Atributo;
use App\Http\Requests\ProductoRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    // Ver el catálogo
    public function index()
    {
        $negocio = auth()->user()->negocio;
        $productos = $negocio->productos()->with('etiquetas')->latest()->get();

        $etiquetas = Etiqueta::all();
        $atributos_valores = AtributoValor::with('atributo')->get();
        return view('comerciante.negocio.productos.index', compact('productos', 'atributos_valores', 'etiquetas'));
    }

    public function show($id)
    {
        // Buscamos el producto con sus variantes y el negocio
        $producto = Producto::with(['variantes', 'negocio.horarios'])->findOrFail($id);
        
        // Necesitamos el día de hoy para el layout o información de entrega
        $diaHoy = now()->locale('es')->dayName; 

        return view('comerciante.negocio.productos.show', compact('producto', 'diaHoy'));
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

        if ($request->etiqueta_nombre) {
            // Buscamos la etiqueta por nombre. Si no existe, la crea.
            $etiqueta = Etiqueta::firstOrCreate([
                'nombre' => ucfirst($request->etiqueta_nombre) // Lo guarda con la primera en mayúscula
            ]);

            // La unimos al producto en la tabla pivote
            $producto->etiquetas()->attach($etiqueta->id);
        }

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

        if ($request->etiqueta_nombre) {
            $etiqueta = Etiqueta::firstOrCreate([
                'nombre' => ucfirst($request->etiqueta_nombre)
            ]);
            // sync reemplaza la etiqueta anterior por la nueva
            $producto->etiquetas()->sync([$etiqueta->id]);
        }

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

    public function getVariantes($id)
    {
        // Buscamos las variantes de forma simple
        $variantes = ProductoVariante::where('producto_id', $id)->get();
        
        // Mapeamos para que el JS reciba exactamente lo que espera pintar
        $resultado = $variantes->map(function($v) {
            return [
                'id' => $v->id,
                // Concatenamos Tipo y Valor (Ej: "Talla: XL")
                'nombre_valor' => $v->tipo . ': ' . $v->nombre_valor,
                'stock' => $v->stock
            ];
        });

        return response()->json($resultado);
    }

    public function addVariante(Request $request)
    {
        try {
            $variante = ProductoVariante::updateOrCreate(
                [
                    'producto_id'  => $request->producto_id,
                    'tipo'         => $request->tipo,
                    'nombre_valor' => $request->valor, // Lo que viene del JS
                ],
                [
                    'stock' => $request->stock
                ]
            );

            return response()->json(['success' => true, 'variante' => $variante]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
