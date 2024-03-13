<?php

namespace Database\Seeders;

use App\Models\Producto;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productosData = [
            ['codigo' => '000-043', 'nombre' => 'Institución fortalecida a través de la gestión de procesos de planificación, administrativos, financieros, logísticos, cooperación nacional e internacional, asesoría legal, controles internos y administración del personal, contribuyendo a la reducción de riesgo a desastres', 'actividades_id' => 1],
            ['codigo' => '004-001', 'nombre' => 'Instrumentos e información con estándares nacionales e internacionales de gestión integral del riesgo de desastres para instituciones de Estado y municipios priorizados o vulnerables', 'actividades_id' => 1], 
            ['codigo' => '004-002', 'nombre' => 'Instrumentos, normativa e información con estándares nacionales e internacionales dirigido a Municipios e instituciones para la identificación de condiciones de riesgo', 'actividades_id' => 1], 
            ['codigo' => '004-003', 'nombre' => 'Población priorizada o en condiciones de vulnerabilidad organizada y capacitada en concordancia con las normativas nacionales e internacionales de Gestión para la Reducción del Riesgo de Desastres', 'actividades_id' => 1], 
            ['codigo' => '004-004', 'nombre' => 'Registro de la información de situaciones de emergencia o desastre y acciones de fortalecimiento al personal del sistema CONRED durante la ocurrencia de un evento adverso', 'actividades_id' => 1], 
            ['codigo' => '004-005', 'nombre' => 'Implementación del Marco Nacional de Recuperación en los distintos niveles de organización sectorial y territorial con priorización en las áreas afectadas por desastres y promoviendo la integración del enfoque de equidad e igualdad de género en los procesos de recuperación', 'actividades_id' => 1], 
            ['codigo' => '004-006', 'nombre' => 'Capacitar y actualizar a personas pertenecientes a los diferentes niveles sectoriales y territoriales, responsables de la atención en situaciones de riesgo, emergencia o desastre RED, así como coordinar las acciones de respuesta táctica al momento de sobrepasar la capacidad de respuesta departamental', 'actividades_id' => 1], 
            ['codigo' => '004-007', 'nombre' => 'Fortalecimiento de la gestión integral del riesgo de desastres a través de las herramientas de información dirigidas a la población guatemalteca en coordinación con instituciones del sistema CONRED', 'actividades_id' => 1],
        ];

        foreach ($productosData as $productos) {
            Producto::create([
                'codigo' => $productos['codigo'],
                'nombre' => $productos['nombre'],
                'actividades_id' => $productos['actividades_id']
            ]);
        }
    }
}
