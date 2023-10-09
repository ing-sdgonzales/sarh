<?php

namespace Database\Seeders;

use App\Models\DependenciaNominal;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ControlSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $controlesData = [
            'Secretaría Ejecutiva',
            'Subsecretaría de Coordinación y Administración',
            'Subsecretaría de Gestion de Reducción del Riesgo',
            'Dirección Administrativa',
            'Direccion Financiera',
            'Direccion de Coordinacion',
            'Direccion de Logística',
            'Inspectoria General',
            'Unidad de Auditoría Interna',
            'Dirección de Recursos Humanos',
            'Dirección de Planificación y Desarrollo Institucional',
            'Unidad de Información Pública',
            'Unidad de Asesoria Específica',
            'Dirección de Asesoria Jurídica',
            'Unidad de Género',
            'Dirección de Gestion Integral de Reduccion de Riesgos a Desastres',
            'Dirección de Mitigación',
            'Dirección de Preparación',
            'Dirección de Respuesta',
            'Dirección de Recuperación',
            'Dirección de Sistema de Comando de Incidentes - SCI',
            'Dirección de Comunicacion ocial'
        ];


        foreach ($controlesData as $control) {
            DependenciaNominal::create([
                'dependencia' => $control,
            ]);
        }
    }
}
