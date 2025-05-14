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
        Schema::table('bajas', function (Blueprint $table) {
            $table->foreign(['num_colaborador'], 'fk_bajas_colaborador')->references(['num_colaborador'])->on('colaborador')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['herramienta_id_id'], 'fk_bajas_herramienta_id1')->references(['id'])->on('herramienta_id')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bajas', function (Blueprint $table) {
            $table->dropForeign('fk_bajas_colaborador');
            $table->dropForeign('fk_bajas_herramienta_id1');
        });
    }
};
