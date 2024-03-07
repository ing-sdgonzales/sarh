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
        Schema::create('candidatos_datos_personales_temp', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->bigIncrements('id');
            $table->text('imagen');
            $table->string('dpi', 50)->unique();
            $table->string('nit', 15)->unique();
            $table->string('igss', 15)->nullable();
            $table->text('nombre');
            $table->string('email', 50)->unique();
            $table->date('fecha_nacimiento');
            $table->string('telefono', 15)->unique();
            $table->text('direccion');

            /* fks */
            $table->unsignedTinyInteger('estados_civiles_id');
            $table->unsignedSmallInteger('municipios_id');

            /* references */
            $table->foreign('estados_civiles_id')->references('id')->on('estados_civiles')->onUpdate('cascade');
            $table->foreign('municipios_id')->references('id')->on('municipios')->onUpdate('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidatos_datos_personales_temp');
    }
};
