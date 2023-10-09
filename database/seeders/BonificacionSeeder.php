<?php

namespace Database\Seeders;

use App\Models\Bonificacion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BonificacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bonosData = [
            ['bono' => 'Complemento personal', 'cantidad' => 6000.00],
            ['bono' => 'Complemento personal', 'cantidad' => 5000.00],
            ['bono' => 'Bono CONRED', 'cantidad' => 6000.00],
            ['bono' => 'Bono profesional', 'cantidad' => 375.00],
            ['bono' => 'Gastos representación', 'cantidad' => 12000.00],
            ['bono' => 'Gastos representación', 'cantidad' => 10000.00],
            ['bono' => 'Bono 66-200', 'cantidad' => 250.00],
            ['bono' => 'Bono por ajuste al salario mínimo', 'cantidad' => 1750.00],
            ['bono' => 'Bono por disponibilidad y riesgo', 'cantidad' => 0.00],
        ];

        foreach ($bonosData as $bono) {
            Bonificacion::create([
                'bono' => $bono['bono'],
                'cantidad' => $bono['cantidad']
            ]);
        }
    }
}
