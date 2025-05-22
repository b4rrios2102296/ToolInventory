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
        Schema::create('permisos', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('clave', 50)->unique('clave')->comment('Clave única del permiso (ej. gestionar_usuarios)');
            $table->string('nombre', 100)->comment('Nombre descriptivo del permiso');
            $table->string('descripcion')->nullable()->comment('Explicación detallada del permiso');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
            $table->integer('usuario_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permisos');
    }
};
