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
        Schema::create('puestos_nominales', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->integerIncrements('id');
            $table->string('codigo', 50)->unique();
            $table->text('partida_presupuestaria');
            $table->unsignedTinyInteger('estado');
            $table->string('cod_unidad_ejecutora')->default('1114-0029-000-00');
            /* $table->string('codigo_geografico', 5); */
            $table->unsignedTinyInteger('financiado');
            $table->unsignedDecimal('salario', 9, 2);
            $table->date('fecha_registro');

            /* fks */
            $table->unsignedSmallInteger('especialidades_id');
            $table->unsignedTinyInteger('renglones_id');
            $table->unsignedTinyInteger('plazas_id');
            $table->unsignedTinyInteger('fuentes_financiamientos_id');
            $table->unsignedTinyInteger('dependencias_nominales_id');
            $table->unsignedSmallInteger('municipios_id');
            $table->unsignedTinyInteger('catalogo_puestos_id');
            $table->unsignedTinyInteger('tipos_servicios_id');

            /* references */
            $table->foreign('especialidades_id')->references('id')->on('especialidades')->onUpdate('cascade');
            $table->foreign('renglones_id')->references('id')->on('renglones')->onUpdate('cascade');
            $table->foreign('plazas_id')->references('id')->on('plazas')->onUpdate('cascade');
            $table->foreign('fuentes_financiamientos_id')->references('id')->on('fuentes_financiamientos')->onUpdate('cascade');
            $table->foreign('dependencias_nominales_id')->references('id')->on('dependencias_nominales')->onUpdate('cascade');
            $table->foreign('municipios_id')->references('id')->on('municipios')->onUpdate('cascade');
            $table->foreign('catalogo_puestos_id')->references('id')->on('catalogo_puestos')->onUpdate('cascade');
            $table->foreign('tipos_servicios_id')->references('id')->on('tipos_servicios')->onUpdate('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('puestos_nominales');
    }
};
