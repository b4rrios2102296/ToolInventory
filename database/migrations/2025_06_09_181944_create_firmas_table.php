<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('firmas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('resguardo_id'); // Relación con el resguardo
            $table->string('firmado_por'); // Entregado o Recibido
            $table->text('firma_base64'); // Firma en formato Base64
            $table->timestamps();

            $table->foreign('resguardo_id')->references('id')->on('resguardos')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('firmas');
    }
};
