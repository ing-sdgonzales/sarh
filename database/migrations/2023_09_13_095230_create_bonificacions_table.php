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
        Schema::create('bonificaciones', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->tinyIncrements('id');
            $table->string('bono');
            $table->unsignedDecimal('cantidad', 9, 2);
            $table->unsignedTinyInteger('calculado')->min(0)->max(1);

            /* fks */
            $table->unsignedTinyInteger('tipos_bonificaciones_id');

            /* references */
            $table->foreign('tipos_bonificaciones_id')->references('id')->on('tipos_bonificaciones')->onUpdate('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bonificaciones');
    }
};
