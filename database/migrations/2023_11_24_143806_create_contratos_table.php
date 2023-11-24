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
            $table->string('numoer', 25)->unique();
            $table->date('fecha_inicio')->min('1996-11-11');
            $table->date('fecha_fin');
            $table->unsignedDecimal(9, 2);

            /* fks */
            $table->unsignedInteger('puestos_nominales_id');
            $table->unsignedInteger('empleados_id');

            /* references */
            $table->foreign('puestos_nominales_id')->references('id')->on('puestos_nominales')->onUpdate('cascade');
            $table->foreign('empleados_id')->references('id')->on('empleados')->onUpdate('cascade');
            
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
