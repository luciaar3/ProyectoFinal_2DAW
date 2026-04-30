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
        Schema::create('user_business', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Hacia 'users' (ya existe)
            $table->unsignedBigInteger('business_id'); // <--- CAMBIO: Solo el campo, sin constrained()
            $table->enum('rol', ['admin', 'merchant', 'customer']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_business');
    }
};
