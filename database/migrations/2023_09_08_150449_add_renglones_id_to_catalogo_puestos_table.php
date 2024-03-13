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
        Schema::table('catalogo_puestos', function (Blueprint $table) {
            /* fks */
            $table->unsignedTinyInteger('renglones_id')->after('puesto');

            /* references */
            $table->foreign('renglones_id')->references('id')->on('renglones')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('catalogo_puestos', function (Blueprint $table) {
            //
        });
    }
};
