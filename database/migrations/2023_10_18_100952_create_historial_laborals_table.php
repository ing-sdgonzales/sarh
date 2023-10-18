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
        Schema::create('historiales_laborales', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            
            $table->bigIncrements('id');
            $table->text('empresa');
            $table->text('direccion');
            $table->string('telefono', 15);
            $table->text('jefe_inmediato');
            $table->string('cargo', 50);
            $table->date('desde');
            $table->date('hasta');
            $table->decimal('ultimo_suelto', 9, 2);
            $table->text('motivo_salida');
            $table->unsignedTinyInteger('verificar_informacion');
            $table->text('razon_informacion')->nullable();

            /* fks */
            $table->unsignedInteger('empleados_id');

            /* references */
            $table->foreign('empleados_id')->references('id')->on('empleados')->onUpdate('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historiales_laborales');
    }
};
