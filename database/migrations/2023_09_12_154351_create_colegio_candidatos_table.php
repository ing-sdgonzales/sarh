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
        Schema::create('colegios_candidatos', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->integerIncrements('id');
            $table->string('colegiado', 10);
            $table->text('profesion');
            
            /* fks */
            $table->unsignedInteger('candidatos_id');
            $table->unsignedTinyInteger('colegios_id');

            /* references */
            $table->foreign('candidatos_id')->references('id')->on('candidatos')->onUpdate('cascade');
            $table->foreign('colegios_id')->references('id')->on('colegios')->onUpdate('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('colegios_candidatos');
    }
};
