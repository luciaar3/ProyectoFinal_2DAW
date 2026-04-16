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
        Schema::create('negocio_comercios', function (Blueprint $table) {
            $table->id('ID_negocio'); // cp
            $table->unsignedBigInteger('ID_usuario'); // fk
            
            $table->string('Nombre', 50);
            $table->string('Descripcion', 500);
            $table->integer('numero_puesto');
            $table->string('Ciudad', 100);
            $table->integer('Telefono');
            $table->string('Imagen')->nullable(); // Opcional
            $table->timestamps();

            // rf
            $table->foreign('ID_usuario')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('negocio_comercios');
    }
};
