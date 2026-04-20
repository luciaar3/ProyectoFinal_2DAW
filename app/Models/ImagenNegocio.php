<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImagenNegocio extends Model
{
    protected $table = 'imagen_negocio';
    protected $fillable = ['negocio_id', 'ruta', 'orden'];

    public function negocio()
    {
        return $this->belongsTo(Negocio::class);
    }
}
