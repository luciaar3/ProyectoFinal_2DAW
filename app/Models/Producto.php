<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $fillable = [
        'negocio_id', 'nombre', 'descripcion', 'precio', 'stock', 'imagen', 'categoria', 'disponible'
    ];
    public function negocio() {
        return $this->belongsTo(Negocio::class);
    }
}
