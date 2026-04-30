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
        Schema::create('user_product', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            // CAMBIO: Quitamos constrained() para que no busque la tabla 'products' o 'productos' todavía
            $table->unsignedBigInteger('product_id');
            $table->enum('rol', ['admin', 'merchant', 'customer']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_product');
    }
};
