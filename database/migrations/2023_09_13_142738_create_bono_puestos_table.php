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
        Schema::create('bonos_puestos', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->bigIncrements('id');
            $table->decimal('bono_calculado')->nullable();

            /* fks */
            $table->unsignedTinyInteger('bonificaciones_id');
            $table->unsignedInteger('puestos_nominales_id');

            /* references */
            $table->foreign('bonificaciones_id')->references('id')->on('bonificaciones')->onUpdate('cascade');
            $table->foreign('puestos_nominales_id')->references('id')->on('puestos_nominales')->onUpdate('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bonos_puestos');
    }
};
