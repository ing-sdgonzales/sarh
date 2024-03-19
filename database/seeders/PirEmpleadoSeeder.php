<?php

namespace Database\Seeders;

use App\Models\PirEmpleado;
use App\Models\PirPuesto;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PirEmpleadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $empleados = [
            /* Dirección de Sistema de Comando de Incidentes */
            ['nombre' => 'Rómulo Andres Mejía Villatoro', 'dir' => 21, 'puesto' => 13, 'renglon' => 5],
            ['nombre' => 'Edson Francisco Sandoval Gálvez', 'dir' => 21, 'puesto' => 39, 'renglon' => 5],
            ['nombre' => 'Iván Mazariegos Núñez', 'dir' => 21, 'puesto' => 93, 'renglon' => 6],
            ['nombre' => 'Marlon Rigoberto Mayén Cifuentes', 'dir' => 21, 'puesto' => 92, 'renglon' => 6],
            ['nombre' => 'Allan Kenny Martínez Quiñonez', 'dir' => 21, 'puesto' => 92, 'renglon' => 6],
            ['nombre' => 'Luis Enrique González Xoyon', 'dir' => 21, 'puesto' => 95, 'renglon' => 10],
            ['nombre' => 'Hugo Francisco Escobar Fuentes', 'dir' => 21, 'puesto' => 95, 'renglon' => 10],
            ['nombre' => 'Josué Cristóbal Guzmán Tello', 'dir' => 21, 'puesto' => 95, 'renglon' => 10],
            ['nombre' => 'Elmar Gabriel Pérez Marroquín', 'dir' => 21, 'puesto' => 95, 'renglon' => 10],
            ['nombre' => 'Edwin Antonio Pérez Burrión', 'dir' => 21, 'puesto' => 95, 'renglon' => 10],
            ['nombre' => 'Mynor Josué Curumaco Moya', 'dir' => 21, 'puesto' => 95, 'renglon' => 10],
            ['nombre' => 'José Manolo García Pérez', 'dir' => 21, 'puesto' => 95, 'renglon' => 10],
            ['nombre' => 'Celso Joaquín Vásquez Velásquez', 'dir' => 21, 'puesto' => 96, 'renglon' => 11],
            ['nombre' => 'Francisco Antonio López Salas', 'dir' => 21, 'puesto' => 96, 'renglon' => 11],
            ['nombre' => 'Carlos Jiménez Sales', 'dir' => 21, 'puesto' => 96, 'renglon' => 11],
            ['nombre' => 'Sergio De La Cruz Gómez', 'dir' => 21, 'puesto' => 96, 'renglon' => 11],
            ['nombre' => 'Cecilio Florindo Alvarado Alvarado', 'dir' => 21, 'puesto' => 96, 'renglon' => 11],
            ['nombre' => 'Kinberly Michel Juárez García', 'dir' => 21, 'puesto' => 96, 'renglon' => 11],
            ['nombre' => 'Delsy Migdalia Ramos Lemus', 'dir' => 21, 'puesto' => 96, 'renglon' => 11],
            ['nombre' => 'Mynor Estuardo Ramírez De León', 'dir' => 21, 'puesto' => 96, 'renglon' => 11],
            ['nombre' => 'Alfredo Edberto López Sipaque', 'dir' => 21, 'puesto' => 96, 'renglon' => 11],
            ['nombre' => 'José Francisco Morales Galdámez', 'dir' => 21, 'puesto' => 96, 'renglon' => 11],
            ['nombre' => 'Marcia Jazmin Patricia Romero González', 'dir' => 21, 'puesto' => 96, 'renglon' => 11],
            ['nombre' => 'Edy Alejandro Castañeda Yocute', 'dir' => 21, 'puesto' => 96, 'renglon' => 11],
            ['nombre' => 'Eliezer Andrés Maas Dávila', 'dir' => 21, 'puesto' => 96, 'renglon' => 11],
            ['nombre' => 'Rodimiro Vargas García', 'dir' => 21, 'puesto' => 96, 'renglon' => 11],
            ['nombre' => 'Mario Rosendo Patzán Oscal', 'dir' => 21, 'puesto' => 96, 'renglon' => 11],
            ['nombre' => 'Neida Teresa Chivichón Hernández', 'dir' => 21, 'puesto' => 96, 'renglon' => 11],

            /* Dirección de Planificación y Desarrollo Institucional */
            ['nombre' => 'Boris Rodrigo Gil Rivera', 'dir' => 11, 'puesto' => 95, 'renglon' => 10],
            ['nombre' => 'Luis Fernando Orozco Díaz', 'dir' => 11, 'puesto' => 95, 'renglon' => 10],
            ['nombre' => 'Carlota Lucía Cordón González', 'dir' => 11, 'puesto' => 93, 'renglon' => 6],
            ['nombre' => 'Aleyda De León', 'dir' => 11, 'puesto' => 94, 'renglon' => 10],
            ['nombre' => 'José Juárez', 'dir' => 11, 'puesto' => 94, 'renglon' => 10],
            ['nombre' => 'Sergio Muñoz', 'dir' => 11, 'puesto' => 94, 'renglon' => 10],
        ];

        foreach ($empleados as $emp) {
            $empleado = PirEmpleado::create([
                'nombre' => $emp['nombre'],
                'pir_direccion_id' => $emp['dir'],
                'renglon_id' => $emp['renglon']
            ]);

            PirPuesto::create([
                'pir_empleado_id' => $empleado->id,
                'catalogo_puesto_id' => $emp['puesto']
            ]);
        }
    }
}
