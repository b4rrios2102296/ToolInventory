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
            $table->binary('detalles_resguardo')->nullable();
            $table->string('comentarios', 191)->nullable()->comment('Observaciones');
            $table->integer('aperturo_users_id');
            $table->integer('asigno_users_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
            $table->timestamp('fecha_captura')->nullable();
            $table->integer('colaborador_num')->nullable()->index('colaborador_num');
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
