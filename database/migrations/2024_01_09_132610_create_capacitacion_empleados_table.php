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
        Schema::create('capacitaciones_empleados', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->bigIncrements('id');

            /* fks */
            $table->unsignedInteger('empleados_id');
            $table->unsignedBigInteger('sesiones_capacitaciones_id');

            /* references */
            $table->foreign('empleados_id')->references('id')->on('empleados')->onUpdate('cascade');
            $table->foreign('sesiones_capacitaciones_id')->references('id')->on('sesiones_capacitaciones')->onUpdate('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('capacitaciones_empleados');
    }
};
