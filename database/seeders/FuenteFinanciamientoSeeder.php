<?php

namespace Database\Seeders;

use App\Models\FuenteFinanciamiento;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FuenteFinanciamientoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fuentesData = [
            ['codigo' => '11', 'fuente' => 'Ingresos corrientes'],
            ['codigo' => '21', 'fuente' => 'Recursos triburarios IVA Paz'],
            ['codigo' => '31', 'fuente' => 'Ingresos propios'],
            ['codigo' => '41', 'fuente' => 'Colocaciones internas'],
            ['codigo' => '43', 'fuente' => 'Diminución de caja y bancos de colocaciones internas']

        ];

        foreach ($fuentesData as $fuentes) {
            FuenteFinanciamiento::create([
                'codigo' => $fuentes['codigo'],
                'fuente' => $fuentes['fuente']
            ]);
        }
    }
}
