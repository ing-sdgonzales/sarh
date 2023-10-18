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
        Schema::create('idiomas', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->bigIncrements('id');
            $table->string('idioma', 50);
            $table->unsignedInteger('lee')->min(0)->max(100);
            $table->unsignedTinyInteger('habla')->min(0)->max(100);
            $table->unsignedTinyInteger('escribe')->min(0)->max(100);

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
        Schema::dropIfExists('idiomas');
    }
};
