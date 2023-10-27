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
        Schema::create('vehiculos', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->bigIncrements('id');
            $table->string('placa', 10);

            /* fks */
            $table->unsignedTinyInteger('tipos_vehiculos_id');
            $table->unsignedInteger('empleados_id');

            /* references */
            $table->foreign('tipos_vehiculos_id')->references('id')->on('tipos_vehiculos')->onUpdate('cascade');
            $table->foreign('empleados_id')->references('id')->on('empleados')->onUpdate('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehiculos');
    }
};
