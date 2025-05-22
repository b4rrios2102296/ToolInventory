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
            $table->integer('folio', true)->comment('Folio único del resguardo');
            $table->string('estatus', 45)->comment('Activo, Devuelto, Perdido, etc.');
            $table->integer('herramienta_id')->index('herramienta_id');
            $table->integer('colaborador_num')->nullable()->index('colaborador_num');
            $table->integer('aperturo_users_id');
            $table->integer('asigno_users_id');
            $table->integer('usuario_registro_id')->index('usuario_registro_id')->comment('Relación con usuarios');
            $table->integer('cantidad')->comment('Cantidad resguardada');
            $table->string('prioridad', 45)->nullable();
            $table->string('observaciones')->nullable()->comment('Observaciones');
            $table->timestamp('fecha_entrega')->nullable();
            $table->timestamp('fecha_captura')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
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
