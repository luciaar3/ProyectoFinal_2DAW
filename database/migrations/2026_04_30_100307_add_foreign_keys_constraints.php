<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Ahora que todas las tablas existen, conectamos user_business con negocio
        Schema::table('user_business', function (Blueprint $table) {
            $table->foreign('business_id')->references('id')->on('negocio')->onDelete('cascade');
        });

        // Aprovechamos para conectar reservation si también te fallaba
        Schema::table('reservation', function (Blueprint $table) {
            $table->foreign('business_id')->references('id')->on('negocio')->onDelete('cascade');
        });

        Schema::table('user_product', function (Blueprint $table) {
            $table->foreign('product_id')->references('id')->on('productos')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('user_business', function (Blueprint $table) {
            $table->dropForeign(['business_id']);
        });
    }
};
