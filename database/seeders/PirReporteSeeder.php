<?php

namespace Database\Seeders;

use App\Models\PirReporte;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PirReporteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $reportes = [
            'Presente en sedes',
            'Suspendidos por el IGSS',
            'Suspendidos por la Clínica Médica',
            'Licencia con goce de salario',
            'Permiso autorizado',
            'Comisión',
            'Descanso por turno',
            'Capacitación en el extranjero',
            'Ausente (Justificar)',
            'Vacaciones',
            'Disponible', 
            'Problemas de salud',
            'No disponible'
        ];

        foreach ($reportes as $reporte) {
            PirReporte::create([
                'reporte' => $reporte
            ]);
        }
    }
}
