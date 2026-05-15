<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Foro extends Model
{
    protected $table = 'foros';

    protected $fillable = [
        'titulo',
        'contenido',
        'user_id',
        'negocio_id',
        'parent_id'
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function negocio()
    {
        return $this->belongsTo(Negocio::class, 'negocio_id');
    }

    public function padre()
    {
        return $this->belongsTo(Foro::class, 'parent_id');
    }

    public function respuestas()
    {
        return $this->hasMany(Foro::class, 'parent_id')->oldest();
    }
}
