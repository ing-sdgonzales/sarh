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
        Schema::create('historias_clinicas', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->integerIncrements('id');
            $table->unsignedTinyInteger('padecimiento_salud');
            $table->string('tipo_enfermedad', 50)->nullable();
            $table->unsignedTinyInteger('intervencion_quirurgica');
            $table->string('tipo_intervencion', 50)->nullable();
            $table->unsignedTinyInteger('sufrido_accidente');
            $table->string('tipo_accidente', 50)->nullable();
            $table->unsignedTinyInteger('alergia_medicamento');
            $table->string('tipo_medicamento', 50)->nullable();

            /* fks */
            $table->unsignedInteger('empleados_id');

            /* references */
            $table->foreign('empleados_id')->references('id')->on('empleados')->onUpdate('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historias_clinicas');
    }
};
