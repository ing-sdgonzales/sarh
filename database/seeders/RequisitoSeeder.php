<?php

namespace Database\Seeders;

use App\Models\Requisito;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RequisitoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $requisitosData = [
            ['req' => 'DPI', 'spec' => '1 hoja ambos lados'],
            ['req' => 'RTU', 'spec' => 'Actualizado 2024'],
            ['req' => 'Constancia de antecedentes penales', 'spec' => 'vigentes'],
            ['req' => 'Constancia de antecedentes policiales', 'spec' => 'vigentes'],
            ['req' => 'Formulario de solicitud de contratación', 'spec' => 'Formulario de contratación y recontratación de personal SE-CONRED 011, 021, 022, 031']
        ];

        foreach ($requisitosData as $requisito) {
            Requisito::create([
                'requisito' => $requisito['req'],
                'especificacion' => $requisito['spec']
            ]);
        }
    }
}
