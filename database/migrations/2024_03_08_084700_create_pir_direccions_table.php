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
        Schema::create('pir_direcciones', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->tinyIncrements('id');
            $table->text('direccion');
            $table->dateTime('hora_actualizacion');
            $table->unsignedTinyInteger('habilitado')->default(1);

            /* fks */
            $table->unsignedTinyInteger('pir_seccion_id')->nullable();

            /* references */
            $table->foreign('pir_seccion_id')->references('id')->on('pir_secciones')->onUpdate('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pir_direcciones');
    }
};
