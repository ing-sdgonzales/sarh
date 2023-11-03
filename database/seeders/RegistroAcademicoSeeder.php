<?php

namespace Database\Seeders;

use App\Models\RegistroAcademico;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RegistroAcademicoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $registrosData = ['Primaria','Secundaria', 'Diversificado', 'Técnico ocupacional', 'Técnico universitario', 'Universidad', 'Postgrado', 'Maestría', 'Doctorado', 'Otro'];

        foreach ($registrosData as $registros) {
            RegistroAcademico::create([
                'titulo' => $registros
            ]);
        }
    }
}
