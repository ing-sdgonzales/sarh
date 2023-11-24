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
        Schema::create('registros_puestos', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->bigIncrements('id');
            $table->text('observacion')->nullable();

            /* fks */
            $table->unsignedBigInteger('contratos_id');
            $table->unsignedInteger('puestos_nominales_id');
            $table->unsignedTinyInteger('tipos_contrataciones_id');
            $table->unsignedInteger('puestos_funcionales_id');
            $table->unsignedTinyInteger('dependencias_funcionales_id');

            /* references */
            $table->foreign('contratos_id')->references('id')->on('contratos')->onUpdate('cascade');
            $table->foreign('puestos_nominales_id')->references('id')->on('puestos_nominales')->onUpdate('cascade');
            $table->foreign('tipos_contrataciones_id')->references('id')->on('tipos_contrataciones')->onUpdate('cascade');
            $table->foreign('puestos_funcionales_id')->references('id')->on('puestos_funcionales')->onUpdate('cascade');
            $table->foreign('dependencias_funcionales_id')->references('id')->on('dependencias_funcionales')->onUpdate('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registros_puestos');
    }
};
