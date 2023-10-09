<?php

namespace Database\Seeders;

use App\Models\Actividad;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ActividadSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $actividadesData = [
            ['codigo' => '001', 'actividad' => 'Dirección, Administración, Coordinación y Evaluación', "programas_id" => 1],
            ['codigo' => '001', 'actividad' => 'Gestión integral de riesgo', "programas_id" => 2],
            ['codigo' => '002', 'actividad' => 'Mitigación', "programas_id" => 2],
            ['codigo' => '003', 'actividad' => 'Preparación', "programas_id" => 2],
            ['codigo' => '004', 'actividad' => 'Respuesta', "programas_id" => 2],
            ['codigo' => '005', 'actividad' => 'Recuperación', "programas_id" => 2],
            ['codigo' => '006', 'actividad' => 'Sistema de comando de incidentes', "programas_id" => 2],
            ['codigo' => '007', 'actividad' => 'Comunicación social', "programas_id" => 2],
        ];

        foreach ($actividadesData as $actividades) {
            Actividad::create([
                'codigo' => $actividades['codigo'],
                'actividad' => $actividades['actividad'],
                'programas_id' => $actividades['programas_id']
            ]);
        }
    }
}
