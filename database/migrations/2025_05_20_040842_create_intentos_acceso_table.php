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
        Schema::create('intentos_acceso', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('usuario_id')->nullable()->index('usuario_id')->comment('Puede ser nulo si el usuario no existe');
            $table->string('nombre_usuario', 50)->nullable()->comment('Usuario intentado');
            $table->boolean('exito')->comment('Indica si el acceso fue exitoso');
            $table->string('direccion_ip', 45);
            $table->text('user_agent')->nullable()->comment('Navegador y sistema operativo usado');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('intentos_acceso');
    }
};
