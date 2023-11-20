<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $super = Role::create(['name' => 'Súper Administrador']);
        $administrador = Role::create(['name' => 'Administrador']);
        $operativo = Role::create(['name' => 'Operativo']);

        /* Permiso para ver la ruta /bitácora */
        Permission::create(['name' => 'Ver bitácora'])->syncRoles([$administrador]);

        /* Permiso para ver la ruta /usuarios */
        Permission::create(['name' => 'Ver usuarios'])->syncRoles([$administrador]);
        Permission::create(['name' => 'Crear usuarios'])->syncRoles([$administrador]);
        Permission::create(['name' => 'Editar usuarios'])->syncRoles([$administrador]);
        Permission::create(['name' => 'Eliminar usuarios'])->syncRoles([$super]);

        /* Permiso para ver la ruta /roles */
        Permission::create(['name' => 'Ver roles'])->syncRoles([$administrador]);
        /* Permisos CRUD para la vista puestos */
        Permission::create(['name' => 'Crear roles'])->syncRoles([$super]);
        Permission::create(['name' => 'Editar roles'])->syncRoles([$super, $administrador]);
        Permission::create(['name' => 'Asignar permisos'])->syncRoles([$super, $administrador]);

        /* Permiso para ver la ruta /dashboard */
        Permission::create(['name' => 'Ver dashboard'])->syncRoles([$administrador, $operativo]);

        /* Permisos para la ruta de requisitos */
        Permission::create(['name' => 'Ver requisitos'])->syncRoles([$administrador, $operativo]);
        /* Permisos CRUD para la vista /requisitos */
        Permission::create(['name' => 'Crear requisitos'])->syncRoles([$administrador, $operativo]);
        Permission::create(['name' => 'Editar requisitos'])->syncRoles([$administrador, $operativo]);

        /* Permiso para ver la ruta /puestos */
        Permission::create(['name' => 'Ver puestos'])->syncRoles([$administrador, $operativo]);
        /* Permisos CRUD para la vista /puestos */
        Permission::create(['name' => 'Crear puestos'])->syncRoles([$administrador, $operativo]);
        Permission::create(['name' => 'Editar puestos'])->syncRoles([$administrador, $operativo]);
        Permission::create(['name' => 'Asignar requisitos'])->syncRoles([$administrador, $operativo]);

        /* Permiso para ver la ruta /candidatos */
        Permission::create(['name' => 'Ver candidatos'])->syncRoles([$administrador, $operativo]);
        /* Permisos CRUD para la vista /candidatos */
        Permission::create(['name' => 'Crear candidatos'])->syncRoles([$administrador, $operativo]);
        Permission::create(['name' => 'Editar candidatos'])->syncRoles([$administrador, $operativo]);
        Permission::create(['name' => 'Registrar entrevista'])->syncRoles([$administrador, $operativo]);
        Permission::create(['name' => 'Ver expediente'])->syncRoles([$administrador, $operativo]);
        Permission::create(['name' => 'Crear pruebas técnicas'])->syncRoles([$administrador, $operativo]);
        Permission::create(['name' => 'Crear pruebas psicométricas'])->syncRoles([$administrador, $operativo]);
        Permission::create(['name' => 'Crear informes de evaluación'])->syncRoles([$administrador, $operativo]);
        Permission::create(['name' => 'Asignar fechas de ingresos'])->syncRoles([$administrador, $operativo]);

        /* Permisos CRUD para la vista /expediente_candidato */
        Permission::create(['name' => 'Verificar requisitos'])->syncRoles([$administrador, $operativo]);
        Permission::create(['name' => 'Ver formulario'])->syncRoles([$administrador, $operativo]);
        Permission::create(['name' => 'Notificar requisitos'])->syncRoles([$administrador, $operativo]);
        Permission::create(['name' => 'Ver etapas'])->syncRoles([$administrador, $operativo]);

        if ($super) {
            $super->syncPermissions(Permission::all());
        }
    }
}
