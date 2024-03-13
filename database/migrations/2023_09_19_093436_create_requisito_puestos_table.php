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
        Schema::create('requisitos_puestos', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->integerIncrements('id');

            /* fks */
            $table->unsignedSmallInteger('requisitos_id');
            $table->unsignedInteger('puestos_nominales_id');

            /* references */
            $table->foreign('requisitos_id')->references('id')->on('requisitos')->onUpdate('cascade');
            $table->foreign('puestos_nominales_id')->references('id')->on('puestos_nominales')->onUpdate('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requisitos_puestos');
    }
};
