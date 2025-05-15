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
        Schema::table('historial_resguardos', function (Blueprint $table) {
            $table->foreign(['herramienta_id'], 'fk_historial_herramienta')->references(['id'])->on('herramienta')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['resguardo_folio'], 'fk_historial_resguardo')->references(['folio'])->on('resguardo')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['usuario_id'], 'fk_historial_usuario')->references(['id'])->on('users')->onUpdate('restrict')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('historial_resguardos', function (Blueprint $table) {
            $table->dropForeign('fk_historial_herramienta');
            $table->dropForeign('fk_historial_resguardo');
            $table->dropForeign('fk_historial_usuario');
        });
    }
};
