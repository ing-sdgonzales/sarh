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
            ['bono' => 'Complemento personal', 'cantidad' => 6000.00, 'calculado' => 0, 'tipo_bono' => 1],
            ['bono' => 'Complemento personal', 'cantidad' => 5000.00, 'calculado' => 0, 'tipo_bono' => 1],
            ['bono' => 'Bono CONRED', 'cantidad' => 6000.00, 'calculado' => 0, 'tipo_bono' => 1],
            ['bono' => 'Bono profesional', 'cantidad' => 375.00, 'calculado' => 0, 'tipo_bono' => 1],
            ['bono' => 'Gastos representación', 'cantidad' => 12000.00, 'calculado' => 0, 'tipo_bono' => 1],
            ['bono' => 'Gastos representación', 'cantidad' => 10000.00, 'calculado' => 0, 'tipo_bono' => 1],
            ['bono' => 'Bono 66-2000', 'cantidad' => 250.00, 'calculado' => 0, 'tipo_bono' => 1],
            ['bono' => 'Bono por ajuste al salario mínimo', 'cantidad' => 1750.00, 'calculado' => 0, 'tipo_bono' => 1],
            ['bono' => 'Bono por disponibilidad y riesgo', 'cantidad' => 0.35, 'calculado' => 1, 'tipo_bono' => 1],
            ['bono' => 'Bono de antigüedad', 'cantidad' => 0.00, 'calculado' => 1, 'tipo_bono' => 1],
            ['bono' => 'Bono vacacional', 'cantidad' => 200.00, 'calculado' => 0, 'tipo_bono' => 2],
            ['bono' => 'Bono 14', 'cantidad' => 0.00, 'calculado' => 1, 'tipo_bono' => 2],
            ['bono' => 'Aguinaldo', 'cantidad' => 0.00, 'calculado' => 1, 'tipo_bono' => 2],
        ];

        foreach ($bonosData as $bono) {
            Bonificacion::create([
                'bono' => $bono['bono'],
                'cantidad' => $bono['cantidad'],
                'calculado' => $bono['calculado'],
                'tipos_bonificaciones_id' => $bono['tipo_bono']
            ]);
        }
    }
}
