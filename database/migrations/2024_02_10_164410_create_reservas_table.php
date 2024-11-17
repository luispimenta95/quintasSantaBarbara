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
        Schema::create('reservas', function (Blueprint $table) {
            $table->id();
            $table->date('dataInicial');
            $table->date('dataFinal');
            $table->json('hospedes');
            $table->boolean('reservaConfirmada')->default(false);
            $table->string('camArquivo');
            $table->integer('qtdDias');
            $table->float('valorReserva');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservas');
    }
};
