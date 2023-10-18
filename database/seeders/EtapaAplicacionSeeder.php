<?php

namespace Database\Seeders;

use App\Models\EtapaAplicacion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EtapaAplicacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $etapas_aplicaciones =  [
            'Conformación de expediente',
            'Validación de expediente',
            'Entrega de expediente',
            'Pruebas técnicas',
            'Pruebas psicométricas',
            'Informe de evaluación',
            'Programación de fecha de ingreso'
        ];

        foreach ($etapas_aplicaciones as $etapa_aplicacion) {
            EtapaAplicacion::create([
                'etapa' => $etapa_aplicacion
            ]);
        }
    }
}
