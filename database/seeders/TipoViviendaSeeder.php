<?php

namespace Database\Seeders;

use App\Models\TipoVivienda;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoViviendaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipos_viviendas = ['Alquilada', 'Propia'];

        foreach ($tipos_viviendas as $tipo_vivienda) {
            TipoVivienda::create([
                'tipo_vivienda' => $tipo_vivienda
            ]);
        }
    }
}
