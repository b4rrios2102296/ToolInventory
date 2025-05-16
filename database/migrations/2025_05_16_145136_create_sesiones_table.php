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
        Schema::create('sesiones', function (Blueprint $table) {
            $table->string('id')->primary()->comment('ID de la sesión');
            $table->integer('usuario_id')->nullable()->index('usuario_id')->comment('Usuario asociado (puede ser nulo)');
            $table->text('payload')->comment('Datos de la sesión');
            $table->integer('ultima_actividad')->comment('Timestamp de última actividad');
            $table->string('direccion_ip', 45)->nullable();
            $table->text('user_agent')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sesiones');
    }
};
