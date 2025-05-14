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
        Schema::create('herramienta', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('imagen', 191)->nullable();
            $table->string('cantidad', 45)->nullable();
            $table->string('articulo', 45)->nullable();
            $table->string('unidad', 45)->nullable();
            $table->string('modelo', 100)->nullable();
            $table->string('num_serie', 100)->nullable();
            $table->string('observaciones', 191)->nullable();
            $table->integer('resguardo_folio')->index('fk_herramienta_resguardo1_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('herramienta');
    }
};
