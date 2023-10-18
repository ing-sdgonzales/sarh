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
        Schema::create('renglones', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->tinyIncrements('id');
            $table->string('renglon', 5);
            $table->text('nombre');
            $table->unsignedDecimal('asignado', 11, 2);
            $table->unsignedDecimal('modificaciones', 11, 2);
            $table->unsignedDecimal('vigente', 11, 2);
            $table->unsignedDecimal('pre_comprometido', 11, 2);
            $table->unsignedDecimal('comprometido', 11, 2);
            $table->unsignedDecimal('devengado', 11, 2);
            $table->unsignedDecimal('pagado', 11, 2);
            $table->unsignedDecimal('saldo_por_comprometer', 11, 2);
            $table->unsignedDecimal('saldo_por_devengar', 11, 2);
            $table->unsignedDecimal('saldo_por_pagar', 11, 2);
            $table->unsignedTinyInteger('tipo');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('renglones');
    }
};
