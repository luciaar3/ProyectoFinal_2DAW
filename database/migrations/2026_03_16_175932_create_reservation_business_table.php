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
        Schema::create('reservation_business_', function (Blueprint $table) {
            $table->foreignId('reservation_id');
            $table->foreignId('business_id')->constrained('negocio');
            $table->enum('rol', ['admin', 'merchant', 'customer']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservation_business_');
    }
};
