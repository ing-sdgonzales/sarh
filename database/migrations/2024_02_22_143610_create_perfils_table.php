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
        Schema::create('perfiles', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->integerIncrements('id');
            $table->longText('descripcion');
            $table->text('experiencia');
            $table->text('disponibilidad');
            $table->text('estudios');

            /* fks */
            $table->unsignedTinyInteger('registros_academicos_id');
            $table->unsignedInteger('puestos_nominales_id');

            /* references */
            $table->foreign('registros_academicos_id')->references('id')->on('registros_academicos')->onUpdate('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perfiles');
    }
};
