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
        Schema::create('hospedes', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->date('nascimento');
            $table->string('cpf')->unique()->nullable()->comment('CPF do hóspede, pode ser nulo se não for brasileiro');
            $table->string('email')->nullable()->comment('Email do hóspede, pode ser nulo se não for fornecido');
            $table->string('telefone')->nullable()->comment('Telefone do hóspede, pode ser nulo se não for fornecido');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hospedes');
    }
};
