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
            $table->string('observaciones')->nullable()->comment('Observaciones');
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
