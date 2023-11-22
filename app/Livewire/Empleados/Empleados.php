<?php

namespace App\Livewire\Empleados;

use App\Models\Departamento;
use App\Models\Empleado;
use App\Models\EstadoCivil;
use App\Models\Etnia;
use App\Models\Genero;
use App\Models\GrupoSanguineo;
use App\Models\Nacionalidad;
use App\Models\TipoDeuda;
use App\Models\TipoLicencia;
use App\Models\TipoVehiculo;
use App\Models\TipoVivienda;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class Empleados extends Component
{
    /* Colecciones */
    public $generos, $etnias, $grupos_sanguineos, $dependencias_nominales, $dependencias_funcionales, $departamentos,
        $municipios, $municipios_emision, $municipios_residencia, $nacionalidades, $tipos_viviendas, $estados_civiles, $tipos_licencias, $tipos_vehiculos,
        $tipos_deudas;

    /* Variables de formulario */
    public $empleado, $id_candidato, $id_empleado, $dpi, $nit, $cuenta_banco, $igss, $imagen, $nombres, $apellidos, $puesto, $email, $pretension_salarial, $departamento,
        $municipio, $fecha_nacimiento, $nacionalidad, $estado_civil, $direccion, $departamento_residencia, $municipio_residencia, $departamento_emision, $municipio_emision, $licencia,
        $tipo_licencia, $tipo_vehiculo, $placa, $telefono_casa, $telefono_movil, $familiar_conred, $nombre_familiar_conred, $genero,
        $cargo_familiar_conred, $conocido_conred, $nombre_conocido_conred, $cargo_conocido_conred, $telefono_padre, $nombre_padre,
        $ocupacion_padre, $telefono_madre, $nombre_madre, $ocupacion_madre, $telefono_conviviente, $nombre_conviviente, $ocupacion_conviviente,
        $establecimiento_primaria, $titulo_primaria, $establecimiento_secundaria, $titulo_secundaria, $establecimiento_diversificado,
        $titulo_diversificado, $establecimiento_universitario, $titulo_universitario, $establecimiento_maestria_postgrado,
        $titulo_maestria_postgrado, $establecimiento_otra_especialidad, $titulo_otra_especialidad, $estudia_actualmente, $estudio_actual,
        $horario_estudio_actual, $establecimiento_estudio_actual, $etnia, $otro_etnia, $tipo_vivienda, $pago_vivienda, $cantidad_personas_dependientes,
        $ingresos_adicionales, $fuente_ingresos_adicionales, $personas_aportan_ingresos, $monto_ingreso_total, $posee_deudas, $tipo_deuda,
        $monto_deuda, $trabajo_conred, $trabajo_estado, $jubilado_estado, $institucion_jubilacion, $padecimiento_salud, $tipo_enfermedad, $intervencion_quirurgica,
        $tipo_intervencion, $sufrido_accidente, $tipo_accidente, $alergia_medicamento, $tipo_medicamento, $tipo_sangre, $nombre_contacto_emergencia,
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

    /* Modal Crear  y Editar*/
    public $modal = false;
    public function render()
    {
        $this->departamentos = Departamento::select('id', 'nombre')->get();
        $this->nacionalidades = Nacionalidad::select('id', 'nacionalidad')->get();
        $this->estados_civiles = EstadoCivil::select('id', 'estado_civil')->get();
        $this->generos = Genero::select('id', 'genero')->get();
        $this->tipos_licencias = TipoLicencia::select('id', 'tipo_licencia')->get();
        $this->tipos_vehiculos = TipoVehiculo::select('id', 'tipo_vehiculo')->get();
        $this->etnias = Etnia::select('id', 'etnia')->get();
        $this->tipos_viviendas = TipoVivienda::select('id', 'tipo_vivienda')->get();
        $this->tipos_deudas = TipoDeuda::select('id', 'tipo_deuda')->get();
        $this->grupos_sanguineos = GrupoSanguineo::select('id', 'grupo')->get();
        activity()
            ->causedBy(auth()->user())
            ->withProperties(['user_id' => auth()->id()])
            ->log("El usuario " . auth()->user()->name .  " visitó la página: " . request()->path());
        return view('livewire.empleados.empleados');
    }

    public function guardar()
    {
        try {
            $img = '';
            if (empty($this->imagen_actual)) {
                $validated =  $this->validate([
                    'imagen' => 'image|required|mimes:jpg,jpeg,png|max:2048'
                ]);
            }
            $validated = $this->validate([
                'nombre' => 'required|filled|regex:/^[A-Za-záàéèíìóòúùÁÀÉÈÍÌÓÒÚÙüÜñÑ\s]+$/',
                'apellidos' => 'required|filled|regex:/^[A-Za-záàéèíìóòúùÁÀÉÈÍÌÓÒÚÙüÜñÑ\s]+$/',
                'pretension_salarial' => 'required|decimal:2',
                'departamento' => 'required|integer|min:1',
                'municipio' => 'required|integer|min:1',
                'fecha_nacimiento' => 'required|date|before_or_equal:' . \Carbon\Carbon::now()->subYears(18)->format('Y-m-d'),
                'nacionalidad' => 'required|integer|min:1',
                'genero' => 'required|integer|min:1',
                'estado_civil' => 'required|integer|min:1',
                'estado_familiar' => 'nullable',
                'direccion' => 'required|filled',
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
                'programas.*.valoracion' => ['required_with:programas.*.nombre', 'integer', 'min:1', 'max:5'],
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
            if ($this->imagen == $this->imagen_actual) {
                $img = $this->imagen;
            } else {
                $img = $this->imagen->store('candidatos', 'public');
                Storage::delete('public/' . $this->imagen_actual);
            }

            DB::transaction(function () use ($validated, $img) {
                $this->empleado = Empleado::updateOrCreate(['id' => $this->id_empleado], [
                    'nit' => $validated['nit'],
                    'igss' => $validated['igss'],
                    'imagen' => $img,
                    'nombres' => $validated['nombres'],
                    'apellidos' => $validated['apellidos'],
                    'email' => $validated['email'],
                    'fecha_nacimiento' => $validated['fecha_nacimiento'],
                    'cuenta_banco' => $validated['cuenta_banco'],
                    'estado_familiar' => $validated['estado_familiar'],
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
                ]);
            });

            session()->flash('message');
            $this->cerrarModal();
            activity()
                ->causedBy(auth()->user())
                ->withProperties(['user_id' => auth()->id()])
                ->log("El usuario " . auth()->user()->name . " guardó el empleado: " . $this->nombre);
            return redirect()->route('candidatos');
        } catch (Exception $e) {
            $errorMessages = "Ocurrió un error: " . $e->getMessage();
            session()->flash('error', $errorMessages);
            $this->cerrarModal();
            return redirect()->route('candidatos');
        }
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

    public function crear()
    {
        $this->modal = true;
    }

    public function limpiarModal()
    {
    }

    public function cerrarModal()
    {
        $this->modal = false;
    }
}
