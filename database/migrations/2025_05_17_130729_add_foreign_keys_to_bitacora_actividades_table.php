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
        Schema::table('bitacora_actividades', function (Blueprint $table) {
            $table->foreign(['usuario_id'], 'bitacora_actividades_ibfk_1')->references(['id'])->on('usuarios')->onUpdate('restrict')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bitacora_actividades', function (Blueprint $table) {
            $table->dropForeign('bitacora_actividades_ibfk_1');
        });
    }
};
