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
        Schema::create('logs_sistema', function (Blueprint $table) {
            $table->integer('id_log', true);
            $table->integer('usuario_id')->nullable()->index('fk_log_usuario');
            $table->string('accion');
            $table->string('modulo', 100)->nullable();
            $table->text('detalles')->nullable();
            $table->string('ip_origen', 45)->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logs_sistema');
    }
};
