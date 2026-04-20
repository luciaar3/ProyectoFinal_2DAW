<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Negocio extends Model
{
    protected $table = 'negocio';
    
    // Los campos que se pueden rellenar
    protected $fillable = [
        'user_id',
        'nombre', 
        'descripcion', 
        'numero_permiso', 
        'nif', 
        'telefono', 
        'imagen'
    ];

    public function user()
    {
        // Esto soluciona el error del ComercianteController
        return $this->belongsTo(User::class, 'user_id');
    }

    // 4. DEFINIMOS LA RELACIÓN CON LOS HORARIOS (Rutas ambulantes)
    public function horarios()
    {
        return $this->hasMany(HorarioNegocio::class, 'negocio_id');
    }

    public function imagenes() {
    return $this->hasMany(ImagenNegocio::class, 'negocio_id');
}
}
