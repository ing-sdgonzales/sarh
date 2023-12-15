<?php

namespace App\Livewire\Formularios;

use App\Models\AplicacionCandidato;
use App\Models\ConocidoConred;
use App\Models\ContactoEmergencia;
use App\Models\Conviviente;
use App\Models\Deuda;
use App\Models\Direccion;
use App\Models\Dpi;
use App\Models\Empleado;
use App\Models\EstudioActualEmpleado;
use App\Models\EtapaAplicacion;
use App\Models\FamiliarConred;
use App\Models\HijoEmpleado;
use App\Models\HistoriaClinica;
use App\Models\HistorialLaboral;
use App\Models\Idioma;
use App\Models\LicenciaConducir;
use App\Models\MadreEmpleado;
use App\Models\PadreEmpleado;
use App\Models\PersonaDependiente;
use App\Models\ProgramaComputacion;
use App\Models\ReferenciaLaboral;
use App\Models\ReferenciaPersonal;
use App\Models\RegistroAcademicoEmpleado;
use App\Models\RequisitoCandidato;
use App\Models\RequisitoPuesto;
use App\Models\TelefonoEmpleado;
use App\Models\Vehiculo;
use App\Notifications\NotificacionCargaRequisitos;
use Exception;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;

use Livewire\Component;

class Formulario extends Component
{
    use WithFileUploads;

    public $departamentos, $municipios, $municipios_emision, $municipios_residencia,
        $hijos = [['nombre' => '']],
        $idiomas = [['idioma' => '', 'habla' => '', 'lee' => '', 'escribe' => '']],
        $si_no = [['val' => 0, 'res' => 'No'], ['val' => 1, 'res' => 'Sí']],
        $programas = [['programa' => '', 'valoracion' => '']],
        $personas_dependientes = [['nombre' => '', 'parentesco' => '']],
        $requisitos_cargados = [];
    public $historiales_laborales = [
        [
            'empresa' => '',
            'direccion' => '',
            'telefono' => '',
            'jefe_inmediato' => '',
            'cargo' => '',
            'desde' => '',
            'hasta' => '',
            'ultimo_sueldo' => '',
            'motivo_salida' => '',
            'verificar_informacion' => '',
            'razon_informacion' => ''
        ]
    ];
    public $referencias_laborales = [['nombre' => '', 'empresa' => '', 'teléfono' => '']];
    public $referencias_personales = [['nombre' => '', 'lugar_trabajo' => '', 'teléfono' => '']];
    /* variables de consulta */
    public $id_candidato, $id_empleado, $id_requisito, $id_puesto, $dpi, $nit, $igss, $imagen, $nombres, $apellidos, $puesto, $email, $pretension_salarial, $departamento,
        $municipio, $fecha_nacimiento, $nacionalidad, $estado_civil, $direccion, $departamento_residencia, $municipio_residencia, $departamento_emision, $municipio_emision, $licencia,
        $tipo_licencia, $tipo_vehiculo, $placa, $telefono_casa, $telefono_movil, $familiar_conred, $nombre_familiar_conred,
        $cargo_familiar_conred, $conocido_conred, $nombre_conocido_conred, $cargo_conocido_conred, $telefono_padre, $nombre_padre,
        $ocupacion_padre, $telefono_madre, $nombre_madre, $ocupacion_madre, $telefono_conviviente, $nombre_conviviente, $ocupacion_conviviente,
        $establecimiento_primaria, $titulo_primaria, $establecimiento_secundaria, $titulo_secundaria, $establecimiento_diversificado,
        $titulo_diversificado, $establecimiento_universitario, $titulo_universitario, $establecimiento_maestria_postgrado,
        $titulo_maestria_postgrado, $establecimiento_otra_especialidad, $titulo_otra_especialidad, $estudia_actualmente, $estudio_actual,
        $horario_estudio_actual, $establecimiento_estudio_actual, $etnia, $otro_etnia, $tipo_vivienda, $pago_vivienda, $cantidad_personas_dependientes,
        $ingresos_adicionales, $fuente_ingresos_adicionales, $personas_aportan_ingresos, $monto_ingreso_total, $posee_deudas, $tipo_deuda,
        $monto_deuda, $trabajo_conred, $trabajo_estado, $jubilado_estado, $institucion_jubilacion, $padecimiento_salud, $tipo_enfermedad, $intervencion_quirurgica,
        $tipo_intervencion, $sufrido_accidente, $tipo_accidente, $alergia_medicamento, $tipo_medicamento, $tipo_sangre, $nombre_contacto_emergencia,
        $telefono_contacto_emergencia, $direccion_contacto_emergencia;

    public $empleado, $imagen_actual, $nombre_candidato;
    #[Layout('layouts.app2')]
    public function render()
    {
        $etnias =  DB::table('etnias')->select('id', 'etnia')->get();
        $grupos_sanguineos = DB::table('grupos_sanguineos')->select('id', 'grupo')->get();
        $this->departamentos = DB::table('departamentos')->select('id', 'nombre')->get();
        $nacionalidades = DB::table('nacionalidades')->select('id', 'nacionalidad')->get();
        $estados_civiles = DB::table('estados_civiles')->select('id', 'estado_civil')->get();
        $tipos_licencias = DB::table('tipos_licencias')->select('id', 'tipo_licencia')->get();
        $tipos_vehiculos = DB::table('tipos_vehiculos')->select('id', 'tipo_vehiculo')->get();
        $tipos_deudas = DB::table('tipos_deudas')->select('id', 'tipo_deuda')->get();
        $tipos_viviendas = DB::table('tipos_viviendas')->select('id', 'tipo_vivienda')->get();
        return view('livewire.formularios.formulario', [
            'etnias' => $etnias,
            'grupos_sanguineos' => $grupos_sanguineos,
            'nacionalidades' => $nacionalidades,
            'estados_civiles' => $estados_civiles,
            'tipos_licencias' => $tipos_licencias,
            'tipos_vehiculos' => $tipos_vehiculos,
            'tipos_deudas' => $tipos_deudas,
            'tipos_viviendas' => $tipos_viviendas
        ]);
    }

