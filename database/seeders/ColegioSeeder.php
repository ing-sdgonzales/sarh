<?php

namespace Database\Seeders;

use App\Models\Colegio;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ColegioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $colegiosData = [
            ['colegio' => 'Colegio Profesional de Humanidades de Guatemala'],
            ['colegio' => 'Colegio de Arquitectos de Guatemala'],
            ['colegio' => 'Colegio de Contadores Públicos y Auditores de Guatemala'],
            ['colegio' => 'Colegio de Economistas, Contadores Públicos y Auditores y Administradores de Empresas'],
            ['colegio' => 'Colegio de Farmacéuticos y Químicos de Guatemala'],
            ['colegio' => 'Colegio de Ingenieros Agrónomos de Guatemala'],
            ['colegio' => 'Colegio de Ingenieros de Guatemala'],
            ['colegio' => 'Colegio de Ingenieros Químicos de Guatemala'],
            ['colegio' => 'Colegio de Médicos Veterinarios y Zootecnistas de Guatemala'],
            ['colegio' => 'Colegio de Médicos y Cirujanos de Guatemala'],
            ['colegio' => 'Colegio de Psicólogos de Guatemala'],
            ['colegio' => 'Colegio Estomatológico de Guatemala'],
            ['colegio' => 'Colegio de Abogados y Notarios de Guatemala'],
            ['colegio' => 'Colegio Profesional de Enfermería de Guatemala']
        ];

        foreach ($colegiosData as $colegio) {
            Colegio::create([
                'nombre' => $colegio['colegio']
            ]);
        }
    }
}
