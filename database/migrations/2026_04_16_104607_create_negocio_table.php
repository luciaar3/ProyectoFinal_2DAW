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
        Schema::create('negocio', function (Blueprint $table) {
            
            $table->id(); // cp
            $table->foreignId('user_id')->unique()->constrained('users')->onDelete('cascade'); // fk
            
            $table->string('nombre', 50);
            $table->string('descripcion', 500);
            $table->integer('numero_permiso');
            $table->string('nif', 9)->unique();
            $table->integer('telefono');
            $table->string('imagen')->nullable(); // Opcional
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('negocio');
    }
};
