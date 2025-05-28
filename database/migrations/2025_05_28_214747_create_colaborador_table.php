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
            $table->decimal('claveColab', 18, 0)->nullable();
            $table->string('nombreCompleto', 152)->nullable();
            $table->string('Estado', 1)->nullable();
            $table->string('Tipo', 1)->nullable();
            $table->string('Puesto')->nullable();
            $table->string('Area', 63)->nullable();
            $table->string('Sucursal', 63)->nullable();
            $table->char('req_checar', 1)->nullable();
            $table->char('perm_checar', 1)->nullable();
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
