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
        Schema::create('capacitaciones', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->bigIncrements('id');
            $table->text('capacitacion');
            $table->string('capacitador', 100);

            /* fks */
            $table->unsignedTinyInteger('dependencias_nominales_id');

            /* references */
            $table->foreign('dependencias_nominales_id')->references('id')->on('dependencias_nominales')->onUpdate('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('capacitaciones');
    }
};
