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
        Schema::create('bonos_renglones', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->smallIncrements('id');
            
            /* fks */
            $table->unsignedTinyInteger('renglones_id');
            $table->unsignedTinyInteger('bonificaciones_id');

            /* references */
            $table->foreign('renglones_id')->references('id')->on('renglones')->onUpdate('cascade');
            $table->foreign('bonificaciones_id')->references('id')->on('bonificaciones')->onUpdate('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bonos_renglones');
    }
};
