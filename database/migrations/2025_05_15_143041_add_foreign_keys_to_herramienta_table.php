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
        Schema::table('herramienta', function (Blueprint $table) {
            $table->foreign(['resguardo_folio'], 'fk_herramienta_resguardo1')->references(['folio'])->on('resguardo')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('herramienta', function (Blueprint $table) {
            $table->dropForeign('fk_herramienta_resguardo1');
        });
    }
};
