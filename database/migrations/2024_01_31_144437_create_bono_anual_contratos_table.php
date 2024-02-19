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
        Schema::create('bonos_anuales_contratos', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->bigIncrements('id');
            $table->text('bono');
            $table->unsignedDecimal('cantidad', 9, 2);
            $table->string('mes', 25);

            /* fks */
            $table->unsignedBigInteger('periodos_contratos_id');

            /* references */
            $table->foreign('periodos_contratos_id')->references('id')->on('periodos_contratos')->onUpdate('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bonos_anuales_contratos');
    }
};
