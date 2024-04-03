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
            ['nombre' => 'Rómulo Andres Mejía Villatoro', 'dir' => 21, 'puesto' => 13],
            ['nombre' => 'Edson Francisco Sandoval Gálvez', 'dir' => 21, 'puesto' => 39],
            ['nombre' => 'Iván Mazariegos Núñez', 'dir' => 21, 'puesto' => 93],
            ['nombre' => 'Marlon Rigoberto Mayén Cifuentes', 'dir' => 21, 'puesto' => 92],
            ['nombre' => 'Allan Kenny Martínez Quiñonez', 'dir' => 21, 'puesto' => 92],
            ['nombre' => 'Luis Enrique González Xoyon', 'dir' => 21, 'puesto' => 95],
            ['nombre' => 'Hugo Francisco Escobar Fuentes', 'dir' => 21, 'puesto' => 95],
            ['nombre' => 'Josué Cristóbal Guzmán Tello', 'dir' => 21, 'puesto' => 95],
            ['nombre' => 'Elmar Gabriel Pérez Marroquín', 'dir' => 21, 'puesto' => 95],
            ['nombre' => 'Edwin Antonio Pérez Burrión', 'dir' => 21, 'puesto' => 95],
            ['nombre' => 'Mynor Josué Curumaco Moya', 'dir' => 21, 'puesto' => 95],
            ['nombre' => 'José Manolo García Pérez', 'dir' => 21, 'puesto' => 95],
            ['nombre' => 'Celso Joaquín Vásquez Velásquez', 'dir' => 21, 'puesto' => 96],
            ['nombre' => 'Francisco Antonio López Salas', 'dir' => 21, 'puesto' => 96],
            ['nombre' => 'Carlos Jiménez Sales', 'dir' => 21, 'puesto' => 96],
            ['nombre' => 'Sergio De La Cruz Gómez', 'dir' => 21, 'puesto' => 96],
            ['nombre' => 'Cecilio Florindo Alvarado Alvarado', 'dir' => 21, 'puesto' => 96],
            ['nombre' => 'Kinberly Michel Juárez García', 'dir' => 21, 'puesto' => 96],
            ['nombre' => 'Delsy Migdalia Ramos Lemus', 'dir' => 21, 'puesto' => 96],
            ['nombre' => 'Mynor Estuardo Ramírez De León', 'dir' => 21, 'puesto' => 96],
            ['nombre' => 'Alfredo Edberto López Sipaque', 'dir' => 21, 'puesto' => 96],
            ['nombre' => 'José Francisco Morales Galdámez', 'dir' => 21, 'puesto' => 96],
            ['nombre' => 'Marcia Jazmin Patricia Romero González', 'dir' => 21, 'puesto' => 96],
            ['nombre' => 'Edy Alejandro Castañeda Yocute', 'dir' => 21, 'puesto' => 96],
            ['nombre' => 'Eliezer Andrés Maas Dávila', 'dir' => 21, 'puesto' => 96],
            ['nombre' => 'Rodimiro Vargas García', 'dir' => 21, 'puesto' => 96],
            ['nombre' => 'Mario Rosendo Patzán Oscal', 'dir' => 21, 'puesto' => 96],
            ['nombre' => 'Neida Teresa Chivichón Hernández', 'dir' => 21, 'puesto' => 96],

            /* Dirección de Planificación y Desarrollo Institucional */
            ['nombre' => 'Boris Rodrigo Gil Rivera', 'dir' => 11, 'puesto' => 95],
            ['nombre' => 'Luis Fernando Orozco Díaz', 'dir' => 11, 'puesto' => 95],
            ['nombre' => 'Carlota Lucía Cordón González', 'dir' => 11, 'puesto' => 93],
            ['nombre' => 'Aleyda De León', 'dir' => 11, 'puesto' => 94],
            ['nombre' => 'José Juárez', 'dir' => 11, 'puesto' => 94],
            ['nombre' => 'Sergio Muñoz', 'dir' => 11, 'puesto' => 94],

            /* Región III */
            ['nombre' => 'Yuliana Izabel Vargas Sosa', 'reg' => 3, 'dir' => 19, 'puesto' => 86],
            ['nombre' => 'Carlos Humberto Godoy Monzón', 'reg' => 3, 'dir' => 19, 'puesto' => 87],
            ['nombre' => 'Pablo Enríquez Pérez', 'reg' => 3, 'dir' => 19, 'puesto' => 90],
            ['nombre' => 'Jefferson Roberto Sandoval Quezada', 'reg' => 3, 'dir' => 19, 'puesto' => 90],
            ['nombre' => 'Franklin Yovany Maldonado López', 'reg' => 3, 'dir' => 19, 'puesto' => 90],
            ['nombre' => 'Mayra Violeta Arévalo Gómez', 'reg' => 3, 'dir' => 19, 'puesto' => 90],
            ['nombre' => 'Andrea Massiell León Chacón', 'reg' => 3, 'dir' => 19, 'puesto' => 88],
            ['nombre' => 'Marvin Omar Lemus Paiz', 'reg' => 3, 'dir' => 19, 'puesto' => 86],
            ['nombre' => 'Alberto Augusto Palma Ramírez', 'reg' => 3, 'dir' => 19, 'puesto' => 88],
            ['nombre' => 'Elsa María Morales Chacón', 'reg' => 3, 'dir' => 19, 'puesto' => 81],
            ['nombre' => 'María Fernanda Ordóñez Polanco', 'reg' => 3, 'dir' => 21, 'puesto' => 95],
            ['nombre' => 'Luisa Karina Rossal Aragón', 'reg' => 3, 'dir' => 17, 'puesto' => 94],
            ['nombre' => 'Julio Alberto Franco Flores', 'reg' => 3, 'dir' => 17, 'puesto' => 95],
            ['nombre' => 'Marco Antonio Lobos Rivera', 'reg' => 3, 'dir' => 17, 'puesto' => 95],
            ['nombre' => 'José Carlos Guerra Pineda', 'reg' => 3, 'dir' => 4, 'puesto' => 95],
            ['nombre' => 'Jesús Albeto Casasola Chacón', 'reg' => 3, 'dir' => 7, 'puesto' => 89],
            ['nombre' => 'Jaime Orlando Landaverry Guerra', 'reg' => 3, 'dir' => 7, 'puesto' => 95],
            ['nombre' => 'Oscar Geovani Leonardo', 'reg' => 3, 'dir' => 7, 'puesto' => 80],
            ['nombre' => 'Ramón Gutiérrez Aldana', 'reg' => 3, 'dir' => 21, 'puesto' => 97],
            ['nombre' => 'Nery Aldana Leiva', 'reg' => 3, 'dir' => 21, 'puesto' => 96],
            ['nombre' => 'Marco Tulio Leiva Arriaza', 'reg' => 3, 'dir' => 21, 'puesto' => 96],
            ['nombre' => 'Manuel Antonio Campos Asencio', 'reg' => 3, 'dir' => 21, 'puesto' => 96],
            ['nombre' => 'William Alexander Pérez y Pérez', 'reg' => 3, 'dir' => 21, 'puesto' => 96],
            ['nombre' => 'José Martín Pérez y Pérez', 'reg' => 3, 'dir' => 21, 'puesto' => 96],
            ['nombre' => 'Juan Carlos Pacheco Herrera', 'reg' => 3, 'dir' => 21, 'puesto' => 96],
            ['nombre' => 'Mario Alexander Barcenas', 'reg' => 3, 'dir' => 21, 'puesto' => 96],
            ['nombre' => 'Belter José Monroy Vásquez', 'reg' => 3, 'dir' => 21, 'puesto' => 96],
            ['nombre' => 'Juan Carlos Gómez Pérez', 'reg' => 3, 'dir' => 21, 'puesto' => 96],
            ['nombre' => 'Cristofer Orlando Sánchez', 'reg' => 3, 'dir' => 21, 'puesto' => 96],
            ['nombre' => 'Gabriel Antonio Palencia', 'reg' => 3, 'dir' => 21, 'puesto' => 96],
            ['nombre' => 'Oscar Vásquez Picón', 'reg' => 3, 'dir' => 21, 'puesto' => 96],
            ['nombre' => 'Christian Geovany Caal Ortega', 'reg' => 3, 'dir' => 21, 'puesto' => 96],
            ['nombre' => 'José Domingo Aroche Bautista', 'reg' => 3, 'dir' => 21, 'puesto' => 96],
            ['nombre' => 'Luis René Colindres Monroy', 'reg' => 3, 'dir' => 21, 'puesto' => 96],
            ['nombre' => 'Guillermo López Galicia', 'reg' => 3, 'dir' => 21, 'puesto' => 96],
            ['nombre' => 'Carlos Enrique Ovaye López', 'reg' => 3, 'dir' => 21, 'puesto' => 96],
            ['nombre' => 'Gerson Yovani Marroquín Jiménez', 'reg' => 3, 'dir' => 21, 'puesto' => 96],
            ['nombre' => 'Alvaro Arnoldo García Arroyo', 'reg' => 3, 'dir' => 21, 'puesto' => 96]
        ];

        foreach ($empleados as $emp) {
            $regionId = isset($emp['reg']) ? $emp['reg'] : 1;

            $empleado = PirEmpleado::create([
                'nombre' => $emp['nombre'],
                'pir_direccion_id' => $emp['dir'],
                'region_id' => $regionId
            ]);

            PirPuesto::create([
                'pir_empleado_id' => $empleado->id,
                'catalogo_puesto_id' => $emp['puesto']
            ]);
        }
    }
}
