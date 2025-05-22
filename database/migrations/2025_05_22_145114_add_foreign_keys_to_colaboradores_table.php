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
        Schema::table('colaboradores', function (Blueprint $table) {
            $table->foreign(['departamento_id'], 'colaboradores_ibfk_1')->references(['id'])->on('departamentos')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['ambiente_id'], 'colaboradores_ibfk_2')->references(['id'])->on('ambientes')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('colaboradores', function (Blueprint $table) {
            $table->dropForeign('colaboradores_ibfk_1');
            $table->dropForeign('colaboradores_ibfk_2');
        });
    }
};
