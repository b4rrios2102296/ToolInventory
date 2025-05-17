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
        Schema::table('reseteo_contraseñas', function (Blueprint $table) {
            $table->foreign(['email'], 'reseteo_contraseñas_ibfk_1')->references(['email'])->on('usuarios')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reseteo_contraseñas', function (Blueprint $table) {
            $table->dropForeign('reseteo_contraseñas_ibfk_1');
        });
    }
};
