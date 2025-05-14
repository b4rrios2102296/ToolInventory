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
        Schema::table('colaborador', function (Blueprint $table) {
            $table->foreign(['ambiente_id_ambiente'], 'fk_colab_ambiente')->references(['id_ambiente'])->on('ambiente')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['asignacion_id_asignacion'], 'fk_colab_asignacion')->references(['id_asignacion'])->on('asignacion')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['departamento_id_departamento'], 'fk_colab_departamento')->references(['id_departamento'])->on('departamento')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('colaborador', function (Blueprint $table) {
            $table->dropForeign('fk_colab_ambiente');
            $table->dropForeign('fk_colab_asignacion');
            $table->dropForeign('fk_colab_departamento');
        });
    }
};
