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
        Schema::create('auditoria_herramientas', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('herramienta_id')->index('herramienta_id');
            $table->string('accion', 20);
            $table->string('cantidad', 45);
            $table->string('articulo', 45);
            $table->string('usuario', 100);
            $table->timestamp('fecha')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auditoria_herramientas');
    }
};
