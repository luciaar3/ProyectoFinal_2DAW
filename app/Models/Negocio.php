<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Negocio extends Model
{
    protected $table = 'negocio';
    
    // Los campos que se pueden rellenar
    protected $fillable = [
        'user_id',
        'nombre_negocio', 
        'descripcion', 
        'numero_permiso', 
        'nif', 
        'telefono', 
        'imagen',
        'estado_validacion'
    ];

    public function user()
    {
        // Esto soluciona el error del ComercianteController
        return $this->belongsTo(User::class, 'user_id');
    }

    // 4. DEFINIMOS LA RELACIÓN CON LOS HORARIOS
    public function horarios()
    {
        return $this->hasMany(HorarioNegocio::class, 'negocio_id');
    }

    public function imagenes() {
        return $this->hasMany(ImagenNegocio::class, 'negocio_id');
    }

    public function productos() {
        return $this->hasMany(Producto::class);
    }

    public function foros() {
        return $this->hasMany(Foro::class, 'negocio_id');
    }

    // Filtro para obtener solo los aprobados
    public function scopeValidados($query)
    {
        return $query->where('estado_validacion', 'aprobado');
    }

    /**
     * Boot function from Laravel.
     */
    protected static function booted()
    {
        static::created(function ($negocio) {
            \App\Models\Foro::create([
                'titulo' => '¡Bienvenidos al foro de ' . $negocio->nombre_negocio . '!',
                'contenido' => 'Hola a todos. He abierto este foro para que podáis preguntarme cualquier duda sobre mis productos, disponibilidad o pedir ayuda. ¡Estaré encantado de responderos!',
                'user_id' => $negocio->user_id,
                'negocio_id' => $negocio->id
            ]);
        });
    }
}
