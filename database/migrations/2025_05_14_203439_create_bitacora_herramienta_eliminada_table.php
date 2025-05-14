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
        Schema::create('bitacora_herramienta_eliminada', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('id_herramienta', 45)->nullable();
            $table->string('nombre', 45);
            $table->string('comentario', 100)->nullable();
            $table->binary('articulo')->nullable();
            $table->string('nombre_usuario', 100)->nullable();
            $table->string('usuario_num_colaborador', 45)->nullable();
            $table->string('accion', 100)->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bitacora_herramienta_eliminada');
    }
};
