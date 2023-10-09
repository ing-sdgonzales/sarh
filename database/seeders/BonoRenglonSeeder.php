<?php

namespace Database\Seeders;

use App\Models\BonoRenglon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BonoRenglonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $asignacion_regnlones = [
            ['renglones_id' => 2, 'bonificaciones_id' => 1],
            ['renglones_id' => 2, 'bonificaciones_id' => 2],
            ['renglones_id' => 4, 'bonificaciones_id' => 3],
            ['renglones_id' => 3, 'bonificaciones_id' => 4],
            ['renglones_id' => 8, 'bonificaciones_id' => 4],
            ['renglones_id' => 16, 'bonificaciones_id' => 5],
            ['renglones_id' => 16, 'bonificaciones_id' => 6],
            ['renglones_id' => 4, 'bonificaciones_id' => 7],
            ['renglones_id' => 9, 'bonificaciones_id' => 7],
            ['renglones_id' => 13, 'bonificaciones_id' => 7],
            ['renglones_id' => 13, 'bonificaciones_id' => 8],
            ['renglones_id' => 9, 'bonificaciones_id' => 9],
        ];

        foreach ($asignacion_regnlones as $asignacion) {
            BonoRenglon::create([
                'renglones_id' => $asignacion['renglones_id'],
                'bonificaciones_id' => $asignacion['bonificaciones_id']
            ]);
        }
    }
}
