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
        Schema::create('bitacora', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('usuario_id')->nullable()->index('usuario_id')->comment('Usuario que realizó la acción');
            $table->string('accion', 50)->comment('Tipo de acción (crear, actualizar, eliminar, etc.)');
            $table->string('modulo', 50)->comment('Módulo afectado (herramientas, resguardos, etc.)');
            $table->integer('registro_id')->nullable()->comment('ID del registro afectado');
            $table->json('cambios_anteriores')->nullable()->comment('Valores antes del cambio');
            $table->json('cambios_nuevos')->nullable()->comment('Valores después del cambio');
            $table->string('direccion_ip', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamp('creado_en')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bitacora');
    }
};
