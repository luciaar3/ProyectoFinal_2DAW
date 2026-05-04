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
        Schema::create('producto_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            // CAMBIO: Quitamos constrained() para que no busque la tabla 'products' o 'productos' todavía
            $table->foreignId('producto_id')->constrained('productos')->onDelete('cascade');
            $table->enum('rol', ['Admin', 'Comerciante', 'Cliente'])->default('Cliente');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('producto_user');
    }
};
