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
        Schema::table('rol_permisos', function (Blueprint $table) {
            $table->foreign(['rol_id'], 'rol_permisos_ibfk_1')->references(['id'])->on('roles')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['permiso_id'], 'rol_permisos_ibfk_2')->references(['id'])->on('permisos')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rol_permisos', function (Blueprint $table) {
            $table->dropForeign('rol_permisos_ibfk_1');
            $table->dropForeign('rol_permisos_ibfk_2');
        });
    }
};
