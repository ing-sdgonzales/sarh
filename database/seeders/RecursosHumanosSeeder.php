<?php

namespace Database\Seeders;

use App\Models\PirEmpleado;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RecursosHumanosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datos = [
            ['nombre' => 'Marvin René Solorzano Tello', 'dir' => 10, 'grupo' => 1, 'reporte' => 1, 'servicio' => 2, 'renglon' => 6],
            ['nombre' => 'Lilian Aleyda Rojas Guzmán', 'dir' => 10, 'grupo' => 1, 'reporte' => 1, 'servicio' => 2, 'renglon' => 6],
            ['nombre' => 'Geimy Fabiola Vega Espina', 'dir' => 10, 'grupo' => 1, 'reporte' => 1, 'servicio' => 2, 'renglon' => 5],
            ['nombre' => 'Byron Enrique López Recinos', 'dir' => 10, 'grupo' => 1, 'reporte' => 1, 'servicio' => 2, 'renglon' => 5],
            ['nombre' => 'Leticia Eugenia Padilla Zuleta', 'dir' => 10, 'grupo' => 1, 'reporte' => 1, 'servicio' => 2, 'renglon' => 5],
            ['nombre' => 'Kattie Briana Alexandra Salazar Ortíz', 'dir' => 10, 'grupo' => 1, 'reporte' => 1, 'servicio' => 2, 'renglon' => 5],

            ['nombre' => 'Carlos Alberto Zuñiga y Zuñiga', 'dir' => 10, 'grupo' => 1, 'reporte' => 1, 'servicio' => 2, 'renglon' => 10],
            ['nombre' => 'Shirly Pamela De León López', 'dir' => 10, 'grupo' => 1, 'reporte' => 1, 'servicio' => 1, 'renglon' => 10],
            ['nombre' => 'Josué Daniel Rosales Arché', 'dir' => 10, 'grupo' => 1, 'reporte' => 1, 'servicio' => 1, 'renglon' => 10],
            ['nombre' => 'Ruth Pamela Rendón Martínez', 'dir' => 10, 'grupo' => 1, 'reporte' => 1, 'servicio' => 1, 'renglon' => 10],
            ['nombre' => 'Wendy Catalina García Mejía', 'dir' => 10, 'grupo' => 1, 'reporte' => 1, 'servicio' => 1, 'renglon' => 10],
            ['nombre' => 'Allan Francisco Platero Armas', 'dir' => 10, 'grupo' => 1, 'reporte' => 1, 'servicio' => 2, 'renglon' => 10],
            ['nombre' => 'Sergio Antonio Paíz Loarca', 'dir' => 10, 'grupo' => 1, 'reporte' => 1, 'servicio' => 2, 'renglon' => 10],
            ['nombre' => 'Evelyn Gabriela Mis Juárez', 'dir' => 10, 'grupo' => 1, 'reporte' => 1, 'servicio' => 1, 'renglon' => 10],
            ['nombre' => 'Mirna Irasema Siliezar Tello', 'dir' => 10, 'grupo' => 1, 'reporte' => 1, 'servicio' => 1, 'renglon' => 10],
            ['nombre' => 'Shirley Carolina Cardona Castillo', 'dir' => 10, 'grupo' => 1, 'reporte' => 1, 'servicio' => 1, 'renglon' => 10],
            ['nombre' => 'Sergio Daniel Gonzáles López', 'dir' => 10, 'grupo' => 1, 'reporte' => 1, 'servicio' => 2, 'renglon' => 10],
            ['nombre' => 'Jenny Paola Lemus Temu', 'dir' => 10, 'grupo' => 1, 'reporte' => 1, 'servicio' => 1, 'renglon' => 10],
        ];

        foreach ($datos as $emp) {
            PirEmpleado::create([
                'nombre' => $emp['nombre'],
                'pir_direccion_id' => $emp['dir'],
                'pir_grupo_id' => $emp['grupo'],
                'pir_reporte_id' => $emp['reporte'],
                'tipo_servicio_id' => $emp['servicio'],
                'renglon_id' => $emp['renglon']
            ]);
        }
    }
}
