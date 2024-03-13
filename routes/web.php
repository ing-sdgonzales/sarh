<?php

use App\Http\Controllers\BuscarAplicacionController;
use App\Http\Controllers\DashboardController;
use App\Livewire\Candidatos\Candidatos;
use App\Livewire\Candidatos\EtapasProcesos;
use App\Livewire\Candidatos\Expediente;
use App\Livewire\Candidatos\VerFormulario;
use App\Livewire\Capacitaciones\Capacitaciones;
use App\Livewire\Capacitaciones\Inducciones\Inducciones;
use App\Livewire\Capacitaciones\Sesiones;
use App\Livewire\Clinica\Consulta;
use App\Livewire\Clinica\Historial;
use App\Livewire\Contratos\Contratos;
use App\Livewire\Contratos\PuestosFuncionales\HistorialPuestos;
use App\Livewire\Empleados\Empleados;
use App\Livewire\Employees\DashboardEmpleados;
use App\Livewire\Employees\Solicitudes\Vacaciones\Vacaciones as VacacionesVacaciones;
use App\Livewire\Formularios\Formulario;
use App\Livewire\Formularios\Formulario029;
use App\Livewire\ListarRequisitos;
use App\Livewire\Permisos\Permiso;
use App\Livewire\Pir\Formulario as PirFormulario;
use App\Livewire\Puesto\Catalogo\CatalogoPuestos;
use App\Livewire\Puesto\Puestos;
use App\Livewire\Requisitos\Requisitos;
use App\Livewire\Roles\Rol;
use App\Livewire\Usuarios\BitacoraUsuario;
use App\Livewire\Usuarios\Usuarios;
use App\Livewire\Vacaciones\ControlVacaciones;
use App\Livewire\Vacaciones\Vacaciones;
use Illuminate\Support\Facades\Route;
use Laravel\Jetstream\Rules\Role;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

/* Rutas públicas */
Route::get('/buscar_aplicacion', [BuscarAplicacionController::class, 'index'])
    ->middleware(['guest:' . config('fortify.guard')])
    ->name('buscar_aplicacion');

Route::post('/buscar_aplicacion', [BuscarAplicacionController::class, 'buscar'])
    ->middleware(['guest:' . config('fortify.guard')]);

Route::get('/presentar_requisitos/{id_candidato}', ListarRequisitos::class)
    ->middleware(['CheckEmailSearch', 'guest:' . config('fortify.guard')])->name('presentar_requisitos');

Route::get('/presentar_formulario_029/{id_candidato}', Formulario029::class)
    ->middleware(['CheckEmailSearch', 'guest:' . config('fortify.guard')])->name('presentar_formulario029');

Route::get('/presentar_formulario/{id_candidato}/{id_requisito}', Formulario::class)
    ->middleware(['CheckEmailSearch', 'VerificarEstadoFormulario', 'guest:' . config('fortify.guard')])->name('presentar_formulario');

/* Rutas para los roles Súper Administrador, Administrador, Operativo */
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/usuarios', Usuarios::class)->middleware('can:Ver usuarios')->name('usuarios');
    Route::get('/roles', Rol::class)->middleware('can:Ver roles')->name('roles');
    Route::get('/permisos', Permiso::class)->middleware('can:Ver permisos')->name('permisos');
    Route::get('/puestos', Puestos::class)->middleware('can:Ver puestos')->name('puestos');
    Route::get('/catalogo_puestos', CatalogoPuestos::class)->middleware('can:Ver catálogo de puestos')->name('catalogo_puestos');
    Route::get('/candidatos', Candidatos::class)->middleware('can:Ver candidatos')->name('candidatos');
    Route::get('/empleados', Empleados::class)->middleware('can:Ver empleados')->name('empleados');
    Route::get('/requisitos', Requisitos::class)->middleware('can:Ver requisitos')->name('requisitos');
    Route::get('/expediente_candidato/{candidato_id}', Expediente::class)->middleware('can:Ver expediente')->name('expedientes');
    Route::get('/contratos/{id_empleado}', Contratos::class)->middleware(['can:Ver contratos', 'verificar.estado.empleado'])->name('contratos');
    Route::get('/historial_puestos/{id_empleado}', HistorialPuestos::class)->middleware('can:Ver historial de puestos')->name('historial_puestos');
    Route::get('/ver_formulario/{id_candidato}/{id_requisito}', VerFormulario::class)->middleware('can:Ver formulario')->name('formulario');
    Route::get('/proceso_candidato/{id_candidato}', EtapasProcesos::class)->middleware('can:Ver etapas')->name('proceso');
    Route::get('/bitacora_usuarios', BitacoraUsuario::class)->middleware('can:Ver bitácora')->name('bitacora');
    Route::get('/consulta_medica/{id_empleado}', Consulta::class)->middleware('can:Ver consulta médica')->name('consultas');
    Route::get('/historial_medico', Historial::class)->middleware('can:Ver historial médico')->name('historial_medico');
    Route::get('/capacitaciones', Capacitaciones::class)->middleware('can:Ver capacitaciones')->name('capacitaciones');
    Route::get('/sesiones_capacitacion/{id_capacitacion}', Sesiones::class)->middleware('can:Ver sesiones de capacitación')->name('sesiones');
    Route::get('/vacaciones', Vacaciones::class)->middleware('can:Ver vacaciones')->name('vacaciones');
    Route::get('/vacaciones/control_vacaciones/{id_empleado}', ControlVacaciones::class)->middleware('can:Ver control de vacaciones')->name('control_vacaciones');
    Route::get('/inducciones', Inducciones::class)->middleware('can:Ver inducciones')->name('inducciones'); //*
    Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('can: Ver dashboard')->name('dashboard');
});

/* Grupo de rutas para el rol de Empleado */
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'role:Empleado'])->group(function () {

    /* Ruta de inicio de empleado (Dashboard empleado) */
    Route::get('/empleado/dashboard', DashboardEmpleados::class)->name('dashboard-empleados');

    /* Ruta de inicio de solicitudes de vacaciones */
    Route::get('/empleados/solicitudes/vacaciones', VacacionesVacaciones::class)->name('empleados-solicitudes-vacaciones');
});


/* Grupo de rutas para el roles de PIR */
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {

    /* Ruta de formulario PIR */
    Route::get('/pir', PirFormulario::class)->name('formulario_pir');
});
