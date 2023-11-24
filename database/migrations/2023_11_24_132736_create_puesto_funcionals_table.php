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
        Schema::create('puestos_funcionales', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->integerIncrements('id');
            $table->text('puesto');

            /* fks */
            $table->unsignedTinyInteger('dependencias_funcionales_id');

            /* references */
            $table->foreign('dependencias_funcionales_id')->references('id')->on('dependencias_funcionales')->onUpdate('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('puestos_funcionales');
    }
};
