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
        Schema::create('etapas_aplicaciones', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->bigIncrements('id');
            $table->date('fecha_inicio')->default(date('Y-m-d H:i:s'));
            $table->date('fecha_fin')->default(null)->nullable();

            /* fks */
            $table->unsignedTinyInteger('etapas_procesos_id')->default(1);
            $table->unsignedInteger('aplicaciones_candidatos_id');

            /* references */
            $table->foreign('etapas_procesos_id')->references('id')->on('etapas_procesos')->onUpdate('cascade');
            $table->foreign('aplicaciones_candidatos_id')->references('id')->on('aplicaciones_candidatos')->onUpdate('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('etapas_aplicaciones');
    }
};
