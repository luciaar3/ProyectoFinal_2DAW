<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HorarioNegocio extends Model
{
    protected $table = 'horario_negocio';

    protected $fillable = [
        'negocio_id', 'dia', 'apertura', 'cierre', 
        'festivo_cerrado', 'poblacion', 'ubicacion', 
        'latitud', 'longitud'
    ];

    public function negocio()
    {
        return $this->belongsTo(Negocio::class);
    }
}
