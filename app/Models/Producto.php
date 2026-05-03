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

    public function favoritedBy() {
        return $this->belongsToMany(User::class, 'user_product', 'producto_id', 'user_id')->withPivot('rol')->withTimestamps();
    }

    public function reservations() {
        return $this->hasMany(Reservation::class, 'product_id');
    }
}
