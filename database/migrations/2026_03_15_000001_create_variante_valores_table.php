<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('variante_valores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('producto_variante_id')->constrained('producto_variantes')->onDelete('cascade');
            $table->foreignId('atributo_valor_id')->constrained('atributo_valores')->onDelete('cascade');
            
            // Clave unica compuesta para que no se repitan valores en la misma variante
            $table->unique(['producto_variante_id', 'atributo_valor_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('variante_valores');
    }
};
