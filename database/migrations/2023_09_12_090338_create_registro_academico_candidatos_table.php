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
        Schema::create('registros_academicos_candidatos', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->integerIncrements('id');
            $table->unsignedTinyInteger('estado');
            $table->text('profesion');

            /* fks */
            $table->unsignedInteger('candidatos_id');
            $table->unsignedTinyInteger('registros_academicos_id');

            /* references */
            $table->foreign('candidatos_id')->references('id')->on('candidatos')->onUpdate('cascade');
            $table->foreign('registros_academicos_id')->references('id')->on('registros_academicos')->onUpdate('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registros_academicos_candidatos');
    }
};
