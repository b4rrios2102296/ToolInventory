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
            $table->integer('departamento_id')->index('departamento_id');
            $table->integer('ambiente_id')->index('ambiente_id');
            $table->string('estatus', 50);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
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
