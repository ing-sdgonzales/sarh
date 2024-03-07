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
        Schema::create('candidatos', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->integerIncrements('id');
            $table->string('dpi', 50)->unique();
            $table->string('nit', 15)->unique();
            $table->string('igss', 15)->nullable();
            $table->text('nombre');
            $table->string('email', 50)->unique();
            $table->text('imagen');
            $table->date('fecha_nacimiento');
            $table->date('fecha_registro');
            $table->date('fecha_ingreso')->default(null)->nullable();
            $table->text('direccion');
            $table->unsignedTinyInteger('estado')->default(0);
            $table->unsignedTinyInteger('aprobado')->default(0);
            $table->unsignedTinyInteger('contratado')->default(0);

            /* fks */
            $table->unsignedTinyInteger('estados_civiles_id');
            $table->unsignedSmallInteger('municipios_id');
            $table->unsignedTinyInteger('tipos_contrataciones_id');

            /* references */
            $table->foreign('estados_civiles_id')->references('id')->on('estados_civiles')->onUpdate('cascade');
            $table->foreign('municipios_id')->references('id')->on('municipios')->onUpdate('cascade');
            $table->foreign('tipos_contrataciones_id')->references('id')->on('tipos_contrataciones')->onUpdate('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidatos');
    }
};
