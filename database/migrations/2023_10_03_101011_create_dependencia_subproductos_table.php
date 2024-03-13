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
        Schema::create('dependencias_subproductos', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->integerIncrements('id');

            /* fks */
            $table->unsignedTinyInteger('dependencias_nominales_id');
            $table->unsignedTinyInteger('subproductos_id');

            /* references */
            $table->foreign('dependencias_nominales_id')->references('id')->on('dependencias_nominales')->onUpdate('cascade');
            $table->foreign('subproductos_id')->references('id')->on('subproductos')->onUpdate('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dependencias_subproductos');
    }
};
