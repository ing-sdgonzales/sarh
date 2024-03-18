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
        Schema::create('pir_puestos', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->integerIncrements('id');

            /* fks */
            $table->unsignedTinyInteger('catalogo_puesto_id');
            $table->unsignedInteger('pir_empleado_id');

            /* references */
            $table->foreign('catalogo_puesto_id')->references('id')->on('catalogo_puestos')->onUpdate('cascade');
            $table->foreign('pir_empleado_id')->references('id')->on('pir_empleados')->onUpdate('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pir_puestos');
    }
};
