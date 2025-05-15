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
        Schema::create('historial_resguardos', function (Blueprint $table) {
            $table->integer('id_historial', true);
            $table->integer('resguardo_folio')->index('fk_historial_resguardo');
            $table->integer('herramienta_id')->index('fk_historial_herramienta');
            $table->enum('estado', ['entregado', 'devuelto', 'en_transito']);
            $table->timestamp('fecha_movimiento')->useCurrent();
            $table->integer('usuario_id')->nullable()->index('fk_historial_usuario');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historial_resguardos');
    }
};
