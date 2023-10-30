<?php

use App\Http\Controllers\BuscarAplicacionController;
use App\Livewire\Candidatos\Candidatos;
use App\Livewire\Candidatos\Expediente;
use App\Livewire\Candidatos\VerFormulario;
use App\Livewire\Formularios\Formulario;
use App\Livewire\Formularios\Formulario029;
use App\Livewire\ListarRequisitos;
use App\Livewire\Permisos\Permiso;
use App\Livewire\Puesto\Puestos;
use App\Livewire\Roles\Rol;
use App\Livewire\Usuarios\BitacoraUsuario;
use Illuminate\Support\Facades\Route;
use Laravel\Jetstream\Rules\Role;

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
    ->middleware(['CheckEmailSearch', 'guest:' . config('fortify.guard')])->name('presentar_formulario');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/usuarios', [UserController::class, 'show'])->name('usuarios');
    Route::get('/roles', Rol::class)->middleware('can:Ver roles')->name('roles');
    Route::get('/permisos', Permiso::class)->middleware('can:Ver permisos')->name('permisos');
    Route::get('/getUsers', [UsuariosTable::class])->name('listarUsuarios');

    Route::get('/puestos', Puestos::class)->name('puestos');
    Route::get('/candidatos', Candidatos::class)->name('candidatos');
    Route::get('/expediente_candidato/{candidato_id}', Expediente::class)->name('expedientes');
    Route::get('/ver_formulario/{id_candidato}/{id_requisito}', VerFormulario::class)->name('formulario');

    Route::get('/bitacora_usuarios', BitacoraUsuario::class)->name('bitacora');

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
