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
            $table->decimal('asignado', 11, 2);
            $table->decimal('modificaciones', 11, 2);
            $table->decimal('vigente', 11, 2);
            $table->decimal('pre_comprometido', 11, 2);
            $table->decimal('comprometido', 11, 2);
            $table->decimal('devengado', 11, 2);
            $table->decimal('pagado', 11, 2);
            $table->decimal('saldo_por_comprometer', 11, 2);
            $table->decimal('saldo_por_devengar', 11, 2);
            $table->decimal('saldo_por_pagar', 11, 2);
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
