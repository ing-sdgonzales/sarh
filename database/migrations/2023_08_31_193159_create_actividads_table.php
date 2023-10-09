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
        Schema::create('actividades', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            
            $table->tinyIncrements('id');
            $table->string('codigo', 5);
            $table->text('actividad');

            /* fks */
            $table->unsignedTinyInteger('programas_id');

            /* references */
            $table->foreign('programas_id')->references('id')->on('programas')->onUpdate('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('actividades');
    }
};
