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
        Schema::create('colaborador', function (Blueprint $table) {
            $table->integer('num_colaborador', true);
            $table->string('nombre', 80)->nullable();
            $table->string('apellidos', 80)->nullable();
            $table->string('usuario_dominio', 80)->nullable();
            $table->string('email_coorporativo', 45)->nullable();
            $table->string('tel_ext', 45)->nullable();
            $table->integer('asignacion_id_asignacion')->index('idx_asignacion_id');
            $table->integer('departamento_id_departamento')->index('idx_departamento_id');
            $table->integer('ambiente_id_ambiente')->index('idx_ambiente_id');
            $table->string('ext', 45)->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
            $table->string('estatus_colaborador', 50)->nullable();
            $table->string('comentario_colaborador', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('colaborador');
    }
};
