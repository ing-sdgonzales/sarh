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
        Schema::create('licencias_conducir', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->bigIncrements('id');
            $table->string('licencia', 25);
            $table->date('fecha_vencimiento')->nullable();

            /* fks */
            $table->unsignedTinyInteger('tipos_licencias_id');
            $table->unsignedInteger('empleados_id');

            /* references */
            $table->foreign('tipos_licencias_id')->references('id')->on('tipos_licencias')->onUpdate('cascade');
            $table->foreign('empleados_id')->references('id')->on('empleados')->onUpdate('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('licencias_conducir');
    }
};
