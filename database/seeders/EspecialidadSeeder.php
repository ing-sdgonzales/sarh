<?php

namespace Database\Seeders;

use App\Models\Especialidad;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EspecialidadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $especialidadData =  [
            ['codigo' => '0', 'especialidad' => 'Sin especialidad'],
            ['codigo' => '6', 'especialidad' => 'Actividades secretariales'],
            ['codigo' => '7', 'especialidad' => 'Administración'],
            ['codigo' => '9', 'especialidad' => 'Administración educativa'],
            ['codigo' => '14', 'especialidad' => 'Administración de personal'],
            ['codigo' => '15', 'especialidad' => 'Administración de recursos humanos'],
            ['codigo' => '24', 'especialidad' => 'Albañilería'],
            ['codigo' => '27', 'especialidad' => 'Almacenaje'],
            ['codigo' => '28', 'especialidad' => 'Análisis de documentos'],
            ['codigo' => '36', 'especialidad' => 'Archivología'],
            ['codigo' => '40', 'especialidad' => 'Arquitectura'],
            ['codigo' => '44', 'especialidad' => 'Artes y oficios'],
            ['codigo' => '45', 'especialidad' => 'Asesoría'],
            ['codigo' => '48', 'especialidad' => 'Auditoría'],
            ['codigo' => '51', 'especialidad' => 'Bibliotecología'],
            ['codigo' => '59', 'especialidad' => 'Catastro'],
            ['codigo' => '67', 'especialidad' => 'Preparación de alimentos'],
            ['codigo' => '69', 'especialidad' => 'Computación'],
            ['codigo' => '70', 'especialidad' => 'Compras y suministros'],
            ['codigo' => '76', 'especialidad' => 'Conserjería'],
            ['codigo' => '77', 'especialidad' => 'Construcción civil'],
            ['codigo' => '82', 'especialidad' => 'Contabilidad'],
            ['codigo' => '92', 'especialidad' => 'Ciudado de niños'],
            ['codigo' => '96', 'especialidad' => 'Derecho'],
            ['codigo' => '108', 'especialidad' => 'Derecho de trabajo'],
            ['codigo' => '121', 'especialidad' => 'Economía'],
            ['codigo' => '125', 'especialidad' => 'Educación'],
            ['codigo' => '134', 'especialidad' => 'Electricidad'],
            ['codigo' => '140', 'especialidad' => 'Equipos pesados'],
            ['codigo' => '144', 'especialidad' => 'Estadística'],
            ['codigo' => '157', 'especialidad' => 'Finanzas'],
            ['codigo' => '167', 'especialidad' => 'Fotografía'],
            ['codigo' => '181', 'especialidad' => 'Grabados en acero'],
            ['codigo' => '182', 'especialidad' => 'Resguardo y vigilancia'],
            ['codigo' => '185', 'especialidad' => 'Herrería'],
            ['codigo' => '192', 'especialidad' => 'Impresión'],
            ['codigo' => '197', 'especialidad' => 'Ingeniería civil'],
            ['codigo' => '209', 'especialidad' => 'Investigación delicitiva'],
            ['codigo' => '213', 'especialidad' => 'Jardinería'],
            ['codigo' => '216', 'especialidad' => 'Lavandería'],
            ['codigo' => '227', 'especialidad' => 'Construcción y mantenimiento de edificios'],
            ['codigo' => '234', 'especialidad' => 'Mecánica'],
            ['codigo' => '236', 'especialidad' => 'Medicina'],
            ['codigo' => '245', 'especialidad' => 'Mensajería'],
            ['codigo' => '253', 'especialidad' => 'Música'],
            ['codigo' => '268', 'especialidad' => 'Odontología'],
            ['codigo' => '269', 'especialidad' => 'Oficina'],
            ['codigo' => '301', 'especialidad' => 'Pediatría'],
            ['codigo' => '304', 'especialidad' => 'Periodismo'],
            ['codigo' => '309', 'especialidad' => 'Planificación'],
            ['codigo' => '310', 'especialidad' => 'Plomería'],
            ['codigo' => '311', 'especialidad' => 'Presupuesto'],
            ['codigo' => '317', 'especialidad' => 'Promoción social'],
            ['codigo' => '319', 'especialidad' => 'Psicología'],
            ['codigo' => '323', 'especialidad' => 'Radio y televisión'],
            ['codigo' => '331', 'especialidad' => 'Recepción impuestos'],
            ['codigo' => '340', 'especialidad' => 'Relaciones públicas'],
            ['codigo' => '345', 'especialidad' => 'Reproducción de materiales'],
            ['codigo' => '366', 'especialidad' => 'Técnicas audiovisuales'],
            ['codigo' => '372', 'especialidad' => 'Topografía'],
            ['codigo' => '375', 'especialidad' => 'Trabajo social'],
            ['codigo' => '379', 'especialidad' => 'Valuación de bienes inmuebles'],
            ['codigo' => '382', 'especialidad' => 'Conducción de vehiculos'],
            ['codigo' => '383', 'especialidad' => 'Publicidad'],
            ['codigo' => '386', 'especialidad' => 'Operación y mantenimiento maquinaria y equipo'],
            ['codigo' => '389', 'especialidad' => 'Asesoría jurídica'],
            ['codigo' => '393', 'especialidad' => 'Seguridad Personal'],
            ['codigo' => '394', 'especialidad' => 'Inspección de trabajo'],
            ['codigo' => '396', 'especialidad' => 'Prueba de materiales y suelos'],
            ['codigo' => '412', 'especialidad' => 'Informática'],
            ['codigo' => '413', 'especialidad' => 'Programación y mantenimiento de sistemas'],
            ['codigo' => '416', 'especialidad' => 'Evaluador de proyectos'],
            ['codigo' => '418', 'especialidad' => 'Administración y recreación'],
            ['codigo' => '427', 'especialidad' => 'Cooperación técnica'],
            ['codigo' => '430', 'especialidad' => 'Documentación técnica'],
            ['codigo' => '439', 'especialidad' => 'Programación'],
            ['codigo' => '441', 'especialidad' => 'Control de calidad'],
            ['codigo' => '445', 'especialidad' => 'Enfermería auxiliar'],
            ['codigo' => '449', 'especialidad' => 'Servicio de alimentos'],
            ['codigo' => '452', 'especialidad' => 'Encuadernación'],
            ['codigo' => '465', 'especialidad' => 'Mantenimiento de maquinaría industrial'],
            ['codigo' => '466', 'especialidad' => 'Impresiones fiscales'],
            ['codigo' => '467', 'especialidad' => 'Seguridad'],
            ['codigo' => '469', 'especialidad' => 'Operación de ascensores'],
            ['codigo' => '476', 'especialidad' => 'Diseño gráfico']
        ];

        foreach ($especialidadData as $especialidad) {
            Especialidad::create([
                'codigo' => $especialidad['codigo'],
                'especialidad' => $especialidad['especialidad']
            ]);
        }
    }
}
