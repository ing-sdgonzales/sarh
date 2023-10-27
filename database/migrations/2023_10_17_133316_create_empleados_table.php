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
        Schema::create('empleados', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->integerIncrements('id');
            $table->string('nit', 25)->unique();
            $table->string('igss', 25)->unique()->nullable();
            $table->text('imagen');
            $table->string('nombres', 50);
            $table->string('apellidos', 50);
            $table->string('email')->unique();
            $table->date('fecha_ingreso')->nullable();
            $table->date('fecha_nacimiento');
            $table->text('direccion');
            $table->string('cuenta_banco', 50)->nullable();
            $table->date('fecha_retiro')->nullable();
            $table->unsignedTinyInteger('estado')->default(0);
            $table->unsignedTinyInteger('estado_familiar')->nullable();
            $table->unsignedDecimal('pretension_salarial', 9, 2);
            $table->mediumText('observaciones')->nullable();
            $table->unsignedTinyInteger('estudia_actualmente');
            $table->text('estudio_actual')->nullable();
            $table->unsignedTinyInteger('cantidad_personas_dependientes');
            $table->unsignedTinyInteger('ingresos_adicionales');
            $table->unsignedDecimal('monto_ingreso_total', 9, 2)->nullable();
            $table->unsignedTinyInteger('posee_deudas');
            $table->unsignedTinyInteger('trabajo_conred');
            $table->unsignedTinyInteger('trabajo_estado');
            $table->unsignedTinyInteger('jubilado_estado');
            $table->text('institucion_jubilacion')->nullable();
            $table->string('personas_aportan_ingresos', 100)->nullable();
            $table->string('fuente_ingresos_adicionales', 50)->nullable();
            $table->unsignedDecimal('pago_vivienda', 9, 2);

            /* fks */
            $table->unsignedTinyInteger('generos_id')->nullable();
            $table->unsignedTinyInteger('etnias_id');
            $table->unsignedTinyInteger('grupos_sanguineos_id');
            $table->unsignedTinyInteger('dependencias_funcionales_id')->nullable();
            $table->unsignedSmallInteger('municipios_id');
            $table->unsignedTinyInteger('nacionalidades_id');
            $table->unsignedTinyInteger('tipos_viviendas_id');
            $table->unsignedTinyInteger('estados_civiles_id');
            $table->unsignedInteger('candidatos_id')->nullable();

            /* references */
            $table->foreign('generos_id')->references('id')->on('generos')->onUpdate('cascade');
            $table->foreign('etnias_id')->references('id')->on('etnias')->onUpdate('cascade');
            $table->foreign('grupos_sanguineos_id')->references('id')->on('grupos_sanguineos')->onUpdate('cascade');
            $table->foreign('dependencias_funcionales_id')->references('id')->on('dependencias_funcionales')->onUpdate('cascade');
            $table->foreign('municipios_id')->references('id')->on('municipios')->onUpdate('cascade');
            $table->foreign('nacionalidades_id')->references('id')->on('nacionalidades')->onUpdate('cascade');
            $table->foreign('tipos_viviendas_id')->references('id')->on('tipos_viviendas')->onUpdate('cascade');
            $table->foreign('estados_civiles_id')->references('id')->on('estados_civiles')->onUpdate('cascade');
            $table->foreign('candidatos_id')->references('id')->on('candidatos')->onUpdate('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empleados');
    }
};
