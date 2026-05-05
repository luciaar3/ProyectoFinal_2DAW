<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AtributoValor extends Model
{
    protected $table = 'atributo_valores';
    
    public function atributo() {
        return $this->belongsTo(Atributo::class, 'atributo_id');
    }
}
