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
        Schema::table('resguardos', function (Blueprint $table) {
            $table->foreign(['herramienta_id'], 'resguardos_ibfk_1')->references(['GVRMT'])->on('herramientas')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['usuario_registro_id'], 'resguardos_ibfk_3')->references(['id'])->on('usuarios')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('resguardos', function (Blueprint $table) {
            $table->dropForeign('resguardos_ibfk_1');
            $table->dropForeign('resguardos_ibfk_3');
        });
    }
};
