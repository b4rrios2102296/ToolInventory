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
        Schema::create('colaboradores', function (Blueprint $table) {
            $table->integer('num_colaborador')->primary();
            $table->string('nombre', 80);
            $table->string('apellidos', 80);
            $table->string('usuario_dominio', 80)->nullable();
            $table->string('email_corporativo', 45)->nullable();
            $table->string('telefono_extension', 45)->nullable();
            $table->integer('departamento_id')->index('departamento_id');
            $table->integer('ambiente_id')->index('ambiente_id');
            $table->string('estatus', 50);
            $table->string('comentarios', 100)->nullable();
            $table->timestamp('creado_en')->useCurrent();
            $table->timestamp('actualizado_en')->useCurrentOnUpdate()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('colaboradores');
    }
};
