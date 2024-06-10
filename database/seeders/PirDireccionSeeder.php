<?php

namespace Database\Seeders;

use App\Models\PirDireccion;
use App\Models\Region;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

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
            ['dir' => 'Subsecretaría de Gestión de Reducción del Riesgo', 'sec' => 1],
            ['dir' => 'Dirección Administrativa', 'sec' => 13],
            ['dir' => 'Dirección Financiera', 'sec' => 13],
            ['dir' => 'Dirección de Coordinación', 'sec' => 3],
            ['dir' => 'Dirección de Logística', 'sec' => 11],
            ['dir' => 'Inspectoría General', 'sec' => 4],
            ['dir' => 'Unidad de Auditoría Interna', 'sec' => 8],
            ['dir' => 'Dirección de Recursos Humanos', 'sec' => 13],
            ['dir' => 'Dirección de Planificación y Desarrollo Institucional', 'sec' => 12],
            ['dir' => 'Unidad de Información Pública', 'sec' => 2],
            ['dir' => 'Unidad de Asesoría Específica', 'sec' => 3],
            ['dir' => 'Dirección de Asesoría Jurídica', 'sec' => 5],
            ['dir' => 'Unidad de Género', 'sec' => 12],
            ['dir' => 'Dirección de Gestión Integral de Reducción de Riesgos a Desastres', 'sec' => 12],
            ['dir' => 'Dirección de Mitigación', 'sec' => 9],
            ['dir' => 'Dirección de Preparación', 'sec' => 12],
            ['dir' => 'Dirección de Respuesta', 'sec' => 9],
            ['dir' => 'Dirección de Recuperación', 'sec' => 9],
            ['dir' => 'Dirección de Sistema de Comando de Incidentes - SCI', 'sec' => 10],
            ['dir' => 'Dirección de Comunicación Social', 'sec' => 2],
            ['dir' => 'Región I', 'sec' => null],
            ['dir' => 'Región II', 'sec' => null],
            ['dir' => 'Región III', 'sec' => null],
            ['dir' => 'Región IV', 'sec' => null],
            ['dir' => 'Región V', 'sec' => null],
            ['dir' => 'Región VI', 'sec' => null],
            ['dir' => 'Región VII', 'sec' => null],
            ['dir' => 'Región VIII', 'sec' => null]
        ];

        $permiso = Permission::create(['name' => 'Consolidar PIR']);
        $pir = Permission::create(['name' => 'Generar PIR']);

        foreach ($direcciones as $direccion) {
            PirDireccion::create([
                'direccion' => $direccion['dir'],
                'pir_seccion_id' => $direccion['sec']
            ]);

            $rol = Role::create([
                'name' => $direccion['dir']
            ]);

            if ($rol->name == 'Dirección de Recursos Humanos') {
                $permiso->assignRole($rol);
                $pir->assignRole($rol);
            }
        }
    }
}
