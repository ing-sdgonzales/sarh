<?php

namespace Database\Seeders;

use App\Models\Subproducto;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubproductoSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subproductosData = [
            ['codigo' => '000-043-0001', 'proyecto' => 'Institución fortalecida por medio de acciones de coordinación técnica y administrativa de la SE-CONRED', "productos_id" => 1],
            ['codigo' => '000-043-0002', 'proyecto' => 'Institución fortalecida por medio de apoyo de acciones administrativas, financieras, de coordinación y de logística de las diferentes direcciones y unidades', "productos_id" => 1],
            ['codigo' => '000-043-0003', 'proyecto' => 'Institución fortalecida a través de la gestión del recurso humano contratado', "productos_id" => 1],
            ['codigo' => '000-043-0004', 'proyecto' => 'Procesos de asesoría legal,  planificación estratégica y operativa, asesoría específica en temas de reducción de riesgo a desastres y gestión de información pública institucional', "productos_id" => 1],
            ['codigo' => '000-043-0005', 'proyecto' => 'Incorporar el enfoque de género como eje transversal en los planes, programas, proyectos y actividades que se lleven a cabo en la SE-CONRED', "productos_id" => 1],
            ['codigo' => '004-001-0001', 'proyecto' => 'Instancias municipales y sectoriales de Reducción de Riesgo de Desastres conformadas o con procesos de desarrollo y transferencia de capacidades y condiciones', "productos_id" => 2],
            ['codigo' => '004-001-0002', 'proyecto' => 'Iniciativas, guías, metodologías, la política pública, instrumentos y estrategias para gestionar la Reducción de Riesgo a los Desastres a nivel territorial y sectorial en Guatemala', "productos_id" => 2],
            ['codigo' => '004-002-0001', 'proyecto' => 'Instrumentos, normativa e información con estándares nacionales e internacionales dirigido a Municipios e instituciones para la identificación de condiciones de riesgo', "productos_id" => 3],
            ['codigo' => '004-003-0001', 'proyecto' => 'Población capacitada en el marco del Programa Nacional de Educación en Gestión Integral del Riesgo', "productos_id" => 4],
            ['codigo' => '004-003-0002', 'proyecto' => 'Integrantes sectoriales y territoriales del Sistema CONRED que han participado en acciones de conformación de Coordinadoras para la Reducción de Desastres, así como acciones de voluntariado y fortalecimiento del Sistema en los diferentes niveles territoriales', "productos_id" => 4],
            ['codigo' => '004-003-0003', 'proyecto' => 'Coordinadoras para la Reducción de Desastres acreditadas en los diferentes niveles territoriales, con enfoque de igualdad y equidad de género', "productos_id" => 4],
            ['codigo' => '004-004-0001', 'proyecto' => 'Registro de información de eventos provocados por una situación de emergencia o desastre para la toma de decisiones', "productos_id" => 4],
            ['codigo' => '004-004-0002', 'proyecto' => 'Asesoría y coordinación a personal del sistema CONRED en temáticas de respuesta estratégica para atender situaciones de emergencia o desastre', "productos_id" => 5],
            ['codigo' => '004-004-0003', 'proyecto' => 'Asesoría, monitoreo y coordinación a nivel territorial para atender antes y durante situaciones de Riesgo Emergencia o Desastres -RED-', "productos_id" => 5],
            ['codigo' => '004-005-0001', 'proyecto' => 'Implementación del Marco Nacional de Recuperación en los distintos niveles de organización sectorial y territorial con priorización en las áreas afectadas por desastres y promoviendo la integración del enfoque de equidad e igualdad de género en los procesos de recuperación', "productos_id" =>5],
            ['codigo' => '004-006-0001', 'proyecto' => 'Capacitación de personas en el Sistema de Comando de Incidentes  (CBSCI, CISCI, PRIMAP nivel 1, BREC, CRECL, MATPEL Operaciones nivel 2, CPI, CCI, CBF, TTBCIF) para ejecutar el protocolo operativo en campo. De acuerdo a la temporada que esté presente y/o evento sin previo aviso', "productos_id" => 6],
            ['codigo' => '004-006-0002', 'proyecto' => 'RecuperacióEjecución de acciones encaminadas a la prevención, mitigación, control y liquidación de incendios forestales en el territorio nacional', "productos_id" => 6],
            ['codigo' => '004-007-0001', 'proyecto' => 'Implementación del proceso información a la población con acompañamiento del sistema CONRED', "productos_id" => 7]
        ];

        foreach ($subproductosData as $subproductos) {
            Subproducto::create([
                'codigo' => $subproductos['codigo'],
                'proyecto' => $subproductos['proyecto'],
                'productos_id' => $subproductos['productos_id']
            ]);
        }
    }
}
