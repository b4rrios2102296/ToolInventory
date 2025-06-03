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
        Schema::create('herramientas', function (Blueprint $table) {
            $table->string('id', 25)->primary();
            $table->string('articulo')->nullable();
            $table->string('unidad', 45);
            $table->string('modelo', 100)->nullable();
            $table->string('num_serie', 100)->nullable();
            $table->string('estatus', 50)->nullable()->default('Disponible');
            $table->string('observaciones', 191)->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
            $table->double('costo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('herramientas');
    }
};
