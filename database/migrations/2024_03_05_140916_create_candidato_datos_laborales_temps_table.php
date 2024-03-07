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
        Schema::create('candidatos_datos_laborales_temp', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->bigIncrements('id');
            $table->string('dpi', 50)->unique();
            $table->text('titulo');
            $table->text('titulo_universitario')->nullable();
            $table->string('colegiado', 10)->nullable();

            /* fks */
            $table->unsignedTinyInteger('colegios_id')->nullable();
            $table->unsignedTinyInteger('registros_academicos_id');

            /* references */
            $table->foreign('colegios_id')->references('id')->on('colegios')->onUpdate('cascade');
            $table->foreign('registros_academicos_id')->references('id')->on('registros_academicos')->onUpdate('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidatos_datos_laborales_temp');
    }
};
