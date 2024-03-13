<?php

namespace Database\Seeders;

use App\Models\RelacionLaboral;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RelacionLaboralSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $relaciones_laborales = ['Exempleado', 'Empleado actual', 'Nuevo empleado', 'Pendiente de asignar'];

        foreach ($relaciones_laborales as $relacion_laboral) {
            RelacionLaboral::create([
                'relacion_laboral' => $relacion_laboral
            ]);
        }
    }
}
