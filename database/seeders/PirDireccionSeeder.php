<?php

namespace Database\Seeders;

use App\Models\PirDireccion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PirDireccionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $direcciones = [
            ['dir' => 'Secretaría Ejecutiva', 'sec' => 1],
            ['dir' => 'Subsecretaría de Coordinación y Administración', 'sec' => 1],
            ['dir' => 'Subsecretaría de Gestion de Reducción del Riesgo', 'sec' => 1],
            ['dir' => 'Dirección Administrativa', 'sec' => 13],
            ['dir' => 'Direccion Financiera', 'sec' => 13],
            ['dir' => 'Direccion de Coordinacion', 'sec' => 3],
            ['dir' => 'Direccion de Logística', 'sec' => 11],
            ['dir' => 'Inspectoria General', 'sec' => 4],
            ['dir' => 'Unidad de Auditoría Interna', 'sec' => 8],
            ['dir' => 'Dirección de Recursos Humanos', 'sec' => 13],
            ['dir' => 'Dirección de Planificación y Desarrollo Institucional', 'sec' => 12],
            ['dir' => 'Unidad de Información Pública', 'sec' => 2],
            ['dir' => 'Unidad de Asesoria Específica', 'sec' => 3],
            ['dir' => 'Dirección de Asesoria Jurídica', 'sec' => 5],
            ['dir' => 'Unidad de Género', 'sec' => 12],
            ['dir' => 'Dirección de Gestion Integral de Reduccion de Riesgos a Desastres', 'sec' => 12],
            ['dir' => 'Dirección de Mitigación', 'sec' => 9],
            ['dir' => 'Dirección de Preparación', 'sec' => 12],
            ['dir' => 'Dirección de Respuesta', 'sec' => 9],
            ['dir' => 'Dirección de Recuperación', 'sec' => 9],
            ['dir' => 'Dirección de Sistema de Comando de Incidentes - SCI', 'sec' => 10],
            ['dir' => 'Dirección de Comunicacion Social', 'sec' => 2],
        ];

        $permiso = Permission::create(['name' => 'Crear PIR']);
        $permiso = Permission::create(['name' => 'Consolidar PIR']);

        foreach ($direcciones as $direccion) {
            PirDireccion::create([
                'direccion' => $direccion['dir'],
                'pir_seccion_id' => $direccion['sec']
            ]);
            $rol = Role::create([
                'name' => $direccion['dir']
            ]);

            $permiso->assignRole($rol);
        }
    }
}
