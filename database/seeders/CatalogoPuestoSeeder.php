<?php

namespace Database\Seeders;

use App\Models\CatalogoPuesto;
use App\Models\Renglon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CatalogoPuestoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $puestosData = [
            ['codigo' => '71736', 'puesto' => 'Secretario Ejecutivo'],
            ['codigo' => '71747', 'puesto' => 'Subsecretario de Gestión de Reducción de Riesgo'],
            ['codigo' => '71802', 'puesto' => 'Subsecretario de Coordinación y Administración'],
            ['codigo' => '74986', 'puesto' => 'Peón Vigilante I'],
            ['codigo' => '74987', 'puesto' => 'Peón Vigilante V'],
            ['codigo' => '74191', 'puesto' => 'Asesor']
        ];

        foreach ($puestosData as $puestos) {
            CatalogoPuesto::create([
                'codigo' => $puestos['codigo'],
                'puesto' => $puestos['puesto'],
                /* 'renglones_id' => $puestos['renglones_id'] */
            ]);
        }
    }
}
