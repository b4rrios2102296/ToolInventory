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
        Schema::create('usuarios', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('numero_colaborador')->nullable()->unique('numero_colaborador')->comment('Número de colaborador/nómina');
            $table->string('nombre', 50);
            $table->string('apellidos', 100);
            $table->string('nombre_usuario', 50)->unique('nombre_usuario');
            $table->string('email', 100)->unique('email');
            $table->string('contraseña_hash');
            $table->integer('rol_id')->index('rol_id');
            $table->boolean('activo')->nullable()->default(true)->comment('Indica si el usuario está activo o no');
            $table->timestamp('ultimo_acceso')->nullable()->comment('Fecha y hora del último inicio de sesión');
            $table->string('token_remember', 100)->nullable()->comment('Token para recordar sesión');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
