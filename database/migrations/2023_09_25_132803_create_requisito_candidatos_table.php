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
        Schema::create('requisitos_candidatos', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->bigIncrements('id');
            $table->text('ubicacion');
            $table->text('observacion')->nullable();
            $table->unsignedTinyInteger('valido')->default(0);
            $table->unsignedTinyInteger('revisado')->default(0);
            $table->timestamp('fecha_carga', 0)->default(date("Y-m-d h:i:s"));
            $table->timestamp('fecha_revision', 0)->nullable();

            /* fks */
            $table->unsignedInteger('candidatos_id');
            $table->unsignedInteger('puestos_nominales_id');
            $table->unsignedSmallInteger('requisitos_id');

            /* references */
            $table->foreign('candidatos_id')->references('id')->on('candidatos')->onUpdate('cascade');
            $table->foreign('puestos_nominales_id')->references('id')->on('puestos_nominales')->onUpdate('cascade');
            $table->foreign('requisitos_id')->references('id')->on('requisitos')->onUpdate('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requisitos_candidatos');
    }
};
