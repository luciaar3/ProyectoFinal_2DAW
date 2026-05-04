<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    protected $table = 'reservas';

    protected $fillable = [
        'fecha_expiracion',
        'fecha_creacion',
        'estado',
        'coste_total',
        'user_id',
        'producto_id',
        'cantidad',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }

    public function getPrecioTotalAttribute() 
    {
        // Multiplica la cantidad de la reserva por el precio del producto
        return $this->cantidad * ($this->producto->precio ?? 0);
    }
}
