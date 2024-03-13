<?php

namespace Database\Seeders;

use App\Livewire\Permisos\Permiso;
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
        $empleado = Role::create(['name' => 'Empleado']);

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

        /* Permiso para ver la ruta de /empleados */
        Permission::create(['name' => 'Ver empleados'])->syncRoles([$administrador, $operativo]);
        /* Permisos CRUD para la vista /empleados */
        Permission::create(['name' => 'Crear empleados'])->syncRoles([$administrador, $operativo]);
        Permission::create(['name' => 'Editar empleados'])->syncRoles([$administrador, $operativo]);
        Permission::create(['name' => 'Crear contratos'])->syncRoles([$administrador, $operativo]);
        Permission::create(['name' => 'Ver contratos'])->syncRoles([$administrador, $operativo]);

        /* Permiso para ver la ruta de /contratos */
        Permission::create(['name' => 'Editar contratos'])->syncRoles([$administrador, $operativo]);
        Permission::create(['name' => 'Crear puestos en contrato'])->syncRoles([$administrador, $operativo]);
        Permission::create(['name' => 'Ver historial de puestos'])->syncRoles([$administrador, $operativo]);

        Permission::create(['name' => 'Editar puestos en contrato'])->syncRoles([$administrador, $operativo]);

        /* Permiso para ver la ruta de /catalogo_puestos */
        Permission::create(['name' => 'Ver catálogo de puestos'])->syncRoles([$administrador, $operativo]);
        /* Permisos CRUD para la vista /catalogo_puestos */
        Permission::create(['name' => 'Crear puestos en catálogo'])->syncRoles([$administrador, $operativo]);
        Permission::create(['name' => 'Editar catálogo de puestos'])->syncRoles([$administrador, $operativo]);

        /* Permisos CRUD para la vista /expediente_candidato */
        Permission::create(['name' => 'Verificar requisitos'])->syncRoles([$administrador, $operativo]);
        Permission::create(['name' => 'Ver formulario'])->syncRoles([$administrador, $operativo]);
        Permission::create(['name' => 'Notificar requisitos'])->syncRoles([$administrador, $operativo]);
        Permission::create(['name' => 'Ver etapas'])->syncRoles([$administrador, $operativo]);

        /* Permiso para ver la ruta /historial_medico */
        Permission::create(['name' => 'Ver historial médico'])->syncRoles([$administrador, $operativo]);

        /* Permiso para ver la ruta /consultas */
        Permission::create(['name' => 'Ver consulta médica'])->syncRoles([$administrador, $operativo]);
        /* Permisos CRUD para la vista /consultas */
        Permission::create(['name' => 'Crear consulta médica'])->syncRoles([$administrador, $operativo]);
        Permission::create(['name' => 'Editar consulta médica'])->syncRoles([$administrador, $operativo]);

        /* Permiso para ver la ruta de /capacitaciones */
        Permission::create(['name' => 'Ver capacitaciones'])->syncRoles([$administrador, $operativo]);
        /* Permisos CRUD para la vista /capacitaciones */
        Permission::create(['name' => 'Crear capacitaciones'])->syncRoles([$administrador, $operativo]);
        Permission::create(['name' => 'Editar capacitaciones'])->syncRoles([$administrador, $operativo]);

        /* Permiso para ver la ruta de /sesiones_capacitacion */
        Permission::create(['name' => 'Ver sesiones de capacitación'])->syncRoles([$administrador, $operativo]);
        /* Permisos CRUD para la vista /sesiones_capacitacion */
        Permission::create(['name' => 'Crear sesiones de capacitación'])->syncRoles([$administrador, $operativo]);
        Permission::create(['name' => 'Editar sesiones de capacitación'])->syncRoles([$administrador, $operativo]);

        /* Permiso para ver la ruta de /vacaciones */
        Permission::create(['name' => 'Ver vacaciones'])->syncRoles([$administrador, $operativo]);

        /* Permiso para ver la ruta de /control_vacaciones */
        Permission::create(['name' => 'Ver control de vacaciones'])->syncRoles([$administrador, $operativo]);
        /* Permisos CRUD para la vista /control_vacaciones */
        Permission::create(['name' => 'Crear solicitudes de vacaciones'])->syncRoles([$administrador, $operativo]);
        Permission::create(['name' => 'Editar solicitudes de vacaciones'])->syncRoles([$administrador, $operativo]);
        Permission::create(['name' => 'Validar solicitudes de vacaciones'])->syncRoles([$administrador, $operativo]);

        /* Permiso para ver la ruta de /inducciones */
        Permission::create(['name' => 'Ver inducciones'])->syncRoles([$administrador, $operativo]);
        /* Permisos CRUD para la vista /inducciones */
        Permission::create(['name' => 'Asignar empleados a inducción'])->syncRoles([$administrador, $operativo]);

        if ($super) {
            $super->syncPermissions(Permission::all());
        }
    }
}
