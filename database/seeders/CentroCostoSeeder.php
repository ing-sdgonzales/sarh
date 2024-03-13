<?php

namespace Database\Seeders;

use App\Models\CentroCosto;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CentroCostoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ccData = [
            ['codigo' => '0101', 'nombre' => 'prueba'],
            
        ];

        foreach ($ccData as $centro) {
            CentroCosto::create([
                'codigo' => $centro['codigo'],
                'nombre' => $centro['nombre']
            ]);
        }
    }
}