    public function guardar()
    {
        $img = '';
        if (empty($this->imagen_actual)) {
            $validated =  $this->validate([
                'imagen' => 'image|required|mimes:jpg,jpeg,png|max:2048'
            ]);
        }
        $validated = $this->validate([
            'nombres' => 'required|filled|regex:/^[A-Za-záàéèíìóòúùÁÀÉÈÍÌÓÒÚÙüÜñÑ\s]+$/',
            'apellidos' => 'required|filled|regex:/^[A-Za-záàéèíìóòúùÁÀÉÈÍÌÓÒÚÙüÜñÑ\s]+$/',
            'pretension_salarial' => 'required|decimal:2',
            'departamento' => 'required|integer|min:1',
            'municipio' => 'required|integer|min:1',
            'fecha_nacimiento' => 'required|date|before_or_equal:' . \Carbon\Carbon::now()->subYears(18)->format('Y-m-d'),
            'nacionalidad' => 'required|integer|min:1',
            'estado_civil' => 'required|integer|min:1',
            'direccion' => 'required|filled',
            'departamento_residencia' => 'required|integer|min:1',
            'municipio_residencia' => 'required|integer|min:1',
            'dpi' => ['required', 'filled', 'size:15', 'regex:/^[1-9]\d{3} [1-9][0-9]{4} ([0][1-9]|[1][0-9]|[2][0-2])([0][1-9]|[1][0-9]|[2][0-9]|[3][0-9])$/'],
            'departamento_emision' => 'required|integer|min:1',
            'municipio_emision' => 'required|integer|min:1',
            'igss' => 'nullable',
            'nit' => 'required|filled',
            'licencia' => 'nullable',
            'tipo_licencia' => 'nullable|integer',
            'tipo_vehiculo' => 'nullable|integer',
            'placa' => 'nullable|regex:/^[PM]\d{3}[BCDFGHJKLMNPQRSTVWXYZ]{3}$/',
            'telefono_casa' => ['nullable', 'regex:/^(2|3|4|5|7)\d{3}-\d{4}$/'],
            'telefono_movil' => ['required', 'regex:/^(3|4|5)\d{3}-\d{4}$/'],
            'email' => 'required|filled|email:dns',
            'familiar_conred' => 'required|integer|min:0',
            'nombre_familiar_conred' => 'required_if:familiar_conred,1|nullable',
            'cargo_familiar_conred' => 'required_if:familiar_conred,1|nullable',
            'conocido_conred' => 'required|integer|min:0',
            'nombre_conocido_conred' => 'required_if:conocido_conred,1|nullable',
            'cargo_conocido_conred' => 'required_if:conocido_conred,1|nullable',
            'telefono_padre' => ['nullable', 'regex:/^(2|3|4|5|7)\d{3}-\d{4}$/'],
            'nombre_padre' => 'required|filled|regex:/^[A-Za-záàéèíìóòúùÁÀÉÈÍÌÓÒÚÙüÜñÑ\s]+$/',
            'ocupacion_padre' => 'required|filled|regex:/^[A-Za-záàéèíìóòúùÁÀÉÈÍÌÓÒÚÙüÜñÑ\s]+$/',
            'telefono_madre' => ['nullable', 'regex:/^(2|3|4|5|7)\d{3}-\d{4}$/'],
            'nombre_madre' => 'required|filled|regex:/^[A-Za-záàéèíìóòúùÁÀÉÈÍÌÓÒÚÙüÜñÑ\s]+$/',
            'ocupacion_madre' => 'required|filled|regex:/^[A-Za-záàéèíìóòúùÁÀÉÈÍÌÓÒÚÙüÜñÑ\s]+$/',
            'telefono_conviviente' => ['nullable', 'regex:/^(2|3|4|5|7)\d{3}-\d{4}$/'],
            'nombre_conviviente' => 'nullable|regex:/^[A-Za-záàéèíìóòúùÁÀÉÈÍÌÓÒÚÙüÜñÑ\s]+$/',
            'ocupacion_conviviente' => 'required_with:nombre_conviviente|nullable|regex:/^[A-Za-záàéèíìóòúùÁÀÉÈÍÌÓÒÚÙüÜñÑ\s]+$/',
            'hijos.*.nombre' => ['nullable', 'regex:/^[A-Za-záàéèíìóòúùÁÀÉÈÍÌÓÒÚÙüÜñÑ\s]+$/'],
            'establecimiento_primaria' => 'required|filled|regex:/^[A-Za-záàéèíìóòúùÁÀÉÈÍÌÓÒÚÙüÜñÑ\s.,;:-]+$/',
            'titulo_primaria' => 'required|filled|regex:/^[A-Za-záàéèíìóòúùÁÀÉÈÍÌÓÒÚÙüÜñÑ\s]+$/',
            'establecimiento_secundaria' => 'nullable|regex:/^[A-Za-záàéèíìóòúùÁÀÉÈÍÌÓÒÚÙüÜñÑ\s.,;:-]+$/',
            'titulo_secundaria' => 'nullable|regex:/^[A-Za-záàéèíìóòúùÁÀÉÈÍÌÓÒÚÙüÜñÑ\s]+$/',
            'establecimiento_diversificado' => 'nullable|regex:/^[A-Za-záàéèíìóòúùÁÀÉÈÍÌÓÒÚÙüÜñÑ\s.,;:-]+$/',
            'titulo_diversificado' => 'nullable|regex:/^[A-Za-záàéèíìóòúùÁÀÉÈÍÌÓÒÚÙüÜñÑ\s]+$/',
            'establecimiento_universitario' => 'nullable|regex:/^[A-Za-záàéèíìóòúùÁÀÉÈÍÌÓÒÚÙüÜñÑ\s.,;:-]+$/',
            'titulo_universitario' => 'nullable|regex:/^[A-Za-záàéèíìóòúùÁÀÉÈÍÌÓÒÚÙüÜñÑ\s]+$/',
            'establecimiento_maestria_postgrado' => 'nullable|regex:/^[A-Za-záàéèíìóòúùÁÀÉÈÍÌÓÒÚÙüÜñÑ\s.,;:-]+$/',
            'titulo_maestria_postgrado' => 'nullable|regex:/^[A-Za-záàéèíìóòúùÁÀÉÈÍÌÓÒÚÙüÜñÑ\s]+$/',
            'establecimiento_otra_especialidad' => 'nullable|regex:/^[A-Za-záàéèíìóòúùÁÀÉÈÍÌÓÒÚÙüÜñÑ\s]+$/',
            'titulo_otra_especialidad' => 'nullable|regex:/^[A-Za-záàéèíìóòúùÁÀÉÈÍÌÓÒÚÙüÜñÑ\s.,;:-]+$/',
            'estudia_actualmente' => 'required|integer|min:0',
            'estudio_actual' => 'required_if:estudia_actualmente,1|nullable|regex:/^[A-Za-záàéèíìóòúùÁÀÉÈÍÌÓÒÚÙüÜñÑ\s]+$/',
            'horario_estudio_actual' => 'required_if:estudia_actualmente,1|nullable',
            'establecimiento_estudio_actual' => 'required_if:estudia_actualmente,1|nullable|regex:/^[A-Za-záàéèíìóòúùÁÀÉÈÍÌÓÒÚÙüÜñÑ\s.,;:-]+$/',
            'etnia' => 'required|integer|min:1',
            'otro_etnia' => 'required_if:etnia,5|nullable|regex:/^[A-Za-záàéèíìóòúùÁÀÉÈÍÌÓÒÚÙüÜñÑ\s]+$/',
            'idiomas.*.idioma' => ['nullable', 'regex:/^[A-Za-záàéèíìóòúùÁÀÉÈÍÌÓÒÚÙüÜñÑ\s]+$/'],
            'idiomas.*.habla' => ['required_with:idiomas.*.idioma', 'nullable', 'integer', 'min:0', 'max:100'],
            'idiomas.*.lee' => ['required_with:idiomas.*.idioma', 'nullable', 'integer', 'min:0', 'max:100'],
            'idiomas.*.escribe' => ['required_with:idiomas.*.idioma', 'nullable', 'integer', 'min:0', 'max:100'],
            'programas.*.programa' => ['nullable', 'regex:/^[A-Za-záàéèíìóòúùÁÀÉÈÍÌÓÒÚÙüÜñÑ\s]+$/'],
            'programas.*.valoracion' => ['required_with:programas.*.programa', 'integer', 'min:1', 'max:5'],
            'historiales_laborales.*.empresa' => ['nullable', 'regex:/^[A-Za-záàéèíìóòúùÁÀÉÈÍÌÓÒÚÙüÜñÑ\s.,;:-]+$/'],
            'historiales_laborales.*.direccion' => ['required_with:historiales_laborales.*.empresa'],
            'historiales_laborales.*.telefono' => ['required_with:historiales_laborales.*.empresa', 'regex:/^(2|3|4|5|7)\d{3}-\d{4}$/'],
            'historiales_laborales.*.jefe_inmediato' => ['required_with:historiales_laborales.*.empresa', 'regex:/^[A-Za-záàéèíìóòúùÁÀÉÈÍÌÓÒÚÙüÜñÑ\s]+$/'],
            'historiales_laborales.*.cargo' => ['required_with:historiales_laborales.*.empresa', 'regex:/^[A-Za-záàéèíìóòúùÁÀÉÈÍÌÓÒÚÙüÜñÑ\s]+$/'],
            'historiales_laborales.*.desde' => ['required_with:historiales_laborales.*.empresa', 'date', 'before_or_equal:' . \Carbon\Carbon::now()->subDay()->format('Y-m-d')],
            'historiales_laborales.*.hasta' => ['required_with:historiales_laborales.*.empresa', 'date', 'after:historiales_laborales.*.desde'],
            'historiales_laborales.*.ultimo_sueldo' => ['required_with:historiales_laborales.*.empresa', 'decimal:2'],
            'historiales_laborales.*.motivo_salida' => ['required_with:historiales_laborales.*.empresa', 'regex:/^[A-Za-záàéèíìóòúùÁÀÉÈÍÌÓÒÚÙüÜñÑ\s]+$/'],
            'historiales_laborales.*.verificar_informacion' => ['required_with:historiales_laborales.*.empresa', 'integer', 'min:0'],
            'historiales_laborales.*.razon_informacion' => ['required_if:historiales_laborales.*.verificar_informacion,0', 'nullable', 'regex:/^[A-Za-záàéèíìóòúùÁÀÉÈÍÌÓÒÚÙüÜñÑ\s]+$/'],
            'referencias_personales.*.nombre' => ['required', 'filled', 'regex:/^[A-Za-záàéèíìóòúùÁÀÉÈÍÌÓÒÚÙüÜñÑ\s]+$/'],
            'referencias_personales.*.lugar_trabajo' => ['required', 'filled', 'regex:/^[A-Za-záàéèíìóòúùÁÀÉÈÍÌÓÒÚÙüÜñÑ\s.,;:-]+$/'],
            'referencias_personales.*.telefono' => ['required', 'filled', 'regex:/^(3|4|5)\d{3}-\d{4}$/'],
            'referencias_laborales.*.nombre' => ['required', 'filled', 'regex:/^[A-Za-záàéèíìóòúùÁÀÉÈÍÌÓÒÚÙüÜñÑ\s]+$/'],
            'referencias_laborales.*.empresa' => ['required', 'filled', 'regex:/^[A-Za-záàéèíìóòúùÁÀÉÈÍÌÓÒÚÙüÜñÑ\s.,;:-]+$/'],
            'referencias_laborales.*.telefono' => ['required', 'filled', 'regex:/^(3|4|5)\d{3}-\d{4}$/'],
            'tipo_vivienda' => 'required|integer|min:1',
            'pago_vivienda' => 'required|decimal:2',
            'cantidad_personas_dependientes' => 'required|integer|min:0',
            'personas_dependientes.*.nombre' => ['required_if:cantidad_personas_dependientes, >=,1', 'nullable', 'regex:/^[A-Za-záàéèíìóòúùÁÀÉÈÍÌÓÒÚÙüÜñÑ\s]+$/'],
            'personas_dependientes.*.parentesco' => ['required_with:personas_dependientes.*.nombre', 'nullable', 'regex:/^[A-Za-záàéèíìóòúùÁÀÉÈÍÌÓÒÚÙüÜñÑ\s]+$/'],
            'ingresos_adicionales' => 'required|integer|min:0',
            'fuente_ingresos_adicionales' => 'required_if:ingresos_adicionales,1',
            'personas_aportan_ingresos' => 'nullable|regex:/^[A-Za-záàéèíìóòúùÁÀÉÈÍÌÓÒÚÙüÜñÑ\s]+$/',
            'monto_ingreso_total' => 'nullable|decimal:2',
            'posee_deudas' => 'required|integer|min:0',
            'tipo_deuda' => 'required_if:posee_deudas,1|nullable|integer|min:1',
            'monto_deuda' => 'required_if:posee_deudas,1|nullable|decimal:2',
            'trabajo_conred' => 'required|integer|min:0',
            'trabajo_estado' => 'required|integer|min:0',
            'jubilado_estado' => 'required|integer|min:0',
            'institucion_jubilacion' => 'required_if:jubilado_estado,1|nullable|regex:/^[A-Za-záàéèíìóòúùÁÀÉÈÍÌÓÒÚÙüÜñÑ\s.,;:-]+$/',
            'padecimiento_salud' => 'required|integer|min:0',
            'tipo_enfermedad' => 'required_if:padecimiento_salud,1|nullable|regex:/^[A-Za-záàéèíìóòúùÁÀÉÈÍÌÓÒÚÙüÜñÑ\s]+$/',
            'intervencion_quirurgica' => 'required|integer|min:0',
            'tipo_intervencion' => 'required_if:intervencion_quirurgica,1|nullable|regex:/^[A-Za-záàéèíìóòúùÁÀÉÈÍÌÓÒÚÙüÜñÑ\s]+$/',
            'sufrido_accidente' => 'required|integer|min:0',
            'tipo_accidente' => 'required_if:sufrido_accidente,1|nullable|regex:/^[A-Za-záàéèíìóòúùÁÀÉÈÍÌÓÒÚÙüÜñÑ\s]+$/',
            'alergia_medicamento' => 'required|integer|min:0',
            'tipo_medicamento' => 'required_if:alergia_medicamento,1|nullable|regex:/^[A-Za-záàéèíìóòúùÁÀÉÈÍÌÓÒÚÙüÜñÑ\s]+$/',
            'tipo_sangre' => 'required|integer|min:1',
            'nombre_contacto_emergencia' => 'required|filled|regex:/^[A-Za-záàéèíìóòúùÁÀÉÈÍÌÓÒÚÙüÜñÑ\s]+$/',
            'direccion_contacto_emergencia' => 'required|filled',
            'telefono_contacto_emergencia' => ['required', 'regex:/^(2|3|4|5|7)\d{3}-\d{4}$/']
        ]);

        try {
            if ($this->imagen == $this->imagen_actual) {
                $img = $this->imagen;
            } else {
                $img = $this->imagen->store('candidatos', 'public');
                Storage::delete('public/' . $this->imagen_actual);
            }
            DB::transaction(function () use ($validated, $img) {
                $this->empleado = Empleado::updateOrCreate(['candidatos_id' => $this->id_candidato], [
                    'nit' => $validated['nit'],
                    'igss' => $validated['igss'],
                    'imagen' => $img,
                    'nombres' => $validated['nombres'],
                    'apellidos' => $validated['apellidos'],
                    'email' => $validated['email'],
                    'fecha_nacimiento' => $validated['fecha_nacimiento'],
                    'direccion' => $validated['direccion'],
                    'pretension_salarial' => $validated['pretension_salarial'],
                    'estudia_actualmente' => $validated['estudia_actualmente'],
                    'cantidad_personas_dependientes' => $validated['cantidad_personas_dependientes'],
                    'ingresos_adicionales' => $validated['ingresos_adicionales'],
                    'monto_ingreso_total' => $validated['monto_ingreso_total'],
                    'posee_deudas' => $validated['posee_deudas'],
                    'trabajo_conred' => $validated['trabajo_conred'],
                    'trabajo_estado' => $validated['trabajo_estado'],
                    'jubilado_estado' => $validated['jubilado_estado'],
                    'institucion_jubilacion' => $validated['institucion_jubilacion'],
                    'personas_aportan_ingresos' => $validated['personas_aportan_ingresos'],
                    'fuente_ingresos_adicionales' => $validated['fuente_ingresos_adicionales'],
                    'pago_vivienda' => $validated['pago_vivienda'],
                    'familiar_conred' => $validated['familiar_conred'],
                    'conocido_conred' => $validated['conocido_conred'],
                    'etnias_id' => $validated['etnia'],
                    'otro_etnia' => $validated['otro_etnia'],
                    'grupos_sanguineos_id' => $validated['tipo_sangre'],
                    'municipios_id' => $validated['municipio'],
                    'nacionalidades_id' => $validated['nacionalidad'],
                    'tipos_viviendas_id' => $validated['tipo_vivienda'],
                    'estados_civiles_id' => $validated['estado_civil'],
                    'candidatos_id' => $this->id_candidato,
                    'relaciones_laborales_id' => 4
                ]);

                Direccion::updateOrCreate(['empleados_id' => $this->empleado->id], [
                    'direccion' => $validated['direccion'],
                    'municipios_id' => $validated['municipio_emision']
                ]);

                Dpi::updateOrCreate(['empleados_id' => $this->empleado->id], [
                    'dpi' => $validated['dpi'],
                    'municipios_id' => $validated['municipio_emision']
                ]);

                if (!empty($this->licencia)) {
                    LicenciaConducir::updateOrCreate(['empleados_id' => $this->empleado->id], [
                        'licencia' => $validated['licencia'],
                        'tipos_licencias_id' => $validated['tipo_licencia']
                    ]);
                }

                if (!empty($this->placa)) {
                    Vehiculo::updateOrCreate(['empleados_id' => $this->empleado->id], [
                        'placa' => $validated['placa'],
                        'tipos_vehiculos_id' => $validated['tipo_vehiculo']
                    ]);
                } elseif (empty($this->placa)) {
                    $placa = Vehiculo::where('empleados_id', $this->empleado->id)->first();
                    if ($placa) {
                        $placa->delete();
                    }
                }

                TelefonoEmpleado::updateOrCreate(['empleados_id' => $this->empleado->id], [
                    'telefono' => $validated['telefono_movil'],
                    'telefono_casa' => $validated['telefono_casa']
                ]);

                if ($this->familiar_conred == 1) {
                    FamiliarConred::updateOrCreate(['empleados_id' => $this->empleado->id], [
                        'nombre' => $validated['nombre_familiar_conred'],
                        'cargo' => $validated['cargo_familiar_conred']
                    ]);
                } elseif ($this->familiar_conred == 0) {
                    $familiar_conred = FamiliarConred::where('empleados_id', $this->empleado->id)->first();
                    if ($familiar_conred) {
                        $familiar_conred->delete();
                    }
                }

                if ($this->conocido_conred == 1) {
                    ConocidoConred::updateOrCreate(['empleados_id' => $this->empleado->id], [
                        'nombre' => $validated['nombre_conocido_conred'],
                        'cargo' => $validated['cargo_conocido_conred']
                    ]);
                } elseif ($this->conocido_conred == 0) {
                    $conocido_conred = ConocidoConred::where('empleados_id', $this->empleado->id);
                    if ($conocido_conred) {
                        $conocido_conred->delete();
                    }
                }

                PadreEmpleado::updateOrCreate(['empleados_id' => $this->empleado->id], [
                    'nombre' => $validated['nombre_padre'],
                    'ocupacion' => $validated['ocupacion_padre'],
                    'telefono' => $validated['telefono_padre']
                ]);

                MadreEmpleado::updateOrCreate(['empleados_id' => $this->empleado->id], [
                    'nombre' => $validated['nombre_madre'],
                    'ocupacion' => $validated['ocupacion_madre'],
                    'telefono' => $validated['telefono_madre']
                ]);

                if (!empty($this->nombre_conviviente)) {
                    Conviviente::updateOrCreate(['empleados_id' => $this->empleado->id], [
                        'nombre' => $validated['nombre_conviviente'],
                        'ocupacion' => $validated['ocupacion_conviviente'],
                        'telefono' => $validated['telefono_conviviente']
                    ]);
                } elseif (empty($this->nombre_conviviente)) {
                    $conviviente = Conviviente::where('empleados_id', $this->empleado->id)->first();
                    if ($conviviente) {
                        $conviviente->delete();
                    }
                }

                if (count($this->hijos) > 0) {
                    HijoEmpleado::where('empleados_id', $this->empleado->id)
                        ->whereNotIn('nombre', collect($this->hijos)->pluck('nombre')->toArray())
                        ->delete();

                    foreach ($this->hijos as $hijo) {
                        $nombre = $hijo['nombre'];
                        HijoEmpleado::updateOrCreate(['empleados_id' => $this->empleado->id, 'nombre' => $nombre], [
                            'nombre' => $hijo['nombre']
                        ]);
                    }
                }

                RegistroAcademicoEmpleado::updateOrCreate(['empleados_id' => $this->empleado->id, 'titulo' => $this->titulo_primaria], [
                    'establecimiento' => $validated['establecimiento_primaria'],
                    'titulo' => $validated['titulo_primaria'],
                    'registros_academicos_id' => 1
                ]);

                if (!empty($this->titulo_secundaria)) {
                    RegistroAcademicoEmpleado::updateOrCreate(['empleados_id' => $this->empleado->id, 'titulo' => $this->titulo_secundaria], [
                        'establecimiento' => $validated['establecimiento_secundaria'],
                        'titulo' => $validated['titulo_secundaria'],
                        'registros_academicos_id' => 2
                    ]);
                }

                if (!empty($this->titulo_diversificado)) {
                    RegistroAcademicoEmpleado::updateOrCreate(['empleados_id' => $this->empleado->id, 'titulo' => $this->titulo_diversificado], [
                        'establecimiento' => $validated['establecimiento_diversificado'],
                        'titulo' => $validated['titulo_diversificado'],
                        'registros_academicos_id' => 3
                    ]);
                }

                if (!empty($this->titulo_universitario)) {
                    RegistroAcademicoEmpleado::updateOrCreate(['empleados_id' => $this->empleado->id, 'titulo' => $this->titulo_universitario], [
                        'establecimiento' => $validated['establecimiento_universitario'],
                        'titulo' => $validated['titulo_universitario'],
                        'registros_academicos_id' => 6
                    ]);
                }

                if (!empty($this->titulo_maestria_postgrado)) {
                    RegistroAcademicoEmpleado::updateOrCreate(['empleados_id' => $this->empleado->id, 'titulo' => $this->titulo_maestria_postgrado], [
                        'establecimiento' => $validated['establecimiento_maestria_postgrado'],
                        'titulo' => $validated['titulo_maestria_postgrado'],
                        'registros_academicos_id' => 8
                    ]);
                }

                if (!empty($this->titulo_otra_especialidad)) {
                    RegistroAcademicoEmpleado::updateOrCreate(['empleados_id' => $this->empleado->id, 'titulo' => $this->titulo_otra_especialidad], [
                        'establecimiento' => $validated['establecimiento_otra_especialidad'],
                        'titulo' => $validated['titulo_otra_especialidad'],
                        'registros_academicos_id' => 10
                    ]);
                }

                if ($this->estudia_actualmente == 1) {
                    EstudioActualEmpleado::updateOrCreate(['empleados_id' => $this->empleado->id], [
                        'carrera' => $validated['estudio_actual'],
                        'establecimiento' => $validated['establecimiento_estudio_actual'],
                        'horario' => $validated['horario_estudio_actual']
                    ]);
                } elseif ($this->estudia_actualmente == 0) {
                    $estudio_actual = EstudioActualEmpleado::where('empleados_id', $this->empleado->id)->first();
                    if ($estudio_actual) {
                        $estudio_actual->delete();
                    }
                }

                if (count($this->idiomas) > 0) {
                    Idioma::where('empleados_id', $this->empleado->id)
                        ->whereNotIn('idioma', collect($this->idiomas)->pluck('idioma')->toArray())
                        ->delete();

                    foreach ($validated['idiomas'] as $idioma) {
                        $lang =  $idioma['idioma'];
                        Idioma::updateOrCreate(['empleados_id' => $this->empleado->id, 'idioma' => $lang], [
                            'idioma' => $idioma['idioma'],
                            'habla' => $idioma['habla'],
                            'lee' => $idioma['lee'],
                            'escribe' => $idioma['escribe']
                        ]);
                    }
                }

                if (count($this->programas) > 0) {
                    ProgramaComputacion::where('empleados_id', $this->empleado->id)
                        ->whereNotIn('programa', collect($this->programas)->pluck('programa')->toArray())
                        ->delete();

                    foreach ($validated['programas'] as $programa) {
                        $pro = $programa['programa'];
                        ProgramaComputacion::updateOrCreate(['empleados_id' => $this->empleado->id, 'programa' => $pro], [
                            'programa' => $programa['programa'],
                            'valoracion' => $programa['valoracion']
                        ]);
                    }
                }

                if (count($this->historiales_laborales) > 0) {
                    foreach ($validated['historiales_laborales'] as $historial) {
                        if (!empty(array_filter($historial))) {
                            $registro = HistorialLaboral::where('empleados_id', $this->empleado->id)
                                ->where('empresa', $historial['empresa'])
                                ->where('cargo', $historial['cargo'])
                                ->where('desde', $historial['desde'])
                                ->where('hasta', $historial['hasta'])
                                ->first();

                            if ($registro) {
                                $registro->update($historial);
                            } else {
                                $historial['empleados_id'] = $this->empleado->id;
                                HistorialLaboral::create($historial);
                            }
                        }
                    }
                    HistorialLaboral::where('empleados_id', $this->empleado->id)
                        ->where(function ($query) {
                            $query->whereNull('empresa')
                                ->whereNull('direccion')
                                ->whereNull('cargo')
                                ->whereNull('desde')
                                ->whereNull('hasta')
                                ->orWhere(function ($query) {
                                    $query->where('empresa', '')
                                        ->where('direccion', '')
                                        ->where('cargo', '')
                                        ->where('desde', '')
                                        ->where('hasta', '');
                                });
                        })
                        ->delete();
                }

                foreach ($validated['referencias_personales'] as $rp) {
                    $tel_rp = $rp['telefono'];
                    ReferenciaPersonal::updateOrCreate(['empleados_id' => $this->empleado->id, 'telefono' => $tel_rp], [
                        'nombre' => $rp['nombre'],
                        'lugar_trabajo' => $rp['lugar_trabajo'],
                        'telefono' => $rp['telefono']
                    ]);
                }

                foreach ($validated['referencias_laborales'] as $rl) {
                    $tel_rl = $rl['telefono'];
                    ReferenciaLaboral::updateOrCreate(['empleados_id' => $this->empleado->id, 'telefono' => $tel_rl], [
                        'nombre' => $rl['nombre'],
                        'empresa' => $rl['empresa'],
                        'telefono' => $rl['telefono']
                    ]);
                }

                if (count($this->personas_dependientes) > 0) {
                    foreach ($validated['personas_dependientes'] as $persona_dependiente) {
                        if (!empty(array_filter($persona_dependiente))) {
                            $persona = PersonaDependiente::where('empleados_id', $this->empleado->id)
                                ->where('nombre', $persona_dependiente['nombre'])
                                ->where('parentesco', $persona_dependiente['parentesco'])
                                ->first();

                            if ($persona) {
                                $persona->update($persona_dependiente);
                            } else {
                                $persona_dependiente['empleados_id'] = $this->empleado->id;
                                PersonaDependiente::create($persona_dependiente);
                            }
                        }
                    }
                    PersonaDependiente::where('empleados_id', $this->empleado->id)
                        ->where(function ($query) {
                            $query->whereNull('nombre')
                                ->whereNull('parentesco')
                                ->orWhere(function ($query) {
                                    $query->where('nombre', '')
                                        ->where('parentesco', '');
                                });
                        })->delete();
                }

                if ($this->posee_deudas == 1) {
                    Deuda::updateOrCreate(['empleados_id' => $this->empleado->id, 'tipos_deudas_id' => $this->tipo_deuda], [
                        'monto' => $validated['monto_deuda']
                    ]);
                } elseif ($this->posee_deudas == 0) {
                    $deuda = Deuda::where('empleados_id', $this->empleado->id)->first();
                    if ($deuda) {
                        $deuda->delete();
                    }
                }

                HistoriaClinica::updateOrCreate(['empleados_id' => $this->empleado->id], [
                    'padecimiento_salud' => $validated['padecimiento_salud'],
                    'tipo_enfermedad' => $validated['tipo_enfermedad'],
                    'intervencion_quirurgica' => $validated['intervencion_quirurgica'],
                    'tipo_intervencion' => $validated['tipo_intervencion'],
                    'sufrido_accidente' => $validated['sufrido_accidente'],
                    'tipo_accidente' => $validated['tipo_accidente'],
                    'alergia_medicamento' => $validated['alergia_medicamento'],
                    'tipo_medicamento' => $validated['tipo_medicamento'],
                ]);

                ContactoEmergencia::updateOrCreate(['empleados_id' => $this->empleado->id], [
                    'nombre' => $validated['nombre_contacto_emergencia'],
                    'direccion' => $validated['direccion_contacto_emergencia'],
                    'telefono' => $validated['telefono_contacto_emergencia']
                ]);

                $requisito = RequisitoCandidato::where('candidatos_id', $this->id_candidato)
                    ->where('puestos_nominales_id', $this->id_puesto)
                    ->where('requisitos_id', $this->id_requisito)
                    ->join('requisitos', 'requisitos_candidatos.requisitos_id', '=', 'requisitos.id')
                    ->select('requisitos_candidatos.id as id_requisito_candidato', 'requisitos.requisito as requisito')
                    ->first();
                if ($requisito) {
                    $req = RequisitoCandidato::findOrFail($requisito->id_requisito_candidato);
                    $req->ubicacion = '';
                    $req->observacion = null;
                    $req->fecha_carga = date("Y-m-d H:i:s");
                    $req->valido = 0;
                    $req->revisado = 0;
                    $req->fecha_revision = null;
                    $req->save();
                    $this->requisitos_cargados[] = ['requisito' => $requisito->requisito];
                } else {
                    RequisitoCandidato::create([
                        'candidatos_id' => $this->id_candidato,
                        'puestos_nominales_id' => $this->id_puesto,
                        'requisitos_id' => $this->id_requisito,
                        'ubicacion' => ''
                    ]);

                    $reqs_puesto = RequisitoPuesto::select('requisitos_id')->where('puestos_nominales_id', $this->id_puesto)
                        ->orderBy('requisitos_id', 'asc')->pluck('requisitos_id')->toArray();

                    $reqs_candidato = RequisitoCandidato::select('requisitos_id')->where('candidatos_id', $this->id_candidato)
                        ->orderBy('requisitos_id', 'asc')
                        ->pluck('requisitos_id')
                        ->toArray();

                    $dif_reqs = array_diff($reqs_puesto, $reqs_candidato);
                    if (count($dif_reqs) == 0) {
                        $aplicacion = AplicacionCandidato::select('id')->where('candidatos_id', $this->id_candidato)
                            ->where('puestos_nominales_id', $this->id_puesto)
                            ->first();
                        $id_aplicacion = $aplicacion->id;
                        DB::transaction(function () use ($id_aplicacion) {
                            EtapaAplicacion::where('etapas_procesos_id', 1)
                                ->where('aplicaciones_candidatos_id', $id_aplicacion)
                                ->update([
                                    'fecha_fin' => now()
                                ]);

                            EtapaAplicacion::create([
                                'fecha_inicio' => now(),
                                'etapas_procesos_id' => 2,
                                'aplicaciones_candidatos_id' => $id_aplicacion
                            ]);
                        });
                    }

                    $nuevo_requisito = RequisitoCandidato::where('candidatos_id', $this->id_candidato)
                        ->where('puestos_nominales_id', $this->id_puesto)
                        ->where('requisitos_id', $this->id_requisito)
                        ->join('requisitos', 'requisitos_candidatos.requisitos_id', '=', 'requisitos.id')
                        ->select('requisitos.requisito as requisito')
                        ->first();

                    $this->requisitos_cargados[] = ['requisito' => $nuevo_requisito->requisito];
                }
            });
            Notification::route('mail', 'ing.sergiodaniel@gmail.com')
                ->notify(new NotificacionCargaRequisitos($this->requisitos_cargados, $this->nombre_candidato, $this->id_candidato));
            return redirect()->route('presentar_requisitos', ['id_candidato' => $this->id_candidato]);
        } catch (Exception $e) {
            $errorMessages = "Ocurrió un error: " . $e->getMessage();
            session()->flash('error', $errorMessages);
            return redirect()->route('presentar_formulario', ['id_candidato' => $this->id_candidato, 'id_requisito' => $this->id_requisito]);
        }
    }

