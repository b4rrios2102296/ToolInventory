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
        Schema::create('resguardos', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('folio', 20)->unique('folio')->comment('Folio único del resguardo');
            $table->integer('herramienta_id')->index('herramienta_id');
            $table->integer('colaborador_num')->index('colaborador_num')->comment('Relación con colaboradores');
            $table->integer('usuario_registro_id')->index('usuario_registro_id')->comment('Relación con usuarios');
            $table->integer('cantidad')->comment('Cantidad resguardada');
            $table->timestamp('fecha_entrega')->nullable();
            $table->timestamp('fecha_devolucion')->nullable();
            $table->string('estatus', 45)->comment('Activo, Devuelto, Perdido, etc.');
            $table->string('prioridad', 45)->nullable()->comment('Alta, Media, Baja');
            $table->string('condiciones', 100)->nullable()->comment('Estado al entregar');
            $table->string('comentarios')->nullable()->comment('Observaciones');
            $table->string('evidencia_fotografica', 191)->nullable()->comment('URL de foto');
            $table->timestamp('creado_en')->useCurrent();
            $table->timestamp('actualizado_en')->useCurrentOnUpdate()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resguardos');
    }
};
