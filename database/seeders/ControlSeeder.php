<?php

namespace Database\Seeders;

use App\Models\DependenciaFuncional;
use App\Models\DependenciaNominal;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ControlSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dependencias = [
            /* Secretaría y subsecretarías */
            ['nombre' => 'Secretaría Ejecutiva', 'nodo' => null], //1
            ['nombre' => 'Subsecretaría de Gestión de la Reducción del Riesgo', 'nodo' => 1], //2
            ['nombre' => 'Subsecretaría de Coordinación y Administración', 'nodo' => 1], //3
            ['nombre' => 'Inspectoría General', 'nodo' => 1], //4
            ['nombre' => 'Dirección de Asesoría Jurídica', 'nodo' => 1], //5
            ['nombre' => 'Unidad de Asesoría Específica', 'nodo' => 1], //6
            ['nombre' => 'Unidad de Género', 'nodo' => 1], //7
            ['nombre' => 'Dirección de Planificación y Desarrollo Institucional', 'nodo' => 1], //8
            ['nombre' => 'Departamento de Planes y Programas', 'nodo' => 8], //9
            ['nombre' => 'Unidad de Información Pública', 'nodo' => 1], //10
            ['nombre' => 'Unidad de Auditoría Interna', 'nodo' => 1], //11

            /* Direcciones */
            ['nombre' => 'Dirección de Gestión Integral de Reducción de Riesgos a Desastres', 'nodo' => 2], //12
            ['nombre' => 'Dirección de Mitigación', 'nodo' => 2], //13
            ['nombre' => 'Dirección de Preparación', 'nodo' => 2], //14
            ['nombre' => 'Dirección de Respuesta', 'nodo' => 2], //15
            ['nombre' => 'Dirección de Recuperación', 'nodo' => 2], //16
            ['nombre' => 'Dirección del Sistema de Comando de Incidentes', 'nodo' => 2], //17

            ['nombre' => 'Dirección de Coordinación', 'nodo' => 3], //18
            ['nombre' => 'Dirección de Comunicación Social', 'nodo' => 3], //19
            ['nombre' => 'Dirección de Logística', 'nodo' => 3], //20
            ['nombre' => 'Dirección de Recursos Humanos', 'nodo' => 3], //21
            ['nombre' => 'Dirección de Financiera', 'nodo' => 3], //22
            ['nombre' => 'Dirección de Administrativa', 'nodo' => 3], //23

            /* Subdirecciones */
            ['nombre' => 'Subdirección de Gestión Integral de Reducción de Riesgos a Desastres', 'nodo' => 12], //24
            ['nombre' => 'Subdirección de Mitigación', 'nodo' => 13], //25
            ['nombre' => 'Subdirección de Preparación', 'nodo' => 14], //26
            ['nombre' => 'Subdirección Académica', 'nodo' => 14], //27
            ['nombre' => 'Subdirección de Respuesta', 'nodo' => 15], //28
            ['nombre' => 'Subdirección de Territorial', 'nodo' => 15], //29
            ['nombre' => 'Subdirección de Recuperación', 'nodo' => 16], //30
            ['nombre' => 'Subdirección del Sistema de Comando de Incidentes', 'nodo' => 17], //31
            ['nombre' => 'Subdirección de Incendios', 'nodo' => 17], //32

            ['nombre' => 'Subdirección de Enlaces y Proyectos', 'nodo' => 18], //33
            ['nombre' => 'Subdirección de Cooperación', 'nodo' => 18], //34
            ['nombre' => 'Subdirección de Comunicación Social', 'nodo' => 19], //35
            ['nombre' => 'Subdirección de Tecnología', 'nodo' => 20], //36
            ['nombre' => 'Subdirección Operativa', 'nodo' => 20], //37
            ['nombre' => 'Subdirección de Recursos Humanos', 'nodo' => 21], //38
            ['nombre' => 'Subdirección de Financiera', 'nodo' => 22], //39
            ['nombre' => 'Subdirección de Administrativa', 'nodo' => 23], //40

            /* Departamentos */
            ['nombre' => 'Departamento de Planificación y Procedimientos', 'nodo' => 24], //41
            ['nombre' => 'Departamento de Vulnerabilidades', 'nodo' => 24], //42
            ['nombre' => 'Departamento de Planes y Protocolo', 'nodo' => 24], //43
            ['nombre' => 'Departamento de Apoyo Social', 'nodo' => 24], //44
            ['nombre' => 'Departamento de Políticas Públicas', 'nodo' => 24], //45

            ['nombre' => 'Departamento de Alerta de Sistema de Alerta Temprana', 'nodo' => 25], //46
            ['nombre' => 'Departamento de Obras de Infraestructura', 'nodo' => 25], //47
            ['nombre' => 'Departamento de Monitoreo y Análisis de Riesgo', 'nodo' => 25], //48
            ['nombre' => 'Departamento de Normas', 'nodo' => 25], //49
            ['nombre' => 'Departamento de Investigación', 'nodo' => 25], //50

            ['nombre' => 'Departamento de Fortalecimientos Sistema CONRED', 'nodo' => 26], //51
            ['nombre' => 'Departamento de Organización Nacional', 'nodo' => 26], //52
            ['nombre' => 'Departamento de Proyecto de Preparación', 'nodo' => 26], //53
            ['nombre' => 'Departamento de Soporte Sectorial', 'nodo' => 26], //54

            ['nombre' => 'Departamento de Educación', 'nodo' => 27], //55

            ['nombre' => 'Jefatura de COE Permanente', 'nodo' => 28], //56
            ['nombre' => 'Jefatura de COE Permanente', 'nodo' => 28], //57

            ['nombre' => 'Departamento de Equipos de Investigación Estratégica', 'nodo' => 29], //58
            ['nombre' => 'Departamento de Convenios y Acuerdos Territoriales', 'nodo' => 29], //59
            ['nombre' => 'Departamento de Procesos Operativos Territoriales', 'nodo' => 29], //60
            ['nombre' => 'Departamento de Prevención en Volcanes', 'nodo' => 29], //61
            ['nombre' => 'Departamento Administrativo Contable', 'nodo' => 29], //62
            ['nombre' => 'Delegaciones Regionales', 'nodo' => 29], //63
            ['nombre' => 'Delegaciones Departamentales', 'nodo' => 63], //64

            ['nombre' => 'Departamento de Recuperación de Infraestructura Física y Medioambiente', 'nodo' => 30], //65
            ['nombre' => 'Departamento de Recuperación Social y Humana', 'nodo' => 30], //66
            ['nombre' => 'Departamento de Coordinación Territorial para la Recuperación', 'nodo' => 30], //67
            ['nombre' => 'Departamento de Recuperación de Medios de Vida', 'nodo' => 30], //68

            ['nombre' => 'Departamento de Equipos de Respuesta Inmediata', 'nodo' => 31], //69
            ['nombre' => 'Departamento de Grupo de Respuesta a Incidentes con Materiales Peligrosos', 'nodo' => 31], //70

            ['nombre' => 'Departamento de Operaciones BRIF', 'nodo' => 32], //71

            ['nombre' => 'Departamento de Sistema de Enlaces', 'nodo' => 33], //72

            ['nombre' => 'Departamento de Gestión de Cooperación Nacional', 'nodo' => 34], //73
            ['nombre' => 'Departamento de Cooperación Internacional', 'nodo' => 34], //74

            ['nombre' => 'Departamento de CONRED Radio', 'nodo' => 35], //75
            ['nombre' => 'Departamento de Producción', 'nodo' => 35], //76
            ['nombre' => 'Departamento de Diseño Gráfico', 'nodo' => 35], //75
            ['nombre' => 'Departamento de Protocolo', 'nodo' => 35], //76

            ['nombre' => 'Departamento de Informática', 'nodo' => 36], //77
            ['nombre' => 'Departamento de Sistema de Información Geográfica', 'nodo' => 36], //78
            ['nombre' => 'Departamento de Transmisiones', 'nodo' => 36], //79

            ['nombre' => 'Departamento de Bodega', 'nodo' => 37], //80
            ['nombre' => 'Departamento de Transporte', 'nodo' => 37], //81

            ['nombre' => 'Departamento de Administración y Dotación de Personal', 'nodo' => 38], //82
            ['nombre' => 'Departamento de Gestión y Acciones de personal', 'nodo' => 38], //83
            ['nombre' => 'Departamento de Nómina', 'nodo' => 38], //84
            ['nombre' => 'Departamento de Bienestar y Desarrollo Laboral', 'nodo' => 38], //85

            ['nombre' => 'Departamento de Contabilidad', 'nodo' => 39], //86
            ['nombre' => 'Departamento de Presupuesto', 'nodo' => 39], //87
            ['nombre' => 'Departamento de Tesorería', 'nodo' => 39], //88
            ['nombre' => 'Departamento de Fondo Rotativo', 'nodo' => 39], //89

            ['nombre' => 'Departamento de Compras', 'nodo' => 40], //90
            ['nombre' => 'Departamento de Inventario', 'nodo' => 40], //91
            ['nombre' => 'Departamento de Servicios Internos', 'nodo' => 40], //92
            ['nombre' => 'Departamento de Fondo Rotativo', 'nodo' => 40], //93
        ];

        $controlesData = [
            'Secretaría Ejecutiva',
            'Subsecretaría de Coordinación y Administración',
            'Subsecretaría de Gestión de Reducción del Riesgo',
            'Dirección Administrativa',
            'Dirección Financiera',
            'Dirección de Coordinación',
            'Dirección de Logística',
            'Inspectoría General',
            'Unidad de Auditoría Interna',
            'Dirección de Recursos Humanos',
            'Dirección de Planificación y Desarrollo Institucional',
            'Unidad de Información Pública',
            'Unidad de Asesoria Específica',
            'Dirección de Asesoria Jurídica',
            'Unidad de Género',
            'Dirección de Gestión Integral de Reducción de Riesgos a Desastres',
            'Dirección de Mitigación',
            'Dirección de Preparación',
            'Dirección de Respuesta',
            'Dirección de Recuperación',
            'Dirección de Sistema de Comando de Incidentes - SCI',
            'Dirección de Comunicación Social'
        ];

        foreach ($dependencias as $dependencia) {
            DependenciaNominal::create([
                'dependencia' => $dependencia['nombre'],
                'nodo_padre' => $dependencia['nodo']
            ]);
        }
        foreach ($controlesData as $control) {
            DependenciaFuncional::create([
                'dependencia' => $control
            ]);
        }
    }
}
