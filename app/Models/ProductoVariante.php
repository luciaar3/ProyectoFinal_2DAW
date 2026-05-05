<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductoVariante extends Model
{
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function valores()
    {
        return $this->belongsToMany(AtributoValor::class, 'variante_valores', 'producto_variante_id', 'atributo_valor_id');
    }
}
