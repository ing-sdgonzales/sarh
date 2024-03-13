<?php

namespace Database\Seeders;

use App\Models\TipoContratacion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoContratacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipo_contratacionesData = ['Nueva contratación', 'Cambio de renglón', 'Cambio de puesto', 'Cambio de servicio'];

        foreach ($tipo_contratacionesData as $contrataciones) {
            TipoContratacion::create([
                'tipo' => $contrataciones
            ]);
        }
    }
}
