<?php

namespace Database\Seeders;

use App\Models\Programa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProgramaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $programasData = [
            ['codigo' => '1', 'programa' => 'Direcciones y unidades de apoyo para la gestión de la reducción de riesgo a desastres'],
            ['codigo' => '11', 'programa' => 'Programa de apoyo para la reducción de riesgo, atención y recuperación por desastres naturales o provocados']
        ];

        foreach ($programasData as $programa) {
            Programa::create([
                'codigo' => $programa['codigo'],
                'programa' => $programa['programa']
            ]);
        }
    }
}
