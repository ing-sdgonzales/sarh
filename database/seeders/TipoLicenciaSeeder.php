<?php

namespace Database\Seeders;

use App\Models\TipoLicencia;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoLicenciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipos_licencias = ['A', 'B', 'C', 'M', 'E'];

        foreach ($tipos_licencias as $tipo_licencia) {
            TipoLicencia::create([
                'tipo_licencia' => $tipo_licencia
            ]);
        }
    }
}
