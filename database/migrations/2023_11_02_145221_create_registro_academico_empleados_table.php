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
        Schema::create('registros_academicos_empleados', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->bigIncrements('id');
            $table->text('establecimiento');
            $table->text('titulo');

            /* fks */
            $table->unsignedTinyInteger('registros_academicos_id');
            $table->unsignedInteger('empleados_id');

            /* references */
            $table->foreign('registros_academicos_id')->references('id')->on('registros_academicos')->onUpdate('cascade');
            $table->foreign('empleados_id')->references('id')->on('empleados')->onUpdate('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registros_academicos_empleados');
    }
};
