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
        Schema::create('referencias_personales', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->bigIncrements('id');
            $table->text('nombre');
            $table->text('lugar_trabajo');
            $table->string('telefono', 15);
            
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
        Schema::dropIfExists('referencias_personales');
    }
};
