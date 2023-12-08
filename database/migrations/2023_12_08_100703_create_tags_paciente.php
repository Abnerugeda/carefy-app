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
        Schema::create('tags_paciente', function (Blueprint $table) {
            $table->id();
            $table->string('Codigo_Tag');
            $table->string('Codigo_Paciente');
            $table->timestamps();

            $table->foreign('Codigo_Tag')->references('Codigo_Tag')->on('tags')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('Codigo_Paciente')->references('Codigo_Paciente')->on('pacientes')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tags_paciente');
    }
};
