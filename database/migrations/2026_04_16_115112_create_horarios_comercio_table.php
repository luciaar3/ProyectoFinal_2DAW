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
        Schema::create('horario_negocio', function (Blueprint $table) {
            $table->id();
            $table->foreignId('negocio_id')->constrained('negocio')->onDelete('cascade');
            // Tiempo
            $table->enum('dia', ['lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado', 'domingo']);
            $table->time('apertura');
            $table->time('cierre');
            $table->boolean('festivo_cerrado')->default(false);

            // Ubicación del puesto (donde se mueve el negocio)
            $table->string('poblacion'); // Ej: Valencia, Torrent...
            $table->string('ubicacion'); // Ej: Mercadillo de Nazaret
            
            
            // Para el mapa (muy recomendado)
            $table->decimal('latitud', 10, 8)->nullable();
            $table->decimal('longitud', 11, 8)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('horario_negocio');
    }
};
