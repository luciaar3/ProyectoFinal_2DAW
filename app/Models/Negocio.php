<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Negocio extends Model
{
    protected $table = 'negocio';
    protected $primaryKey = 'ID_negocio';
    
    // Los campos que se pueden rellenar
    protected $fillable = [
        'ID_usuario', 'nombre', 'descripcion', 'horario', 
        'ciudad', 'numero_permiso', 'nif', 'telefono', 'imagen'
    ];
}
