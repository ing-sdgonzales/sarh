<?php

namespace Database\Seeders;

use App\Models\CatalogoPuesto;
use App\Models\Renglon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CatalogoPuestoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $puestosData = [
            /* 011 */
            ['codigo' => '71736', 'puesto' => 'Secretario Ejecutivo', 'renglones_id' => 1, 'cantidad' => 1, 'jefe' => 1],
            ['codigo' => '71747', 'puesto' => 'Subsecretario de Gestión de Reducción de Riesgo', 'renglones_id' => 1, 'cantidad' => 1, 'jefe' => 1],
            ['codigo' => '71802', 'puesto' => 'Subsecretario de Coordinación y Administración', 'renglones_id' => 1, 'cantidad' => 1, 'jefe' => 1],

            /* 022 */
            ['codigo' => '74191', 'puesto' => 'Asesor', 'renglones_id' => 5, 'cantidad' => 1, 'jefe' => 0],
            ['codigo' => '74705', 'puesto' => 'Auxiliar Administrativo Contable', 'renglones_id' => 5, 'cantidad' => 1, 'jefe' => 0],
            ['codigo' => '74686', 'puesto' => 'Auxiliar de Archivo General', 'renglones_id' => 5, 'cantidad' => 1, 'jefe' => 0],
            ['codigo' => '71849', 'puesto' => 'Auxiliar de Contabilidad', 'renglones_id' => 5, 'cantidad' => 1, 'jefe' => 0],
            ['codigo' => '71855', 'puesto' => 'Auxiliar de Inventario', 'renglones_id' => 5, 'cantidad' => 1, 'jefe' => 0],
            ['codigo' => '71848', 'puesto' => 'Auxiliar de Presupuesto', 'renglones_id' => 5, 'cantidad' => 1, 'jefe' => 0],
            ['codigo' => '74695', 'puesto' => 'Auxiliar de Producción y Edición', 'renglones_id' => 5, 'cantidad' => 1, 'jefe' => 0],
            ['codigo' => '74694', 'puesto' => 'Auxiliar de Reproducción', 'renglones_id' => 5, 'cantidad' => 1, 'jefe' => 0],
            ['codigo' => '71790', 'puesto' => 'Delegado COED', 'renglones_id' => 5, 'cantidad' => 1, 'jefe' => 0],
            ['codigo' => '74807', 'puesto' => 'enc. de grup. de resp. a incid. con mp', 'renglones_id' => 5, 'cantidad' => 1, 'jefe' => 1],
            ['codigo' => '74699', 'puesto' => 'Encargado de Administracion y Dotación de Personal', 'renglones_id' => 5, 'cantidad' => 1, 'jefe' => 1],
            ['codigo' => '74702', 'puesto' => 'Encargado de Administrativo Contable', 'renglones_id' => 5, 'cantidad' => 1, 'jefe' => 1],
            ['codigo' => '71755', 'puesto' => 'Encargado de Apoyo Psicosocial', 'renglones_id' => 5, 'cantidad' => 1, 'jefe' => 1],
            ['codigo' => '71833', 'puesto' => 'Encargado de Bodega', 'renglones_id' => 5, 'cantidad' => 1, 'jefe' => 1],
            ['codigo' => '71851', 'puesto' => 'Encargado de Compras', 'renglones_id' => 5, 'cantidad' => 1, 'jefe' => 1],
            ['codigo' => '74690', 'puesto' => 'Encargado de CONRED Radio', 'renglones_id' => 5, 'cantidad' => 1, 'jefe' => 1],
            ['codigo' => '71844', 'puesto' => 'Encargado de Contabilidad', 'renglones_id' => 5, 'cantidad' => 1, 'jefe' => 1],
            ['codigo' => '74710', 'puesto' => 'Encargado de Convenios y Acuerdos Territoriales', 'renglones_id' => 5, 'cantidad' => 1, 'jefe' => 1],
            ['codigo' => '71808', 'puesto' => 'Encargado de Cooperación Internacional', 'renglones_id' => 5, 'cantidad' => 1, 'jefe' => 1],
            ['codigo' => '79733', 'puesto' => 'Encargado de Coordinación Territorial para la Recuperación', 'renglones_id' => 5, 'cantidad' => 1, 'jefe' => 1],
            ['codigo' => '74192', 'puesto' => 'Encargado de Desarrollo y Bienestar Laboral', 'renglones_id' => 5, 'cantidad' => 1, 'jefe' => 1],
            ['codigo' => '74689', 'puesto' => 'Encargado de Diseño Gráfico', 'renglones_id' => 5, 'cantidad' => 1, 'jefe' => 1],
            ['codigo' => '71768', 'puesto' => 'Encargado de Educación', 'renglones_id' => 5, 'cantidad' => 1, 'jefe' => 1],
            ['codigo' => '74034', 'puesto' => 'Encargado de Fondo Rotativo', 'renglones_id' => 5, 'cantidad' => 1, 'jefe' => 1],
            ['codigo' => '71847', 'puesto' => 'Encargado de Rondos Rotativos', 'renglones_id' => 5, 'cantidad' => 1, 'jefe' => 1],
            ['codigo' => '71767', 'puesto' => 'Encargado de Fortalecimiento Sistema CONRED', 'renglones_id' => 5, 'cantidad' => 1, 'jefe' => 1],
            ['codigo' => '74178', 'puesto' => 'Encargado de Gestión Cooperacion Nacional', 'renglones_id' => 5, 'cantidad' => 1, 'jefe' => 1],
            ['codigo' => '74700', 'puesto' => 'Encargado de Gestión y Acciones de Personal', 'renglones_id' => 5, 'cantidad' => 1, 'jefe' => 1],
            ['codigo' => '74697', 'puesto' => 'Encargado de Informática', 'renglones_id' => 5, 'cantidad' => 1, 'jefe' => 1],
            ['codigo' => '71852', 'puesto' => 'Encargado de Inventario', 'renglones_id' => 5, 'cantidad' => 1, 'jefe' => 1],
            ['codigo' => '71763', 'puesto' => 'Encargado de Investigación', 'renglones_id' => 5, 'cantidad' => 1, 'jefe' => 1],
            ['codigo' => '71762', 'puesto' => 'Encargado de Monitoreo y Análisis de Riesgo', 'renglones_id' => 5, 'cantidad' => 1, 'jefe' => 1],
            ['codigo' => '74032', 'puesto' => 'Encargado de Nómina', 'renglones_id' => 5, 'cantidad' => 1, 'jefe' => 1],
            ['codigo' => '79734', 'puesto' => 'Encargado de Normas', 'renglones_id' => 5, 'cantidad' => 1, 'jefe' => 1],
            ['codigo' => '71761', 'puesto' => 'Encargado de Obras de Infraestructura', 'renglones_id' => 5, 'cantidad' => 1, 'jefe' => 1],
            ['codigo' => '79735', 'puesto' => 'Encargado de Operaciones BRIF', 'renglones_id' => 5, 'cantidad' => 1, 'jefe' => 1],
            ['codigo' => '71769', 'puesto' => 'Encargado de Organización Nacional', 'renglones_id' => 5, 'cantidad' => 1, 'jefe' => 1],
            ['codigo' => '80454', 'puesto' => 'Encargado de Planes y Programas', 'renglones_id' => 5, 'cantidad' => 1, 'jefe' => 1],
            ['codigo' => '71754', 'puesto' => 'Encargado de Planes y Protocolos', 'renglones_id' => 5, 'cantidad' => 1, 'jefe' => 1],
            ['codigo' => '71752', 'puesto' => 'Encargado de Planificación y Procedimientos', 'renglones_id' => 5, 'cantidad' => 1, 'jefe' => 1],
            ['codigo' => '71756', 'puesto' => 'Encargado de Politicas Públicas', 'renglones_id' => 5, 'cantidad' => 1, 'jefe' => 1],
            ['codigo' => '71845', 'puesto' => 'Encargado de Presupuesto', 'renglones_id' => 5, 'cantidad' => 1, 'jefe' => 1],
            ['codigo' => '80451', 'puesto' => 'Encargado de Prevención de Volcanes', 'renglones_id' => 5, 'cantidad' => 1, 'jefe' => 1],
            ['codigo' => '74709', 'puesto' => 'Encargado de Procesos Operativos Territoriales', 'renglones_id' => 5, 'cantidad' => 1, 'jefe' => 1],
            ['codigo' => '74691', 'puesto' => 'Encargado de Producción', 'renglones_id' => 5, 'cantidad' => 1, 'jefe' => 1],
            ['codigo' => '74688', 'puesto' => 'Encargado de Protocolo', 'renglones_id' => 5, 'cantidad' => 1, 'jefe' => 1],
            ['codigo' => '80455', 'puesto' => 'Encargado de Proyectos de Preparación', 'renglones_id' => 5, 'cantidad' => 1, 'jefe' => 1],
            ['codigo' => '79731', 'puesto' => 'Encargado de Recuperación de Infraestructura Física y Medio Ambiente', 'renglones_id' => 5, 'cantidad' => 1, 'jefe' => 1],
            ['codigo' => '80453', 'puesto' => 'Encargado de Recuperación Medios de Vida', 'renglones_id' => 5, 'cantidad' => 1, 'jefe' => 1],
            ['codigo' => '79732', 'puesto' => 'Encargado de Recuperación Social y Humana', 'renglones_id' => 5, 'cantidad' => 1, 'jefe' => 1],
            ['codigo' => '71801', 'puesto' => 'Encargado de Sección eri', 'renglones_id' => 5, 'cantidad' => 1, 'jefe' => 1],
            ['codigo' => '71853', 'puesto' => 'Encargado de Servicios Internos', 'renglones_id' => 5, 'cantidad' => 1, 'jefe' => 1],
            ['codigo' => '71760', 'puesto' => 'Encargado de Sistema de Alerta Temprana', 'renglones_id' => 5, 'cantidad' => 1, 'jefe' => 1],
            ['codigo' => '71809', 'puesto' => 'Encargado de Sistema de Enlaces', 'renglones_id' => 5, 'cantidad' => 1, 'jefe' => 1],
            ['codigo' => '74698', 'puesto' => 'Encargado de Sistema de Información Geográfica', 'renglones_id' => 5, 'cantidad' => 1, 'jefe' => 1],
            ['codigo' => '80456', 'puesto' => 'Encargado de Soporte Sectorial', 'renglones_id' => 5, 'cantidad' => 1, 'jefe' => 1],
            ['codigo' => '71846', 'puesto' => 'Encargado de Tesorería', 'renglones_id' => 5, 'cantidad' => 1, 'jefe' => 1],
            ['codigo' => '71832', 'puesto' => 'Encargado de Transmisiones', 'renglones_id' => 5, 'cantidad' => 1, 'jefe' => 1],
            ['codigo' => '71834', 'puesto' => 'Encargado de Transporte', 'renglones_id' => 5, 'cantidad' => 1, 'jefe' => 1],
            ['codigo' => '71753', 'puesto' => 'Encargado de Vulnerabilidades', 'renglones_id' => 5, 'cantidad' => 1, 'jefe' => 1],
            ['codigo' => '74708', 'puesto' => 'Encargado Equipos de Intervención Estratégica', 'renglones_id' => 5, 'cantidad' => 1, 'jefe' => 1],
            ['codigo' => '74176', 'puesto' => 'Jefe COE Permanente', 'renglones_id' => 5, 'cantidad' => 1, 'jefe' => 1],
            ['codigo' => '71775', 'puesto' => 'Jefe de Respuesta', 'renglones_id' => 5, 'cantidad' => 1, 'jefe' => 1],
            ['codigo' => '71778', 'puesto' => 'Oficial de Monitoreo', 'renglones_id' => 5, 'cantidad' => 1, 'jefe' => 0],
            ['codigo' => '71777', 'puesto' => 'Oficial de Situación', 'renglones_id' => 5, 'cantidad' => 1, 'jefe' => 0],
            ['codigo' => '71738', 'puesto' => 'Secretaria de Secretaría Ejecutiva', 'renglones_id' => 5, 'cantidad' => 1, 'jefe' => 0],
            ['codigo' => '74806', 'puesto' => 'Técnico Administrativo de Información Pública', 'renglones_id' => 5, 'cantidad' => 1, 'jefe' => 0],
            ['codigo' => '74687', 'puesto' => 'Técnico de Archivo General', 'renglones_id' => 5, 'cantidad' => 1, 'jefe' => 0],
            ['codigo' => '74711', 'puesto' => 'Analista Financiero', 'renglones_id' => 5, 'cantidad' => 2, 'jefe' => 0],
            ['codigo' => '74051', 'puesto' => 'Asistente Subsecretaría Ejecutiva', 'renglones_id' => 5, 'cantidad' => 2, 'jefe' => 0],
            ['codigo' => '74701', 'puesto' => 'Oficial de Procesamiento de Informacion', 'renglones_id' => 5, 'cantidad' => 2, 'jefe' => 0],
            ['codigo' => '74693', 'puesto' => 'Recepcionista', 'renglones_id' => 5, 'cantidad' => 2, 'jefe' => 0],
            ['codigo' => '74692', 'puesto' => 'Técnico de Redes Sociales', 'renglones_id' => 5, 'cantidad' => 2, 'jefe' => 0],
            ['codigo' => '71854', 'puesto' => 'Auxiliar de Compras', 'renglones_id' => 5, 'cantidad' => 3, 'jefe' => 0],
            ['codigo' => '71788', 'puesto' => 'Jefe de COED', 'renglones_id' => 5, 'cantidad' => 3, 'jefe' => 1],
            ['codigo' => '71779', 'puesto' => 'Oficial de Servicio', 'renglones_id' => 5, 'cantidad' => 3, 'jefe' => 0],
            ['codigo' => '80450', 'puesto' => 'Piloto', 'renglones_id' => 5, 'cantidad' => 3, 'jefe' => 0],
            ['codigo' => '79730', 'puesto' => 'Técnico de Gestion Integral de Reducción de Riesgo a Desastres', 'renglones_id' => 5, 'cantidad' => 3, 'jefe' => 0],
            ['codigo' => '80452', 'puesto' => 'Técnico en Prevencion de Volcanes', 'renglones_id' => 5, 'cantidad' => 3, 'jefe' => 0],
            ['codigo' => '74696', 'puesto' => 'Asistente de Dirección', 'renglones_id' => 5, 'cantidad' => 5, 'jefe' => 0],
            ['codigo' => '74703', 'puesto' => 'Técnico de emergencias', 'renglones_id' => 5, 'cantidad' => 5, 'jefe' => 0],
            ['codigo' => '71791', 'puesto' => 'Radioperador', 'renglones_id' => 5, 'cantidad' => 6, 'jefe' => 0],
            ['codigo' => '74704', 'puesto' => 'Técnico Administrativo Contable', 'renglones_id' => 5, 'cantidad' => 7, 'jefe' => 0],
            ['codigo' => '74707', 'puesto' => 'Delegado Regional', 'renglones_id' => 5, 'cantidad' => 8, 'jefe' => 1],
            ['codigo' => '71794', 'puesto' => 'Técnico de Campo', 'renglones_id' => 5, 'cantidad' => 10, 'jefe' => 0],
            ['codigo' => '71835', 'puesto' => 'Auxiliar de Almacén', 'renglones_id' => 5, 'cantidad' => 11, 'jefe' => 0],
            ['codigo' => '71795', 'puesto' => 'Delegado Departamental', 'renglones_id' => 5, 'cantidad' => 22, 'jefe' => 0],

            /* 022 */
            ['codigo' => '72677', 'puesto' => 'Subdirector Ejecutivo I', 'renglones_id' => 6, 'cantidad' => 2, 'jefe' => 1],
            ['codigo' => '72672', 'puesto' => 'Subdirector Ejecutivo III', 'renglones_id' => 6, 'cantidad' => 20, 'jefe' => 1],
            ['codigo' => '72671', 'puesto' => 'Director Ejecutivo III', 'renglones_id' => 6, 'cantidad' => 15, 'jefe' => 1],

            /* 031 */
            ['codigo' => '74986', 'puesto' => 'Peón Vigilante I', 'renglones_id' => 11, 'cantidad' => 135, 'jefe' => 0],
            ['codigo' => '74987', 'puesto' => 'Peón Vigilante V', 'renglones_id' => 11, 'cantidad' => 15, 'jefe' => 0],

        ];

        foreach ($puestosData as $puestos) {
            CatalogoPuesto::create([
                'codigo' => $puestos['codigo'],
                'puesto' => $puestos['puesto'],
                'renglones_id' => $puestos['renglones_id'],
                'cantidad' => $puestos['cantidad'],
                'jefe' => $puestos['jefe']
            ]);
        }
    }
}
