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
        Schema::create('resguardo', function (Blueprint $table) {
            $table->integer('folio', true);
            $table->string('estatus', 45)->nullable();
            $table->integer('aperturo_users_id');
            $table->string('prioridad', 45)->nullable();
            $table->integer('asignado_users_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
            $table->date('deliver_date')->nullable();
            $table->integer('colaborador_num_colaborador')->index('idx_colaborador_id');
            $table->binary('detalles_resguardo')->nullable();
            $table->string('comentarios')->nullable();
            $table->string('url')->nullable();
            $table->integer('herramienta_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resguardo');
    }
};
