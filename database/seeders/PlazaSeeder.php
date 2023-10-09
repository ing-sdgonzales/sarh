<?php

namespace Database\Seeders;

use App\Models\Plaza;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlazaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plazasData = [
            ['codigo' => '1', 'plaza' => 'Exento'],
            ['codigo' => '2', 'plaza' => 'Oposición'],
            ['codigo' => '3', 'plaza' => 'Confianza'],
            ['codigo' => '4', 'plaza' => 'Contratación temporal']

        ];

        foreach ($plazasData as $plazas) {
            Plaza::create([
                'codigo' => $plazas['codigo'],
                'plaza' => $plazas['plaza']
            ]);
        }
    }
}