    public function mount($id_candidato, $id_requisito)
    {
        $this->id_candidato = $id_candidato;
        $nombre_candidato = DB::table('candidatos')->select('nombre')->where('id', '=', $id_candidato)->first();
        $this->nombre_candidato = $nombre_candidato->nombre;
        $this->id_requisito = $id_requisito;
        $this->cargarPuesto($id_candidato);

        $candidato = Empleado::where([
            'candidatos_id' => $id_candidato
        ])->select(
            'empleados.id as id_empleado',
            'empleados.nit as nit',
            'empleados.igss as igss',
            'empleados.imagen as imagen',
            'empleados.nombres as nombres',
            'empleados.apellidos as apellidos',
            'empleados.email as email',
            'empleados.fecha_nacimiento as fecha_nacimiento',
            'empleados.pretension_salarial as pretension_salarial',
            'empleados.estudia_actualmente as estudia_actualmente',
            'empleados.cantidad_personas_dependientes as cantidad_personas_dependientes',
            'empleados.ingresos_adicionales as ingresos_adicionales',
            'empleados.monto_ingreso_total as monto_ingreso_total',
            'empleados.posee_deudas as posee_deudas',
            'empleados.trabajo_conred as trabajo_conred',
            'empleados.trabajo_estado as trabajo_estado',
            'empleados.jubilado_estado as jubilado_estado',
            'empleados.institucion_jubilacion as institucion_jubilacion',
            'empleados.personas_aportan_ingresos as personas_aportan_ingresos',
            'empleados.fuente_ingresos_adicionales as fuente_ingresos_adicionales',
            'empleados.pago_vivienda as pago_vivienda',
            'empleados.familiar_conred as familiar_conred',
            'empleados.conocido_conred as conocido_conred',
            'empleados.otro_etnia as otro_etnia',
            'direcciones.id as id_direccion',
            'direcciones.direccion as direccion',
            'municipios.id as id_municipio_residencia',
            'municipios.nombre as municipio_residencia',
            'departamentos.id as id_departamento_residencia',
            'departamentos.nombre as departamento_residencia',
            'municipios.id as id_municipio',
            'municipios.nombre as municipio',
            'departamentos.id as id_departamento',
            'departamentos.nombre as departamento',
            'nacionalidades.id as id_nacionalidad',
            'nacionalidades.nacionalidad as nacionalidad',
            'estados_civiles.id as id_estado_civil',
            'estados_civiles.estado_civil as estado_civil',
            'dpis.dpi as dpi',
            'municipios.id as id_municipio_emision',
            'municipios.nombre as municipio_emision',
            'departamentos.id as id_departamento_emision',
            'departamentos.nombre as departamento_emision',
            'licencias_conducir.licencia as licencia',
            'tipos_licencias.id as id_tipo_licencia',
            'tipos_licencias.tipo_licencia as tipo_licencia',
            'tipos_vehiculos.id as id_tipo_vehiculo',
            'tipos_vehiculos.tipo_vehiculo as tipo_vehiculo',
            'vehiculos.placa as placa',
            'telefonos_empleados.id as id_telefono_empleado',
            'telefonos_empleados.telefono_casa as telefono_casa',
            'telefonos_empleados.telefono as telefono',
            'familiares_conred.id as id_familiar_conred',
            'familiares_conred.nombre as nombre_familiar_conred',
            'familiares_conred.cargo as cargo_familiar_conred',
            'conocidos_conred.id as id_conocido_conred',
            'conocidos_conred.nombre as nombre_conocido_conred',
            'conocidos_conred.cargo as cargo_conocido_conred',
            'padres_empleados.id as id_padre',
            'padres_empleados.telefono as telefono_padre',
            'padres_empleados.nombre as nombre_padre',
            'padres_empleados.ocupacion as ocupacion_padre',
            'madres_empleados.id as id_madre',
            'madres_empleados.telefono as telefono_madre',
            'madres_empleados.nombre as nombre_madre',
            'madres_empleados.ocupacion as ocupacion_madre',
            'convivientes.id as id_conviviente',
            'convivientes.telefono as telefono_conviviente',
            'convivientes.nombre as nombre_conviviente',
            'convivientes.ocupacion as ocupacion_conviviente',
            'estudios_actuales_empleados.id as id_estudio_actual',
            'estudios_actuales_empleados.carrera as estudio_actual',
            'estudios_actuales_empleados.establecimiento as establecimiento_estudio_actual',
            'estudios_actuales_empleados.horario as horario_estudio_actual',
            'etnias.id as id_etnia',
            'etnias.etnia as etnia',
            'tipos_viviendas.id as id_tipo_vivienda',
            'tipos_viviendas.tipo_vivienda as tipo_vivienda',
            'deudas.id as id_deuda',
            'deudas.monto as monto_deuda',
            'tipos_deudas.id as id_tipo_deuda',
            'tipos_deudas.tipo_deuda as tipo_deuda',
            'historias_clinicas.id as id_historia_clinica',
            'historias_clinicas.padecimiento_salud as padecimiento_salud',
            'historias_clinicas.tipo_enfermedad as tipo_enfermedad',
            'historias_clinicas.intervencion_quirurgica as intervencion_quirurgica',
            'historias_clinicas.tipo_intervencion as tipo_intervencion',
            'historias_clinicas.sufrido_accidente as sufrido_accidente',
            'historias_clinicas.tipo_accidente as tipo_accidente',
            'historias_clinicas.alergia_medicamento as alergia_medicamento',
            'historias_clinicas.tipo_medicamento as tipo_medicamento',
            'grupos_sanguineos.id as id_tipo_sangre',
            'grupos_sanguineos.grupo as tipo_sangre',
            'contactos_emergencias.id as id_contacto_emergencia',
            'contactos_emergencias.nombre as nombre_contacto_emergencia',
            'contactos_emergencias.telefono as telefono_contacto_emergencia',
            'contactos_emergencias.direccion as direccion_contacto_emergencia'

        )
            ->join('direcciones', 'empleados.id', '=', 'direcciones.empleados_id')
            ->join('municipios as mun_residencia', 'direcciones.municipios_id', '=', 'mun_residencia.id')
            ->join('departamentos as dep_residencia', 'mun_residencia.departamentos_id', '=', 'dep_residencia.id')
            ->join('municipios', 'empleados.municipios_id', '=', 'municipios.id')
            ->join('departamentos', 'municipios.departamentos_id', '=', 'departamentos.id')
            ->join('nacionalidades', 'empleados.nacionalidades_id', '=', 'nacionalidades.id')
            ->join('estados_civiles', 'empleados.estados_civiles_id', '=', 'estados_civiles.id')
            ->join('dpis', 'empleados.id', '=', 'dpis.empleados_id')
            ->join('municipios as mun_emision', 'dpis.municipios_id', '=', 'mun_emision.id')
            ->join('departamentos as dep_emision', 'mun_emision.departamentos_id', '=', 'dep_emision.id')
            ->leftjoin('vehiculos', 'empleados.id', '=', 'vehiculos.empleados_id')
            ->join('tipos_vehiculos', 'vehiculos.tipos_vehiculos_id', '=', 'tipos_vehiculos.id')
            ->leftjoin('licencias_conducir', 'empleados.id', '=', 'licencias_conducir.empleados_id')
            ->leftjoin('tipos_licencias', 'licencias_conducir.tipos_licencias_id', '=', 'tipos_licencias.id')
            ->join('telefonos_empleados', 'empleados.id', '=', 'telefonos_empleados.empleados_id')
            ->leftjoin('familiares_conred', 'empleados.id', '=', 'familiares_conred.empleados_id')
            ->leftjoin('conocidos_conred', 'empleados.id', '=', 'conocidos_conred.empleados_id')
            ->join('padres_empleados', 'empleados.id', '=', 'padres_empleados.empleados_id')
            ->join('madres_empleados', 'empleados.id', '=', 'madres_empleados.empleados_id')
            ->leftjoin('convivientes', 'empleados.id', '=', 'convivientes.empleados_id')
            ->leftjoin('estudios_actuales_empleados', 'empleados.id', '=', 'estudios_actuales_empleados.empleados_id')
            ->join('etnias', 'empleados.etnias_id', '=', 'etnias.id')
            ->join('tipos_viviendas', 'empleados.tipos_viviendas_id', '=', 'tipos_viviendas.id')
            ->leftjoin('deudas', 'empleados.id', '=', 'deudas.empleados_id')
            ->leftjoin('tipos_deudas', 'deudas.tipos_deudas_id', '=', 'tipos_deudas.id')
            ->join('historias_clinicas', 'empleados.id', '=', 'historias_clinicas.empleados_id')
            ->join('grupos_sanguineos', 'empleados.grupos_sanguineos_id', '=', 'grupos_sanguineos.id')
            ->join('contactos_emergencias', 'empleados.id', '=', 'contactos_emergencias.empleados_id')
            ->first();

        if ($candidato) {
            $this->id_empleado = $candidato->id_empleado;
            $this->imagen = $candidato->imagen;
            $this->imagen_actual = $candidato->imagen;
            $this->nombres = $candidato->nombres;
            $this->apellidos = $candidato->apellidos;
            $this->pretension_salarial = $candidato->pretension_salarial;
            $this->departamento = $candidato->id_departamento;
            $this->getMunicipiosByDepartamento();
            $this->municipio = $candidato->id_municipio;
            $this->fecha_nacimiento = $candidato->fecha_nacimiento;
            $this->nacionalidad = $candidato->id_nacionalidad;
            $this->estado_civil = $candidato->id_estado_civil;
            $this->direccion = $candidato->direccion;
            $this->departamento_residencia = $candidato->id_departamento_residencia;
            $this->getMunicipiosByDepartamentoResidencia();
            $this->municipio_residencia = $candidato->id_municipio_residencia;
            $this->dpi = $candidato->dpi;
            $this->departamento_emision = $candidato->id_departamento_emision;
            $this->getMunicipiosByDepartamentoEmision();
            $this->municipio_emision = $candidato->id_municipio_emision;
            $this->igss = $candidato->igss;
            $this->nit = $candidato->nit;
            $this->licencia = $candidato->licencia;
            $this->tipo_licencia = $candidato->id_tipo_licencia;
            $this->tipo_vehiculo = $candidato->id_tipo_vehiculo;
            $this->placa = $candidato->placa;
            $this->telefono_casa = $candidato->telefono_casa;
            $this->telefono_movil = $candidato->telefono;
            $this->email = $candidato->email;
            $this->familiar_conred = $candidato->familiar_conred;
            $this->nombre_familiar_conred = $candidato->nombre_familiar_conred;
            $this->cargo_familiar_conred = $candidato->cargo_familiar_conred;
            $this->conocido_conred = $candidato->conocido_conred;
            $this->nombre_conocido_conred = $candidato->nombre_conocido_conred;
            $this->cargo_conocido_conred = $candidato->cargo_conocido_conred;
            $this->telefono_padre = $candidato->telefono_padre;
            $this->nombre_padre = $candidato->nombre_padre;
            $this->ocupacion_padre = $candidato->ocupacion_padre;
            $this->telefono_madre = $candidato->telefono_madre;
            $this->nombre_madre = $candidato->nombre_madre;
            $this->ocupacion_madre = $candidato->ocupacion_madre;
            $this->telefono_conviviente = $candidato->telefono_conviviente;
            $this->nombre_conviviente = $candidato->nombre_conviviente;
            $this->ocupacion_conviviente = $candidato->ocupacion_conviviente;
            $this->hijos = HijoEmpleado::where('empleados_id', $candidato->id_empleado)
                ->get()
                ->toArray();
            $estudios = RegistroAcademicoEmpleado::where('empleados_id', $candidato->id_empleado)->get();
            foreach ($estudios as $es) {
                if ($es->registros_academicos_id == 1) {
                    $this->establecimiento_primaria = $es->establecimiento;
                    $this->titulo_primaria = $es->titulo;
                } elseif ($es->registros_academicos_id == 2) {
                    $this->establecimiento_secundaria = $es->establecimiento;
                    $this->titulo_secundaria = $es->titulo;
                } elseif ($es->registros_academicos_id == 3) {
                    $this->establecimiento_diversificado = $es->establecimiento;
                    $this->titulo_diversificado = $es->titulo;
                } elseif ($es->registros_academicos_id == 6) {
                    $this->establecimiento_universitario = $es->establecimiento;
                    $this->titulo_universitario = $es->titulo;
                } elseif ($es->registros_academicos_id == 8) {
                    $this->establecimiento_maestria_postgrado = $es->establecimiento;
                    $this->titulo_maestria_postgrado = $es->titulo;
                } elseif ($es->registros_academicos_id == 10) {
                    $this->establecimiento_otra_especialidad = $es->establecimiento;
                    $this->titulo_otra_especialidad;
                }
            }
            $this->estudia_actualmente = $candidato->estudia_actualmente;
            $this->estudio_actual = $candidato->estudio_actual;
            $this->horario_estudio_actual = $candidato->horario_estudio_actual;
            $this->establecimiento_estudio_actual = $candidato->establecimiento_estudio_actual;
            $this->etnia = $candidato->id_etnia;
            $this->otro_etnia = $candidato->otro_etnia;
            $this->idiomas = Idioma::where('empleados_id', $candidato->id_empleado)->get()->toArray();
            $this->programas = ProgramaComputacion::where('empleados_id', $candidato->id_empleado)->get()->toArray();
            $this->historiales_laborales = HistorialLaboral::where('empleados_id', $candidato->id_empleado)->get()->toArray();
            $this->referencias_personales = ReferenciaPersonal::where('empleados_id', $candidato->id_empleado)->get()->toArray();
            $this->referencias_laborales = ReferenciaLaboral::where('empleados_id', $candidato->id_empleado)->get()->toArray();
            $this->tipo_vivienda = $candidato->id_tipo_vivienda;
            $this->pago_vivienda = $candidato->pago_vivienda;
            $this->cantidad_personas_dependientes = $candidato->cantidad_personas_dependientes;
            $this->personas_dependientes = PersonaDependiente::where('empleados_id', $candidato->id_empleado)->get()->toArray();
            $this->ingresos_adicionales = $candidato->ingresos_adicionales;
            $this->fuente_ingresos_adicionales = $candidato->fuente_ingresos_adicionales;
            $this->personas_aportan_ingresos = $candidato->personas_aportan_ingresos;
            $this->monto_ingreso_total = $candidato->monto_ingreso_total;
            $this->posee_deudas = $candidato->posee_deudas;
            $this->tipo_deuda = $candidato->id_tipo_deuda;
            $this->monto_deuda = $candidato->monto_deuda;
            $this->trabajo_conred = $candidato->trabajo_conred;
            $this->trabajo_estado = $candidato->trabajo_estado;
            $this->jubilado_estado = $candidato->jubilado_estado;
            $this->institucion_jubilacion = $candidato->institucion_jubilacion;
            $this->padecimiento_salud = $candidato->padecimiento_salud;
            $this->tipo_enfermedad = $candidato->tipo_enfermedad;
            $this->intervencion_quirurgica = $candidato->intervencion_quirurgica;
            $this->tipo_intervencion = $candidato->tipo_intervencion;
            $this->sufrido_accidente = $candidato->sufrido_accidente;
            $this->tipo_accidente = $candidato->tipo_accidente;
            $this->alergia_medicamento = $candidato->alergia_medicamento;
            $this->tipo_medicamento = $candidato->tipo_medicamento;
            $this->tipo_sangre = $candidato->id_tipo_sangre;
            $this->nombre_contacto_emergencia = $candidato->nombre_contacto_emergencia;
            $this->telefono_contacto_emergencia = $candidato->telefono_contacto_emergencia;
            $this->direccion_contacto_emergencia = $candidato->direccion_contacto_emergencia;
        }
    }

