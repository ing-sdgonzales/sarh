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
        Schema::create('aplicaciones_candidatos', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->integerIncrements('id');
            $table->text('observacion');
            $table->date('fecha_aplicacion');

            /* fks */
            $table->unsignedInteger('candidatos_id');
            $table->unsignedInteger('puestos_nominales_id');
            $table->unsignedTinyInteger('etapas_aplicaciones_id');

            /* references */
            $table->foreign('candidatos_id')->references('id')->on('candidatos')->onUpdate('cascade');
            $table->foreign('puestos_nominales_id')->references('id')->on('puestos_nominales')->onUpdate('cascade');
            $table->foreign('etapas_aplicaciones_id')->references('id')->on('etapas_aplicaciones')->onUpdate('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aplicacion_candidatos');
    }
};
