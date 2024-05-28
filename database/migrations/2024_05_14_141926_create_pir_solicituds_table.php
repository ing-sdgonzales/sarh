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
        Schema::create('pir_solicitudes', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->bigIncrements('id');
            $table->timestamp('fecha_solicitud');
            $table->timestamp('fecha_aprobacion')->nullable()->default(null);
            $table->unsignedTinyInteger('aprobada')->default(0)->max(1);

            /* fk */
            $table->unsignedTinyInteger('pir_direccion_id');

            /* references */
            $table->foreign('pir_direccion_id')->references('id')->on('pir_direcciones')->onUpdate('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pir_solicitudes');
    }
};