    public function cargarPuesto($id_candidato)
    {
        $puesto = DB::table('catalogo_puestos')
            ->join('puestos_nominales', 'catalogo_puestos.id', '=', 'puestos_nominales.catalogo_puestos_id')
            ->join('aplicaciones_candidatos', 'puestos_nominales.id', '=', 'aplicaciones_candidatos.puestos_nominales_id')
            ->select('puestos_nominales.id as id_puesto', 'catalogo_puestos.puesto as puesto')
            ->where('aplicaciones_candidatos.candidatos_id', '=', $id_candidato)
            ->first();
        $this->puesto = $puesto->puesto;
        $this->id_puesto = $puesto->id_puesto;
    }

    public function getMunicipiosByDepartamento()
    {
        $this->municipio = '';
        if ($this->departamento) {
            $this->municipios = DB::table('municipios')
                ->select('id', 'nombre', 'departamentos_id')
                ->where('departamentos_id', '=', $this->departamento)
                ->get();
        } else {
            $this->municipios = [];
        }
    }

    public function getMunicipiosByDepartamentoEmision()
    {
        $this->municipio_emision = '';
        if ($this->departamento_emision) {
            $this->municipios_emision = DB::table('municipios')
                ->select('id', 'nombre', 'departamentos_id')
                ->where('departamentos_id', '=', $this->departamento_emision)
                ->get();
        } else {
            $this->municipios = [];
        }
    }

