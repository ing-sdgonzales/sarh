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
        Schema::create('contratos', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->bigIncrements('id');
            $table->string('numero', 25)->unique();
            $table->unsignedDecimal('salario', 9, 2);
            $table->string('acuerdo_aprobacion', 15);
            $table->string('acuerdo_rescision', 15)->unique()->nullable();
            $table->string('nit_autorizacion', 25);
            $table->string('fianza', 50)->nullable();
            $table->unsignedTinyInteger('vigente')->min(0)->max(1);

            /* fks */
            $table->unsignedInteger('puestos_nominales_id');
            $table->unsignedInteger('empleados_id');
            $table->unsignedTinyInteger('tipos_contrataciones_id');

            /* references */
            $table->foreign('puestos_nominales_id')->references('id')->on('puestos_nominales')->onUpdate('cascade');
            $table->foreign('empleados_id')->references('id')->on('empleados')->onUpdate('cascade');
            $table->foreign('tipos_contrataciones_id')->references('id')->on('tipos_contrataciones')->onUpdate('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contratos');
    }
};
