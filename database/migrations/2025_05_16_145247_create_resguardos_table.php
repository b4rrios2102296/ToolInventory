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
            $table->integer('folio', true);
            $table->integer('herramienta_id')->index('herramienta_id');
            $table->integer('num_colaborador')->index('num_colaborador');
            $table->integer('usuario_apertura_id');
            $table->integer('usuario_asignado_id');
            $table->timestamp('fecha_entrega')->nullable();
            $table->string('estatus', 45);
            $table->string('prioridad', 45)->nullable();
            $table->text('detalles')->nullable();
            $table->string('comentarios')->nullable();
            $table->text('accesorios_extra')->nullable();
            $table->string('url_documento')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
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
