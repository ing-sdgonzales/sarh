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
        Schema::create('informes_evaluaciones', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->integerIncrements('id');
            $table->timestamp('fecha_carga', 0)->default(date('Y-m-d H:i:s'));
            $table->text('ubicacion');

            /* fks */
            $table->unsignedInteger('aplicaciones_candidatos_id');

            /* references */
            $table->foreign('aplicaciones_candidatos_id')->references('id')->on('aplicaciones_candidatos')->onUpdate('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('informes_evaluaciones');
    }
};
