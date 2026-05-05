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

    public function etiquetas()
    {
        return $this->belongsToMany(Etiqueta::class, 'producto_etiqueta');
    }

    public function variantes()
    {
        return $this->hasMany(ProductoVariante::class, 'producto_id');
    }

    public function favoritedBy() {
        return $this->belongsToMany(User::class, 'producto_user', 'producto_id', 'user_id')->withPivot('rol')->withTimestamps();
    }

    public function reservas() {
        return $this->hasMany(Reserva::class, 'producto_id');
    }
}
