<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up() : void
    {
        Schema::create('pacientes', function (Blueprint $table) {
            $table->id();
            $table->string('Codigo_Paciente')->unique();
            $table->string('Nome');
            $table->string('CEP');
            $table->string('Logradouro');
            $table->string('Bairro');
            $table->string('UF');
            $table->string('numero_casa');
            $table->string('complemento');
            $table->date('Data_Nascimento');
            $table->string('Telefone');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_pacientes');
    }
};
