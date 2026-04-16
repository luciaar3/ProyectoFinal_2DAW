<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NegocioComercio extends Model
{
    protected $table = 'negocio_comercios';
    protected $primaryKey = 'ID_negocio';
    
    // Los campos que se pueden rellenar
    protected $fillable = [
        'ID_usuario', 'Nombre', 'Descripcion', 'Horarios', 
        'Ciudad', 'Numero', 'Calle', 'Telefono', 'Imagen'
    ];
}
