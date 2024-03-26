<?php

namespace App\Livewire\Empleados;

use App\Models\BonoAnualContrato;
use App\Models\BonoPuesto;
use App\Models\ConocidoConred;
use App\Models\ContactoEmergencia;
use App\Models\Contrato;
use App\Models\Conviviente;
use App\Models\Departamento;
use App\Models\DependenciaFuncional;
use App\Models\DependenciaNominal;
use App\Models\Deuda;
use App\Models\Direccion;
use App\Models\Dpi;
use App\Models\Empleado;
use App\Models\EstadoCivil;
use App\Models\EstudioActualEmpleado;
use App\Models\EtapaProceso;
use App\Models\Etnia;
use App\Models\FamiliarConred;
use App\Models\Genero;
use App\Models\GrupoSanguineo;
use App\Models\HijoEmpleado;
use App\Models\HistoriaClinica;
use App\Models\HistorialLaboral;
use App\Models\Idioma;
use App\Models\InduccionPendiente;
use App\Models\LicenciaConducir;
use App\Models\MadreEmpleado;
use App\Models\Nacionalidad;
use App\Models\PadreEmpleado;
use App\Models\PagoContrato;
use App\Models\PeriodoContrato;
use App\Models\PersonaDependiente;
use App\Models\ProgramaComputacion;
use App\Models\PuestoNominal;
use App\Models\ReferenciaLaboral;
use App\Models\ReferenciaPersonal;
use App\Models\Region;
use App\Models\RegistroAcademicoEmpleado;
use App\Models\RegistroPuesto;
use App\Models\RelacionLaboral;
use App\Models\TelefonoEmpleado;
use App\Models\TipoContratacion;
use App\Models\TipoDeuda;
use App\Models\TipoLicencia;
use App\Models\TipoServicio;
use App\Models\TipoVehiculo;
use App\Models\TipoVivienda;
use App\Models\VacacionDisponible;
use App\Models\Vehiculo;
use Carbon\Carbon;
use Exception;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class Empleados extends Component
{
    use WithFileUploads;
    use WithPagination;

    /* Colecciones */
    public $generos, $etnias, $grupos_sanguineos, $dependencias_nominales, $dependencias_funcionales, $departamentos_origen,
        $municipios, $municipios_emision, $municipios_residencia, $nacionalidades, $tipos_viviendas, $estados_civiles,
        $tipos_licencias, $tipos_vehiculos, $tipos_deudas, $puestos_nominales, $puestos_funcionales, $tipos_servicios,
        $tipos_contrataciones, $regiones, $relaciones_laborales, $total_etapas;

    /* Filtros y busqueda */
    public $busqueda, $filtro;

    /* Variables de formulario */
    public $empleado, $id_candidato, $id_empleado, $codigo, $dpi, $nit, $cuenta_banco, $igss, $imagen, $nombres, $apellidos,
        $email, $pretension_salarial, $departamento_origen, $municipio, $fecha_nacimiento, $nacionalidad, $estado_civil, $direccion_domicilio,
        $departamento_residencia, $municipio_residencia, $departamento_emision, $municipio_emision, $licencia, $relacion_laboral,
        $tipo_licencia, $tipo_vehiculo, $placa, $telefono_casa, $telefono_movil, $familiar_conred, $nombre_familiar_conred, $genero,
        $cargo_familiar_conred, $conocido_conred, $nombre_conocido_conred, $cargo_conocido_conred, $telefono_padre, $nombre_padre,
        $ocupacion_padre, $telefono_madre, $nombre_madre, $ocupacion_madre, $telefono_conviviente, $nombre_conviviente,
        $ocupacion_conviviente, $establecimiento_primaria, $titulo_primaria, $establecimiento_secundaria, $titulo_secundaria,
        $establecimiento_diversificado, $titulo_diversificado, $establecimiento_universitario, $titulo_universitario,
        $establecimiento_maestria_postgrado, $titulo_maestria_postgrado, $establecimiento_otra_especialidad, $titulo_otra_especialidad,
        $estudia_actualmente, $estudio_actual, $horario_estudio_actual, $establecimiento_estudio_actual, $etnia, $otro_etnia,
        $tipo_vivienda, $pago_vivienda, $cantidad_personas_dependientes, $ingresos_adicionales, $fuente_ingresos_adicionales,
        $personas_aportan_ingresos, $monto_ingreso_total, $posee_deudas, $tipo_deuda, $monto_deuda, $trabajo_conred, $trabajo_estado,
        $jubilado_estado, $institucion_jubilacion, $padecimiento_salud, $tipo_enfermedad, $intervencion_quirurgica, $tipo_intervencion,
        $sufrido_accidente, $tipo_accidente, $alergia_medicamento, $tipo_medicamento, $tipo_sangre, $nombre_contacto_emergencia,
        $telefono_contacto_emergencia, $direccion_contacto_emergencia, $estado_familiar;

    /* Arrays de formulario */
    public $hijos = [['nombre' => '']],
        $idiomas = [['idioma' => '', 'habla' => '', 'lee' => '', 'escribe' => '']],
        $si_no = [['val' => 0, 'res' => 'No'], ['val' => 1, 'res' => 'Sí']],
        $estados_familiares = [['val' => 1, 'res' => 'Madre de familia'], ['val' => 1, 'res' => 'Padre de familia']],
        $programas = [['programa' => '', 'valoracion' => '']],
        $personas_dependientes = [['nombre' => '', 'parentesco' => '']],
        $requisitos_cargados = [],
        $historiales_laborales = [
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

    /* Variables de edición */
    public $imagen_actual;

    /* Modal Crear y Editar*/
    public $modal = false;

    /* Modal Crear y Editar Contrato */
    public $modal_crear_contrato = false;
    public $puesto_nominal, $puesto_funcional, $dependencia_nominal, $dependencia_funcional, $region, $fecha_inicio,
        $fecha_fin, $observacion, $salario, $tipo_servicio, $tipo_contratacion, $contrato_correlativo, $contrato_renglon,
        $contrato_year, $numero_contrato, $aprobacion_correlativo, $aprobacion_renglon, $aprobacion_year, $acuerdo_aprobacion,
        $nit_autorizacion, $fianza, $rescision_form = false;

    /* Variables organigrama */
    public $secretaria, $subsecretarias = [], $subsecretaria, $direcciones = [], $direccion, $subdirecciones = [], $subdireccion, $departamentos = [],
        $departamento, $delegaciones = [], $delegacion;

    public function render()
    {
        $this->departamentos_origen = Departamento::select('id', 'nombre')->get();
        $this->nacionalidades = Nacionalidad::select('id', 'nacionalidad')->get();
        $this->estados_civiles = EstadoCivil::select('id', 'estado_civil')->get();
        $this->generos = Genero::select('id', 'genero')->get();
        $this->tipos_licencias = TipoLicencia::select('id', 'tipo_licencia')->get();
        $this->tipos_vehiculos = TipoVehiculo::select('id', 'tipo_vehiculo')->get();
        $this->etnias = Etnia::select('id', 'etnia')->get();
        $this->tipos_viviendas = TipoVivienda::select('id', 'tipo_vivienda')->get();
        $this->tipos_deudas = TipoDeuda::select('id', 'tipo_deuda')->get();
        $this->grupos_sanguineos = GrupoSanguineo::select('id', 'grupo')->get();
        $this->dependencias_nominales = DependenciaNominal::select('id', 'dependencia')->whereNull('nodo_padre')->get();
        $this->tipos_servicios = TipoServicio::select('id', 'tipo_servicio')->get();
        $this->tipos_contrataciones = TipoContratacion::select('id', 'tipo')->get();
        $this->dependencias_funcionales = DependenciaFuncional::select('id', 'dependencia')->get();
        $this->regiones = Region::select('id', 'region', 'nombre')->get();
        $this->relaciones_laborales = RelacionLaboral::select('id', 'relacion_laboral')->get();
        $this->total_etapas = count(EtapaProceso::all());

        $empleados = Empleado::select(
            'empleados.id as id',
            'empleados.imagen as imagen',
            'empleados.codigo as codigo',
            'empleados.nombres as nombres',
            'empleados.apellidos as apellidos',
            'empleados.nit as nit',
            'empleados.estado as estado',
            'empleados.relaciones_laborales_id as id_relacion_laboral',
            'empleados.candidatos_id as id_candidato',
            'dpis.dpi as dpi',
            DB::raw('(SELECT titulo FROM registros_academicos_empleados 
            WHERE empleados_id = empleados.id 
            AND registros_academicos_id != 10
            ORDER BY registros_academicos_id DESC LIMIT 1) as profesion'),
            DB::raw('(SELECT COUNT(*) FROM contratos 
            WHERE empleados_id = empleados.id) as total_contratos'),
            DB::raw('COUNT(etapas_aplicaciones.id) as etapas_completas')
        )
            ->join('dpis', 'empleados.id', '=', 'dpis.empleados_id')
            ->leftjoin('candidatos', 'empleados.candidatos_id', '=', 'candidatos.id')
            ->leftjoin('aplicaciones_candidatos', 'candidatos.id', '=', 'aplicaciones_candidatos.candidatos_id')
            ->leftjoin('etapas_aplicaciones', function ($join) {
                $join->on('aplicaciones_candidatos.id', '=', 'etapas_aplicaciones.aplicaciones_candidatos_id')
                    ->whereNotNull('etapas_aplicaciones.fecha_fin');
            })
            ->groupBy('empleados.id');
        if (!empty($this->filtro)) {
            $empleados->where(function ($query) {
                $query->where('empleados.nombres', 'LIKE', '%' . $this->filtro . '%')
                    ->orWhere('empleados.apellidos', 'LIKE', '%' . $this->filtro . '%')
                    ->orWhere('empleados.codigo', 'LIKE', '%' . $this->filtro . '%')
                    ->orWhere('empleados.nit', 'LIKE', '%' . $this->filtro . '%')
                    ->orWhere('dpis.dpi', 'LIKE', '%' . $this->filtro . '%');;
            });
        }
        $empleados = $empleados->paginate(5);
        activity()
            ->causedBy(auth()->user())
            ->withProperties(['user_id' => auth()->id()])
            ->log("El usuario " . auth()->user()->name .  " visitó la página: " . request()->path());
        return view('livewire.empleados.empleados', [
            'empleados' => $empleados
        ]);
    }

    public function guardar()
    {
        $img = '';
        if (empty($this->imagen_actual)) {
            $validated = $this->validate([
                'imagen' => 'image|required|mimes:jpg,jpeg,png|max:2048'
            ]);
        }
        $validated = $this->validate([
            'nombres' => 'required|filled|regex:/^[A-Za-záàéèíìóòúùÁÀÉÈÍÌÓÒÚÙüÜñÑ\s]+$/',
            'apellidos' => 'required|filled|regex:/^[A-Za-záàéèíìóòúùÁÀÉÈÍÌÓÒÚÙüÜñÑ\s]+$/',
            'codigo' => 'required|filled|string|min:9|regex:/^9[1-9]\d{7,}$/',
            'pretension_salarial' => 'required|decimal:2',
            'departamento_origen' => 'required|integer|min:1',
            'municipio' => 'required|integer|min:1',
            'fecha_nacimiento' => 'required|date|before_or_equal:' . \Carbon\Carbon::now()->subYears(18)->format('Y-m-d'),
            'nacionalidad' => 'required|integer|min:1',
            'genero' => 'required|integer|min:1',
            'relacion_laboral' => 'required|integer|min:1|max:3',
            'estado_civil' => 'required|integer|min:1',
            'estado_familiar' => 'nullable|integer',
            'direccion_domicilio' => 'required|filled',
            'departamento_residencia' => 'required|integer|min:1',
            'municipio_residencia' => 'required|integer|min:1',
            'dpi' => ['required', 'filled', 'size:15', 'regex:/^[1-9]\d{3} [1-9][0-9]{4} ([0][1-9]|[1][0-9]|[2][0-2])([0][1-9]|[1][0-9]|[2][0-9]|[3][0-9])$/'],
            'departamento_emision' => 'required|integer|min:1',
            'municipio_emision' => 'required|integer|min:1',
            'igss' => 'nullable',
            'nit' => 'required|filled',
            'cuenta_banco' => 'required|filled',
            'licencia' => 'nullable',
            'tipo_licencia' => 'nullable|integer',
            'tipo_vehiculo' => 'nullable|integer',
            'placa' => 'nullable|regex:/^[PM]\d{3}[BCDFGHJKLMNPQRSTVWXYZ]{3}$/',
            'telefono_casa' => ['nullable', 'regex:/^(2|3|4|5|7)\d{3}-\d{4}$/'],
            'telefono_movil' => ['required', 'regex:/^(3|4|5)\d{3}-\d{4}$/'],
            'email' => 'required|filled|email:dns',
            'familiar_conred' => 'required|min:0',
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
            'historiales_laborales.*.desde' => ['required_with:historiales_laborales.*.empresa', 'date'],
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
                $img = $this->imagen->store('empleados', 'public');
                Storage::delete('public/' . $this->imagen_actual);
            }

            DB::transaction(function () use ($validated, $img) {
                $this->empleado = Empleado::updateOrCreate(['id' => $this->id_empleado], [
                    'codigo' => $validated['codigo'],
                    'nit' => $validated['nit'],
                    'igss' => $validated['igss'],
                    'imagen' => $img,
                    'nombres' => $validated['nombres'],
                    'apellidos' => $validated['apellidos'],
                    'email' => $validated['email'],
                    'fecha_nacimiento' => $validated['fecha_nacimiento'],
                    'cuenta_banco' => $validated['cuenta_banco'],
                    'estado_familiar' => $validated['estado_familiar'],
                    'estado_familiar' => $validated['estado_familiar'],
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
                    'generos_id' => $validated['genero'],
                    'grupos_sanguineos_id' => $validated['tipo_sangre'],
                    'municipios_id' => $validated['municipio'],
                    'nacionalidades_id' => $validated['nacionalidad'],
                    'tipos_viviendas_id' => $validated['tipo_vivienda'],
                    'estados_civiles_id' => $validated['estado_civil'],
                    'relaciones_laborales_id' => $validated['relacion_laboral']
                ]);

                Direccion::updateOrCreate(['empleados_id' => $this->empleado->id], [
                    'direccion' => $validated['direccion_domicilio'],
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

                /* Creación de registro para nuevos empleados que se guardan como pendientes de capacitación de inducción */
                if ($validated['relacion_laboral'] == 3) {
                    InduccionPendiente::updateOrCreate(['empleados_id' => $this->empleado->id], [
                        'pendiente' => 1
                    ]);
                }
            });

            session()->flash('message');
            $this->cerrarModal();
            activity()
                ->causedBy(auth()->user())
                ->withProperties(['user_id' => auth()->id()])
                ->log("El usuario " . auth()->user()->name . " guardó el empleado: " . $this->nombres . ' ' . $this->apellidos);
            return redirect()->route('empleados');
        } catch (Exception $e) {
            $errorMessages = "Ocurrió un error: " . $e->getMessage();
            session()->flash('error', $errorMessages);
            $this->cerrarModal();
            return redirect()->route('empleados');
        }
    }

    public function editar($id_empleado)
    {
        $this->id_empleado = $id_empleado;
        $empleado = Empleado::where([
            'empleados.id' => $id_empleado
        ])->select(
            'empleados.id as id_empleado',
            'empleados.codigo as codigo',
            'empleados.nit as nit',
            'empleados.igss as igss',
            'empleados.imagen as imagen',
            'empleados.nombres as nombres',
            'empleados.apellidos as apellidos',
            'empleados.email as email',
            'empleados.fecha_nacimiento as fecha_nacimiento',
            'empleados.cuenta_banco as cuenta_banco',
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
            'relaciones_laborales.id as id_relacion_laboral',
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
            'contactos_emergencias.direccion as direccion_contacto_emergencia',
            'relaciones_laborales.id as id_relaciones_laborales',
            'generos.id as id_genero'

        )
            ->join('direcciones', 'empleados.id', '=', 'direcciones.empleados_id')
            ->join('relaciones_laborales', 'empleados.relaciones_laborales_id', '=', 'relaciones_laborales.id')
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
            ->leftjoin('tipos_vehiculos', 'vehiculos.tipos_vehiculos_id', '=', 'tipos_vehiculos.id')
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
            ->leftjoin('generos', 'empleados.generos_id', '=', 'generos.id')
            ->first();

        if ($empleado) {
            $this->imagen = $empleado->imagen;
            $this->imagen_actual = $empleado->imagen;
            $this->codigo = $empleado->codigo;
            $this->nombres = $empleado->nombres;
            $this->apellidos = $empleado->apellidos;
            $this->pretension_salarial = $empleado->pretension_salarial;
            $this->departamento_origen = $empleado->id_departamento;
            $this->getMunicipiosByDepartamento();
            $this->municipio = $empleado->id_municipio;
            $this->relacion_laboral = $empleado->id_relacion_laboral;
            $this->genero = $empleado->id_genero;
            $this->fecha_nacimiento = $empleado->fecha_nacimiento;
            $this->cuenta_banco = $empleado->cuenta_banco;
            $this->nacionalidad = $empleado->id_nacionalidad;
            $this->estado_civil = $empleado->id_estado_civil;
            $this->direccion_domicilio = $empleado->direccion;
            $this->estado_familiar = $empleado->estado_familiar;
            $this->departamento_residencia = $empleado->id_departamento_residencia;
            $this->getMunicipiosByDepartamentoResidencia();
            $this->municipio_residencia = $empleado->id_municipio_residencia;
            $this->dpi = $empleado->dpi;
            $this->departamento_emision = $empleado->id_departamento_emision;
            $this->getMunicipiosByDepartamentoEmision();
            $this->municipio_emision = $empleado->id_municipio_emision;
            $this->igss = $empleado->igss;
            $this->nit = $empleado->nit;
            $this->licencia = $empleado->licencia;
            $this->tipo_licencia = $empleado->id_tipo_licencia;
            $this->tipo_vehiculo = $empleado->id_tipo_vehiculo;
            $this->placa = $empleado->placa;
            $this->telefono_casa = $empleado->telefono_casa;
            $this->telefono_movil = $empleado->telefono;
            $this->email = $empleado->email;
            $this->familiar_conred = $empleado->familiar_conred;
            $this->nombre_familiar_conred = $empleado->nombre_familiar_conred;
            $this->cargo_familiar_conred = $empleado->cargo_familiar_conred;
            $this->conocido_conred = $empleado->conocido_conred;
            $this->nombre_conocido_conred = $empleado->nombre_conocido_conred;
            $this->cargo_conocido_conred = $empleado->cargo_conocido_conred;
            $this->telefono_padre = $empleado->telefono_padre;
            $this->nombre_padre = $empleado->nombre_padre;
            $this->ocupacion_padre = $empleado->ocupacion_padre;
            $this->telefono_madre = $empleado->telefono_madre;
            $this->nombre_madre = $empleado->nombre_madre;
            $this->ocupacion_madre = $empleado->ocupacion_madre;
            $this->telefono_conviviente = $empleado->telefono_conviviente;
            $this->nombre_conviviente = $empleado->nombre_conviviente;
            $this->ocupacion_conviviente = $empleado->ocupacion_conviviente;
            $this->hijos = HijoEmpleado::where('empleados_id', $empleado->id_empleado)
                ->get()
                ->toArray();
            $estudios = RegistroAcademicoEmpleado::where('empleados_id', $empleado->id_empleado)->get();
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
                    $this->titulo_otra_especialidad = $es->titulo;
                }
            }
            $this->estudia_actualmente = $empleado->estudia_actualmente;
            $this->estudio_actual = $empleado->estudio_actual;
            $this->horario_estudio_actual = $empleado->horario_estudio_actual;
            $this->establecimiento_estudio_actual = $empleado->establecimiento_estudio_actual;
            $this->etnia = $empleado->id_etnia;
            $this->otro_etnia = $empleado->otro_etnia;
            $this->idiomas = Idioma::where('empleados_id', $empleado->id_empleado)->get()->toArray();
            $this->programas = ProgramaComputacion::where('empleados_id', $empleado->id_empleado)->get()->toArray();
            $this->historiales_laborales = HistorialLaboral::where('empleados_id', $empleado->id_empleado)->get()->toArray();
            $this->referencias_personales = ReferenciaPersonal::where('empleados_id', $empleado->id_empleado)->get()->toArray();
            $this->referencias_laborales = ReferenciaLaboral::where('empleados_id', $empleado->id_empleado)->get()->toArray();
            $this->tipo_vivienda = $empleado->id_tipo_vivienda;
            $this->pago_vivienda = $empleado->pago_vivienda;
            $this->cantidad_personas_dependientes = $empleado->cantidad_personas_dependientes;
            $this->personas_dependientes = PersonaDependiente::where('empleados_id', $empleado->id_empleado)->get()->toArray();
            $this->ingresos_adicionales = $empleado->ingresos_adicionales;
            $this->fuente_ingresos_adicionales = $empleado->fuente_ingresos_adicionales;
            $this->personas_aportan_ingresos = $empleado->personas_aportan_ingresos;
            $this->monto_ingreso_total = $empleado->monto_ingreso_total;
            $this->posee_deudas = $empleado->posee_deudas;
            $this->tipo_deuda = $empleado->id_tipo_deuda;
            $this->monto_deuda = $empleado->monto_deuda;
            $this->trabajo_conred = $empleado->trabajo_conred;
            $this->trabajo_estado = $empleado->trabajo_estado;
            $this->jubilado_estado = $empleado->jubilado_estado;
            $this->institucion_jubilacion = $empleado->institucion_jubilacion;
            $this->padecimiento_salud = $empleado->padecimiento_salud;
            $this->tipo_enfermedad = $empleado->tipo_enfermedad;
            $this->intervencion_quirurgica = $empleado->intervencion_quirurgica;
            $this->tipo_intervencion = $empleado->tipo_intervencion;
            $this->sufrido_accidente = $empleado->sufrido_accidente;
            $this->tipo_accidente = $empleado->tipo_accidente;
            $this->alergia_medicamento = $empleado->alergia_medicamento;
            $this->tipo_medicamento = $empleado->tipo_medicamento;
            $this->tipo_sangre = $empleado->id_tipo_sangre;
            $this->nombre_contacto_emergencia = $empleado->nombre_contacto_emergencia;
            $this->telefono_contacto_emergencia = $empleado->telefono_contacto_emergencia;
            $this->direccion_contacto_emergencia = $empleado->direccion_contacto_emergencia;
        }
        $this->modal = true;
    }

    public function guardarContrato()
    {
        $validated = $this->validate([
            'tipo_contratacion' => 'required|integer|min:1',
            'tipo_servicio' => 'required|integer|min:1',
            'secretaria' => 'required|integer|min:1',
            'subsecretaria' => 'nullable|integer|min:1',
            'direccion' => 'nullable|integer|min:1',
            'subdireccion' => 'nullable|integer|min:1',
            'departamento' => 'nullable|integer|min:1',
            'delegacion' => 'nullable|integer|min:1',
            'puesto_nominal' => 'required|integer|min:1',
            'fecha_inicio' => 'required|date|after_or_equal:1996-11-11',
            'fecha_fin' => 'required|date|after:fecha_inicio',
            'salario' => 'required|decimal:2',
            'fianza' => 'nullable',
            'aprobacion_correlativo' => ['required', 'filled', 'string', 'regex:/^(00\d|[0-9]{3})$/'],
            'aprobacion_renglon' => 'required|filled',
            'aprobacion_year' => ['required', 'regex:/^(19[9][6-9]|[2-9][0-9]{3})$/'],
            'nit_autorizacion' => 'required|filled',
            'contrato_correlativo' => 'required|integer|min:1|regex:/^[1-9]\d*$/',
            'contrato_renglon' => 'required|filled',
            'contrato_year' => ['required', 'regex:/^(19[9][6-9]|[2-9][0-9]{3})$/'],
            'region' => 'required|integer|min:1',
            'dependencia_funcional' => 'required|integer|min:1',
            'puesto_funcional' => 'nullable|integer|min:1',
            'observacion' => 'nullable|regex:/^[A-Za-záàéèíìóòúùÁÀÉÈÍÌÓÒÚÙüÜñÑ\s.,;:-]+$/'
        ]);
        try {
            $this->numero_contrato = $validated['contrato_correlativo'] . '-' . $validated['contrato_renglon'] . '-' . $validated['contrato_year'];
            $this->acuerdo_aprobacion = $validated['aprobacion_correlativo'] . '-' . $validated['aprobacion_renglon'] . '-' . $validated['aprobacion_year'];

            $bonos_mes = BonoPuesto::select(
                'bonos_puestos.cantidad as cantidad',
                'bonificaciones.tipos_bonificaciones_id as tipos_bonificaciones_id'
            )
                ->join('bonificaciones', 'bonos_puestos.bonificaciones_id', '=', 'bonificaciones.id')
                ->where('bonos_puestos.puestos_nominales_id', $this->puesto_nominal)
                ->where('bonificaciones.tipos_bonificaciones_id', 1)
                ->get();

            $bonos_year = BonoPuesto::select(
                'bonificaciones.bono as bono',
                'bonos_puestos.cantidad as cantidad',
                'bonificaciones.tipos_bonificaciones_id as tipos_bonificaciones_id'
            )
                ->join('bonificaciones', 'bonos_puestos.bonificaciones_id', '=', 'bonificaciones.id')
                ->where('bonos_puestos.puestos_nominales_id', $this->puesto_nominal)
                ->where('bonificaciones.tipos_bonificaciones_id', 2)
                ->get();

            $monto_bonos = number_format(floatval($bonos_mes->sum('cantidad')), 2, '.', '');

            DB::transaction(function () use ($validated, $monto_bonos, $bonos_year) {

                if (!empty($monto_bonos)) {
                    $salario_total = $validated['salario'] + $monto_bonos;
                } else {
                    $salario_total = $validated['salario'];
                }

                $contrato = Contrato::create([
                    'numero' => $this->numero_contrato,
                    'salario' => $validated['salario'],
                    'acuerdo_aprobacion' => $this->acuerdo_aprobacion,
                    'nit_autorizacion' => $validated['nit_autorizacion'],
                    'fianza' => $validated['fianza'],
                    'vigente' => 1,
                    'tipos_contrataciones_id' => $validated['tipo_contratacion'],
                    'puestos_nominales_id' => $validated['puesto_nominal'],
                    'empleados_id' => $this->id_empleado
                ]);

                $periodo_contrato = PeriodoContrato::create([
                    'fecha_inicio' => $validated['fecha_inicio'],
                    'fecha_fin' => $validated['fecha_fin'],
                    'contratos_id' => $contrato->id
                ]);

                $fecha_inicio = Carbon::parse($validated['fecha_inicio']);
                $fecha_fin = Carbon::parse($validated['fecha_fin']);

                $dias_mes = $this->getDiasMesByFechas($fecha_inicio, $fecha_fin);

                foreach ($dias_mes as $mes => $dias) {
                    $month = Carbon::createFromFormat('d-m-Y', '01-' . $mes);
                    $salario = round($dias * ($salario_total / $month->daysInMonth), 2, PHP_ROUND_HALF_UP);

                    PagoContrato::create([
                        'salario' => $salario,
                        'mes' => $mes,
                        'primer_pago' => ($mes === key($dias_mes)) ? 1 : 0,
                        'periodos_contratos_id' => $periodo_contrato->id
                    ]);
                }

                $ultimo_mes_year = $fecha_inicio->copy()->endOfYear()->month;
                $current_year = $fecha_inicio->copy()->year;
                $dias_laborados = $fecha_fin->diffInDays($fecha_inicio) + 1;
                $dias_year = $fecha_inicio->copy()->daysInYear;

                if (!empty($bonos_year)) {
                    foreach ($bonos_year as $bono_year) {
                        if ($bono_year->bono == 'Aguinaldo') {
                            $cantidad = round($dias_laborados * ($bono_year->cantidad / $dias_year), 2, PHP_ROUND_HALF_UP);
                            if ($fecha_fin->copy()->month == ($ultimo_mes_year || $ultimo_mes_year - 1)) {
                                BonoAnualContrato::create([
                                    'bono' => $bono_year->bono,
                                    'cantidad' => $cantidad,
                                    'mes' => ($ultimo_mes_year == 12) ? $fecha_fin->copy()->format('m-Y') : $fecha_fin->copy()->addMonth()->format('m-Y'),
                                    'periodos_contratos_id' => $periodo_contrato->id
                                ]);
                            } else {
                                BonoAnualContrato::create([
                                    'bono' => $bono_year->bono,
                                    'cantidad' => $cantidad,
                                    'mes' => $fecha_fin->copy()->month,
                                    'periodos_contratos_id' => $periodo_contrato->id
                                ]);
                            }
                        } elseif ($bono_year->bono == 'Bono 14') {
                            $cantidad_mes = $bono_year->cantidad / 12;
                            $bono14_parte1 = null;
                            $bono14_parte2 = null;
                            foreach ($dias_mes as $mes => $dias) {
                                $month = Carbon::createFromFormat('d-m-Y', '01-' . $mes);
                                if ($mes <= '06' . $current_year) {
                                    $bono14_parte1 += $dias * $cantidad_mes / $month->daysInMonth;
                                } else {
                                    $bono14_parte2 += $dias * $cantidad_mes / $month->daysInMonth;
                                }
                            }
                            if ($fecha_fin->copy()->month > 6 && !empty($bono14_parte1) && !empty($bono14_parte2)) {
                                BonoAnualContrato::create([
                                    'bono' => $bono_year->bono . ' primera parte',
                                    'cantidad' => round($bono14_parte1, 2, PHP_ROUND_HALF_UP),
                                    'mes' => '07-' . $current_year,
                                    'periodos_contratos_id' => $periodo_contrato->id
                                ]);
                                BonoAnualContrato::create([
                                    'bono' => $bono_year->bono . ' segunda parte',
                                    'cantidad' => round($bono14_parte2, 2, PHP_ROUND_HALF_UP),
                                    'mes' => ($fecha_fin->copy()->month == 12) ? $fecha_fin->copy()->format('m-Y') : $fecha_fin->copy()->addMonth()->format('m-Y'),
                                    'periodos_contratos_id' => $periodo_contrato->id
                                ]);
                            } elseif ($fecha_fin->copy()->month == 6 && empty($bono14_parte1)) {
                                BonoAnualContrato::create([
                                    'bono' => $bono_year->bono . ' primera parte',
                                    'cantidad' => round($bono14_parte1, 2, PHP_ROUND_HALF_UP),
                                    'mes' => '07-' . $current_year,
                                    'periodos_contratos_id' => $periodo_contrato->id
                                ]);
                            } elseif ($fecha_fin->copy()->month < 6 && empty($bono14_parte1)) {
                                BonoAnualContrato::create([
                                    'bono' => $bono_year->bono . ' primera parte',
                                    'cantidad' => round($bono14_parte1, 2, PHP_ROUND_HALF_UP),
                                    'mes' => $fecha_fin->copy()->addMonth()->format('m-Y'),
                                    'periodos_contratos_id' => $periodo_contrato->id
                                ]);
                            }
                        } elseif ($bono_year->bono == 'Bono vacacional') {
                            $cantidad = round($dias_laborados * ($bono_year->cantidad / $dias_year), 2, PHP_ROUND_HALF_UP);
                            BonoAnualContrato::create([
                                'bono' => $bono_year->bono,
                                'cantidad' => $cantidad,
                                'mes' => ($fecha_fin->copy()->month == $ultimo_mes_year) ? $fecha_fin->copy()->format('m-Y') : $fecha_fin->copy()->addMonth()->format('m-Y'),
                                'periodos_contratos_id' => $periodo_contrato->id
                            ]);
                        }
                    }
                }

                if ($validated['contrato_renglon'] != '029') {
                    $dias_periodo = $fecha_fin->diffInDays($fecha_inicio) + 1;
                    $days_year = $fecha_inicio->copy()->daysInYear;
                    $dias_vacaciones = round($dias_periodo * (20 / $days_year), 0, PHP_ROUND_HALF_UP);
                    if ($dias_vacaciones > 0) {
                        VacacionDisponible::create([
                            'year' => $fecha_inicio->copy()->format('Y'),
                            'dias_disponibles' => $dias_vacaciones,
                            'empleados_id' => $this->id_empleado
                        ]);
                    }
                }

                $puesto_actual = PuestoNominal::findOrFail($validated['puesto_nominal']);
                $emp = Empleado::findOrFail($this->id_empleado);

                $dependencia_actual = DependenciaNominal::findOrFail($puesto_actual->dependencias_nominales_id);

                $puesto_superior = DependenciaNominal::select(
                    'contratos.empleados_id as id_empleado'
                )
                    ->join('puestos_nominales', 'dependencias_nominales.id', '=', 'puestos_nominales.dependencias_nominales_id')
                    ->join('contratos', 'puestos_nominales.id', '=', 'contratos.puestos_nominales_id')
                    ->join('catalogo_puestos', 'puestos_nominales.catalogo_puestos_id', '=', 'catalogo_puestos.id')
                    ->where('catalogo_puestos.jefe', 1)
                    ->where('contratos.vigente', 1)
                    ->where('puestos_nominales.activo', 0)
                    ->where('puestos_nominales.dependencias_nominales_id', $dependencia_actual->nodo_padre)
                    ->first();

                $emp->estado = 1;
                $emp->fecha_ingreso = $validated['fecha_inicio'];

                if ($puesto_superior == null) {
                    $emp->jefe_id = null;
                } else {
                    $emp->jefe_id = $puesto_superior->id_empleado;
                }
                $puesto_actual->activo = 0;
                $puesto_actual->save();
                $emp->save();

                RegistroPuesto::create([
                    'fecha_inicio' => $validated['fecha_inicio'],
                    'fecha_fin' => $validated['fecha_fin'],
                    'observacion' => $validated['observacion'],
                    'contratos_id' => $contrato->id,
                    'primer_puesto_id' => $validated['puesto_nominal'],
                    'puestos_funcionales_id' => $validated['puesto_funcional'],
                    'dependencias_funcionales_id' => $validated['dependencia_funcional'],
                    'regiones_id' => $validated['region']
                ]);
            });
            $empleado = Empleado::findOrFail($this->id_empleado);
            $puesto = PuestoNominal::select(
                'puestos_nominales.codigo as codigo',
                'catalogo_puestos.puesto as puesto'
            )
                ->join('catalogo_puestos', 'puestos_nominales.catalogo_puestos_id', 'catalogo_puestos.id')
                ->where('puestos_nominales.id', $this->puesto_nominal)
                ->first();

            activity()
                ->causedBy(auth()->user())
                ->withProperties(['user_id' => auth()->id()])
                ->log("El usuario " . auth()->user()->name .  " creó el contrato número: " . $this->numero_contrato . " para el empleado: " . $empleado->nombres . " " . $empleado->apellidos);

            activity()
                ->causedBy(auth()->user())
                ->withProperties(['user_id' => auth()->id()])
                ->log("El usuario " . auth()->user()->name .  " guardó el puesto: " . $puesto->codigo . '-' . $puesto->puesto . " para el empleado: " . $empleado->nombres . " " . $empleado->apellidos);
            session()->flash('message');
            $this->cerrarModalCrearContrato();
            return redirect()->route('empleados');
        } catch (Exception $e) {
            $errorMessages = "Ocurrió un error: " . $e->getMessage();
            session()->flash('error', $errorMessages);
            $this->cerrarModalCrearContrato();
            return redirect()->route('empleados');
        }
    }

    public function getSubsecretariasBySecretaria()
    {
        if (!empty($this->secretaria)) {
            $this->subsecretarias = DependenciaNominal::select('id', 'dependencia')->where('nodo_padre', $this->secretaria)->get();
            $this->getPuestosByDependencia($this->secretaria);
        } else {
            $this->subsecretarias = [];
            $this->puestos_nominales = [];
        }
        $this->subsecretaria = '';
        $this->direccion = '';
        $this->direcciones = [];
        $this->subdirecciones = [];
        $this->subdireccion = '';
        $this->departamentos = [];
        $this->departamento = '';
        $this->delegaciones = [];
        $this->delegacion = '';
    }

    public function getDireccionesBySubsecretaria()
    {
        if (!empty($this->subsecretaria)) {
            $this->direcciones = DependenciaNominal::select('id', 'dependencia')->where('nodo_padre', $this->subsecretaria)->get();
            $this->getPuestosByDependencia($this->subsecretaria);
        } else {
            $this->direcciones = [];
            $this->getPuestosByDependencia($this->secretaria);
        }
        $this->direccion = '';
        $this->subdirecciones = [];
        $this->subdireccion = '';
        $this->departamentos = [];
        $this->departamento = '';
        $this->delegaciones = [];
        $this->delegacion = '';
    }

    public function getSubdireccionesByDireccion()
    {
        if (!empty($this->direccion)) {
            $this->subdirecciones = DependenciaNominal::select('id', 'dependencia')->where('nodo_padre', $this->direccion)->get();
            $this->getPuestosByDependencia($this->direccion);
        } else {
            $this->subdirecciones = [];
            $this->getPuestosByDependencia($this->subsecretaria);
        }
        $this->subdireccion = '';
        $this->departamentos = [];
        $this->departamento = '';
        $this->delegaciones = [];
        $this->delegacion = '';
    }

    public function getDepartamentosBySubdireccion()
    {
        if (!empty($this->subdireccion)) {
            $this->departamentos = DependenciaNominal::select('id', 'dependencia')->where('nodo_padre', $this->subdireccion)->get();
            $this->getPuestosByDependencia($this->subdireccion);
        } else {
            $this->departamentos = [];
            $this->getPuestosByDependencia($this->direccion);
        }
        $this->departamento = '';
        $this->delegaciones = [];
        $this->delegacion = '';
    }

    public function getDelegacionesByDepartamento()
    {
        if (!empty($this->departamento)) {
            $this->delegaciones = DependenciaNominal::select('id', 'dependencia')->where('nodo_padre', $this->departamento)->get();
            $this->getPuestosByDependencia($this->departamento);
        } else {
            $this->delegaciones = [];
            $this->getPuestosByDependencia($this->subdireccion);
        }
    }

    public function getDiasMesByFechas($fi, $ff)
    {
        $fecha_inicio = Carbon::parse($fi);
        $fecha_fin = Carbon::parse($ff);

        $result = [];

        while ($fecha_inicio->lessThanOrEqualTo($fecha_fin)) {
            $ultimo_dia_mes = $fecha_inicio->copy()->endOfMonth();

            $dias_mes = $fecha_inicio->diffInDays($ultimo_dia_mes) + 1;

            if ($ultimo_dia_mes->greaterThanOrEqualTo($fecha_fin)) {
                $dias_mes = $fecha_inicio->diffInDays($fecha_fin) + 1;
            }

            $result[$fecha_inicio->copy()->format('m-Y')] = $dias_mes;

            $fecha_inicio->addMonth()->startOfMonth();
        }

        return $result;
    }

    public function crearContrato($id_empleado)
    {
        $this->id_empleado = $id_empleado;
        $this->modal_crear_contrato = true;
    }

    public function cerrarModalCrearContrato()
    {
        $this->puesto_nominal = '';
        $this->puesto_funcional = '';
        $this->dependencia_nominal = '';
        $this->dependencia_funcional = '';
        $this->region = '';
        $this->fecha_inicio = '';
        $this->fecha_fin = '';
        $this->observacion = '';
        $this->salario = '';
        $this->tipo_servicio = '';
        $this->tipo_contratacion = '';
        $this->contrato_correlativo = '';
        $this->contrato_renglon = '';
        $this->contrato_year = '';
        $this->numero_contrato = '';
        $this->secretaria = '';
        $this->subsecretaria = '';
        $this->subsecretarias = [];
        $this->direccion = '';
        $this->direcciones = [];
        $this->subdireccion = '';
        $this->subdirecciones = [];
        $this->departamento = '';
        $this->departamentos = [];
        $this->delegacion = '';
        $this->delegaciones = [];
        $this->modal_crear_contrato = false;
    }

    public function getPuestosByDependencia($id_dependencia)
    {
        $this->puesto_nominal = '';
        if ($id_dependencia) {
            $this->puestos_nominales = DB::table('puestos_nominales')
                ->join('catalogo_puestos', 'puestos_nominales.catalogo_puestos_id', '=', 'catalogo_puestos.id')
                ->select(
                    'puestos_nominales.id as id',
                    'puestos_nominales.codigo as codigo',
                    'catalogo_puestos.puesto as puesto'
                )
                ->where('puestos_nominales.dependencias_nominales_id', '=', $id_dependencia)
                ->where('puestos_nominales.activo', '=', 1)
                ->where('puestos_nominales.eliminado', '=', 0)
                ->where('puestos_nominales.tipos_servicios_id', '=', $this->tipo_servicio)
                ->whereExists(function ($query) {
                    $query->select(DB::raw(1))
                        ->from('requisitos_puestos')
                        ->whereRaw('requisitos_puestos.puestos_nominales_id = puestos_nominales.id');
                })
                ->whereExists(function ($query) {
                    $query->select(DB::raw(1))
                    ->from('perfiles')
                    ->whereRaw('perfiles.puestos_nominales_id = puestos_nominales.id');
                })
                ->get();
        } else {
            $this->puestos_nominales = [];
        }
    }

    public function getSalarioByPuesto()
    {
        $this->salario = 0;
        if ($this->puesto_nominal) {
            $salario = PuestoNominal::select(
                'puestos_nominales.salario as salario',
                'renglones.renglon as renglon'
            )
                ->join('renglones', 'puestos_nominales.renglones_id', '=', 'renglones.id')
                ->where('puestos_nominales.id', $this->puesto_nominal)
                ->first();
            $this->salario = $salario->salario;
            $this->contrato_renglon = $salario->renglon;
            $this->aprobacion_renglon = $salario->renglon;
        } else {
            $this->salario = '';
        }
    }

    public function getPuestosByTipoServicio()
    {
        $this->puesto_nominal = '';
        $this->puestos_nominales = '';
        $id_dependencia = '';
        if ($this->tipo_servicio) {
            if (!empty($this->delegacion)) {
                $id_dependencia = $this->delegacion;
            } elseif (!empty($this->departamento)) {
                $id_dependencia = $this->departamento;
            } elseif (!empty($this->subdireccion)) {
                $id_dependencia = $this->subdireccion;
            } elseif (!empty($this->direccion)) {
                $id_dependencia = $this->direccion;
            } elseif (!empty($this->subsecretaria)) {
                $id_dependencia = $this->subsecretaria;
            } else {
                $id_dependencia = $this->secretaria;
            }
            $this->puestos_nominales = DB::table('puestos_nominales')
                ->join('catalogo_puestos', 'puestos_nominales.catalogo_puestos_id', '=', 'catalogo_puestos.id')
                ->select(
                    'puestos_nominales.id as id',
                    'puestos_nominales.codigo as codigo',
                    'catalogo_puestos.puesto as puesto'
                )
                ->where('puestos_nominales.dependencias_nominales_id', $id_dependencia)
                ->where('puestos_nominales.activo', '=', 1)
                ->where('puestos_nominales.eliminado', '=', 0)
                ->where('puestos_nominales.tipos_servicios_id', '=', $this->tipo_servicio)
                ->whereExists(function ($query) {
                    $query->select(DB::raw(1))
                        ->from('requisitos_puestos')
                        ->whereRaw('requisitos_puestos.puestos_nominales_id = puestos_nominales.id');
                })
                ->whereExists(function ($query) {
                    $query->select(DB::raw(1))
                    ->from('perfiles')
                    ->whereRaw('perfiles.puestos_nominales_id = puestos_nominales.id');
                })
                ->get();
        } else {
            $this->puestos_nominales = [];
        }
    }

    public function getYearByFechaInicio()
    {
        if ($this->fecha_inicio) {
            $this->contrato_year = date('Y', strtotime($this->fecha_inicio));
            $this->aprobacion_year = date('Y', strtotime($this->fecha_inicio));
        } else {
            $this->contrato_year = '';
            $this->aprobacion_year = '';
        }
    }

    public function getMunicipiosByDepartamento()
    {
        $this->municipio = '';
        if ($this->departamento_origen) {
            $this->municipios = DB::table('municipios')
                ->select('id', 'nombre', 'departamentos_id')
                ->where('departamentos_id', '=', $this->departamento_origen)
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

    public function crear()
    {
        $this->modal = true;
    }

    public function updatedBusqueda()
    {
        $this->filtro = $this->busqueda;
    }

    public function limpiarModal()
    {
        $this->imagen = '';
        $this->imagen_actual = '';
        $this->codigo = '';
        $this->nombres = '';
        $this->apellidos = '';
        $this->pretension_salarial = '';
        $this->departamento = '';
        $this->municipio = '';
        $this->relacion_laboral = '';
        $this->genero = '';
        $this->fecha_nacimiento = '';
        $this->cuenta_banco = '';
        $this->nacionalidad = '';
        $this->estado_civil = '';
        $this->direccion = '';
        $this->estado_familiar = '';
        $this->departamento_residencia = '';
        $this->municipio_residencia = '';
        $this->dpi = '';
        $this->departamento_emision = '';
        $this->municipio_emision = '';
        $this->igss = '';
        $this->nit = '';
        $this->licencia = '';
        $this->tipo_licencia = '';
        $this->tipo_vehiculo = '';
        $this->placa = '';
        $this->telefono_casa = '';
        $this->telefono_movil = '';
        $this->email = '';
        $this->familiar_conred = '';
        $this->nombre_familiar_conred = '';
        $this->cargo_familiar_conred = '';
        $this->conocido_conred = '';
        $this->nombre_conocido_conred = '';
        $this->cargo_conocido_conred = '';
        $this->telefono_padre = '';
        $this->nombre_padre = '';
        $this->ocupacion_padre = '';
        $this->telefono_madre = '';
        $this->nombre_madre = '';
        $this->ocupacion_madre = '';
        $this->telefono_conviviente = '';
        $this->nombre_conviviente = '';
        $this->ocupacion_conviviente = '';
        $this->hijos = [];
        $this->establecimiento_primaria = '';
        $this->titulo_primaria = '';
        $this->establecimiento_secundaria = '';
        $this->titulo_secundaria = '';
        $this->establecimiento_diversificado = '';
        $this->titulo_diversificado = '';
        $this->establecimiento_universitario = '';
        $this->titulo_universitario = '';
        $this->establecimiento_maestria_postgrado = '';
        $this->titulo_maestria_postgrado = '';
        $this->establecimiento_otra_especialidad = '';
        $this->titulo_otra_especialidad = '';
        $this->estudia_actualmente = '';
        $this->estudio_actual = '';
        $this->horario_estudio_actual = '';
        $this->establecimiento_estudio_actual = '';
        $this->etnia = '';
        $this->otro_etnia = '';
        $this->idiomas = [];
        $this->programas = [];
        $this->historiales_laborales = [];
        $this->referencias_personales = [];
        $this->referencias_laborales = [];
        $this->tipo_vivienda = '';
        $this->pago_vivienda = '';
        $this->cantidad_personas_dependientes = '';
        $this->personas_dependientes = [];
        $this->ingresos_adicionales = '';
        $this->fuente_ingresos_adicionales = '';
        $this->personas_aportan_ingresos = '';
        $this->monto_ingreso_total = '';
        $this->posee_deudas = '';
        $this->tipo_deuda = '';
        $this->monto_deuda = '';
        $this->trabajo_conred = '';
        $this->trabajo_estado = '';
        $this->jubilado_estado = '';
        $this->institucion_jubilacion = '';
        $this->padecimiento_salud = '';
        $this->tipo_enfermedad = '';
        $this->intervencion_quirurgica = '';
        $this->tipo_intervencion = '';
        $this->sufrido_accidente = '';
        $this->tipo_accidente = '';
        $this->alergia_medicamento = '';
        $this->tipo_medicamento = '';
        $this->tipo_sangre = '';
        $this->nombre_contacto_emergencia = '';
        $this->telefono_contacto_emergencia = '';
        $this->direccion_contacto_emergencia = '';
    }

    public function cerrarModal()
    {
        $this->limpiarModal();
        $this->modal = false;
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
