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
        Schema::create('bajas', function (Blueprint $table) {
            $table->integer('id_baja', true);
            $table->string('descripcion', 45)->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
            $table->integer('id_herramienta')->nullable();
            $table->integer('num_colaborador')->nullable()->index('fk_bajas_colaborador');
            $table->integer('herramienta_id_id')->index('fk_bajas_herramienta_id1_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bajas');
    }
};