    public function getMunicipiosByDepartamentoResidencia()
    {
        $this->municipio_residencia = '';
        if ($this->departamento_residencia) {
            $this->municipios_residencia = DB::table('municipios')
                ->select('id', 'nombre', 'departamentos_id')
                ->where('departamentos_id', '=', $this->departamento_residencia)
                ->get();
        } else {
            $this->municipios = [];
        }
    }


    public function add_son()
    {
        $this->hijos[] = ['nombre' => ''];
    }

    public function remove_son($index)
    {
        if (count($this->hijos) > 1) {
            unset($this->hijos[$index]);
            $this->hijos = array_values($this->hijos);
        }
    }

    public function add_lang()
    {
        $this->idiomas[] = ['idioma' => '', 'habla' => '', 'lee' => '', 'escribe' => ''];
    }

    public function remove_lang($index)
    {
        if (count($this->idiomas) > 1) {
            unset($this->idiomas[$index]);
            $this->idiomas = array_values($this->idiomas);
        }
    }

    public function add_program()
    {
        $this->programas[] = ['programa' => '', 'valoracion' => ''];
    }

    public function remove_program($index)
    {
        unset($this->programas[$index]);
        $this->programas = array_values($this->programas);
    }

    public function add_persona_dependiente()
    {
        $this->personas_dependientes[] = ['nombre' => '', 'parentesco' => ''];
    }

    public function remove_persona_dependiente($index)
    {
        unset($this->personas_dependientes[$index]);
        $this->personas_dependientes = array_values($this->personas_dependientes);
    }
}
