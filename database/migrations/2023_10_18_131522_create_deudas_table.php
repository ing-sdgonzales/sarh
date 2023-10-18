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
        Schema::create('deudas', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->bigIncrements('id');
            $table->unsignedDecimal('monto', 11, 2);

            /* fks */
            $table->unsignedTinyInteger('tipos_deudas_id');
            $table->unsignedInteger('empleados_id');

            /* references */
            $table->foreign('tipos_deudas_id')->references('id')->on('tipos_deudas')->onUpdate('cascade');
            $table->foreign('empleados_id')->references('id')->on('empleados')->onUpdate('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deudas');
    }
};
