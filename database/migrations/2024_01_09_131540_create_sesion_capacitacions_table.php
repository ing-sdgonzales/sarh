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
        Schema::create('sesiones_capacitaciones', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->bigIncrements('id');
            $table->date('fecha');
            $table->time('hora_inicio', 0);
            $table->time('hora_fin', 0);
            $table->text('ubicacion');
            
            /* fks */
            $table->unsignedBigInteger('capacitaciones_id');

            /* references */
            $table->foreign('capacitaciones_id')->references('id')->on('capacitaciones')->onUpdate('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sesiones_capacitaciones');
    }
};
