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

        /* Permiso para ver la ruta /roles */
        Permission::create(['name' => 'Ver roles'])->syncRoles([$administrador]);
        /* Permisos CRUD para la vista puestos */
        Permission::create(['name' => 'Crear roles'])->syncRoles([$super]);
        Permission::create(['name' => 'Editar roles'])->syncRoles([$super, $administrador]);
        Permission::create(['name' => 'Asignar permisos'])->syncRoles([$super, $administrador]);

        /* Permiso para ver la ruta /dashboard */
        Permission::create(['name' => 'Ver dashboard'])->syncRoles([$administrador, $operativo]);

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
        Permission::create(['name' => 'Verificar requisitos'])->syncRoles([$administrador, $operativo]);

        if ($super) {
            $super->syncPermissions(Permission::all());
        }
    }
}
