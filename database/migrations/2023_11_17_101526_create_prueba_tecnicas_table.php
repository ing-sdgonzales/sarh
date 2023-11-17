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
        Schema::create('pruebas_tecnicas', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->integerIncrements('id');
            $table->string('prueba', 50)->default('Prueba técnica');
            $table->unsignedTinyInteger('nota')->min(0)->max(100);
            $table->date('fecha')->default(date('Y-m-d'));

            /* fks */
            $table->unsignedInteger('candidatos_id');

            /* references */
            $table->foreign('candidatos_id')->references('id')->on('candidatos')->onUpdate('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prueba_tecnicas');
    }
};
