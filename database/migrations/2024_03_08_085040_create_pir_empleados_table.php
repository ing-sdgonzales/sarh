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
        Schema::create('pir_empleados', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->integerIncrements('id');
            $table->text('nombre');
            $table->text('observacion')->nullable();

            /* fks */
            $table->unsignedTinyInteger('pir_direccion_id');
            $table->unsignedTinyInteger('pir_grupo_id')->default(1);
            $table->unsignedTinyInteger('pir_reporte_id')->default(1);
            $table->unsignedTinyInteger('renglon_id');

            /* references */
            $table->foreign('pir_direccion_id')->references('id')->on('pir_direcciones')->onUpdate('cascade');
            $table->foreign('pir_grupo_id')->references('id')->on('pir_grupos')->onUpdate('cascade');
            $table->foreign('pir_reporte_id')->references('id')->on('pir_reportes')->onUpdate('cascade');
            $table->foreign('renglon_id')->references('id')->on('renglones')->onUpdate('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pir_empleados');
    }
};
