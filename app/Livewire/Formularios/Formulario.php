<?php

namespace App\Livewire\Formularios;

use App\Http\Controllers\FormularioController;
use App\Models\Empleado;
use App\Models\RequisitoCandidato;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;

use Livewire\Component;

class Formulario extends Component
{
    use WithFileUploads;

    public $departamentos, $municipios, $municipios_emision,
        $hijos = [['nombre' => '']],
        $idiomas = [['idioma' => '', 'habla' => '', 'lee' => '', 'escribe' => '']],
        $si_no = [['val' => 0, 'res' => 'No'], ['val' => 1, 'res' => 'Sí']],
        $programas = [['nombre' => '', 'valoracion' => '']],
        $personas_dependientes = [['nombre' => '', 'parentesco' => '']];
    public $historiales_laborales = [
        [
            'empresa' => '',
            'direccion' => '',
            'telefono' => '',
            'jefe' => '',
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
    public $id_candidato, $id_requisito, $id_puesto, $dpi, $nit, $igss, $imagen, $nombres, $apellidos, $puesto, $email, $pretension_salarial, $departamento,
        $municipio, $fecha_nacimiento, $nacionalidad, $estado_civil, $direccion, $departamento_emision, $municipio_emision, $licencia,
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

    public $empleado, $imagen_actual;
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
        $validated = $this->validate([
            'imagen' => 'image|required|mimes:jpg,jpeg,png|max:2048',
            'nombres' => 'required|filled|regex:/^[A-Za-záàéèíìóòúùÁÀÉÈÍÌÓÒÚÙüÜñÑ\s]+$/',
            'apellidos' => 'required|filled|regex:/^[A-Za-záàéèíìóòúùÁÀÉÈÍÌÓÒÚÙüÜñÑ\s]+$/',
            'pretension_salarial' => 'required|decimal:2',
            'departamento' => 'required|integer|min:1',
            'municipio' => 'required|integer|min:1',
            'fecha_nacimiento' => 'required|date',
            'nacionalidad' => 'required|integer|min:1',
            'estado_civil' => 'required|integer|min:1',
            'direccion' => 'required|filled',
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
            'otro_etnia' => 'required_if:etnia,|nullable',
            'idiomas.*.nombre' => ['nullable', 'regex:/^[A-Za-záàéèíìóòúùÁÀÉÈÍÌÓÒÚÙüÜñÑ\s]+$/'],
            'idiomas.*.habla' => ['required_with:idiomas.*.idioma', 'nullable', 'integer', 'min:0', 'max:100'],
            'idiomas.*.lectura' => ['required_with:idiomas.*.idioma', 'nullable', 'integer', 'min:0', 'max:100'],
            'idiomas.*.escritura' => ['required_with:idiomas.*.idioma', 'nullable', 'integer', 'min:0', 'max:100'],
            'programas.*.nombre' => ['nullable', 'regex:/^[A-Za-záàéèíìóòúùÁÀÉÈÍÌÓÒÚÙüÜñÑ\s]+$/'],
            'programas.*.valoracion' => ['required_with:programas.*.nombre', 'integer', 'min:1', 'max:5'],
            'historiales_laborales.*.empresa' => ['nullable', 'regex:/^[A-Za-záàéèíìóòúùÁÀÉÈÍÌÓÒÚÙüÜñÑ\s.,;:-]+$/'],
            'historiales_laborales.*.direccion' => ['required_with:historiales_laborales.*.empresa'],
            'historiales_laborales.*.telefono' => ['required_with:historiales_laborales.*.empresa', 'regex:/^(2|3|4|5|7)\d{3}-\d{4}$/'],
            'historiales_laborales.*.jefe' => ['required_with:historiales_laborales.*.empresa', 'regex:/^[A-Za-záàéèíìóòúùÁÀÉÈÍÌÓÒÚÙüÜñÑ\s]+$/'],
            'historiales_laborales.*.cargo' => ['required_with:historiales_laborales.*.empresa', 'regex:/^[A-Za-záàéèíìóòúùÁÀÉÈÍÌÓÒÚÙüÜñÑ\s]+$/'],
            'historiales_laborales.*.desde' => ['required_with:historiales_laborales.*.empresa', 'date'],
            'historiales_laborales.*.hasta' => ['required_with:historiales_laborales.*.empresa', 'date', 'after:historiales_laborales.*.desde'],
            'historiales_laborales.*.ultimo_sueldo' => ['required_with:historiales_laborales.*.empresa', 'decimal:2'],
            'historiales_laborales.*.motivo_salida' => ['required_with:historiales_laborales.*.empresa', 'regex:/^[A-Za-záàéèíìóòúùÁÀÉÈÍÌÓÒÚÙüÜñÑ\s]+$/'],
            'historiales_laborales.*.verificar_informacion' => ['required_with:historiales_laborales.*.empresa', 'integer', 'min:0'],
            'historiales_laborales.*.razon_informacion' => ['required_with:historiales_laborales.*.verificar_informacion,0', 'regex:/^[A-Za-záàéèíìóòúùÁÀÉÈÍÌÓÒÚÙüÜñÑ\s]+$/'],
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
                $this->empleado = Empleado::create([
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
                    'estudio_actual' => $validated['estudio_actual'],
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
                    'etnias_id' => $validated['etnia'],
                    'grupos_sanguineos_id' => $validated['tipo_sangre'],
                    'municipios_id' => $validated['municipio'],
                    'nacionalidades_id' => $validated['nacionalidad'],
                    'tipos_viviendas_id' => $validated['tipo_vivienda'],
                    'estados_civiles_id' => $validated['estado_civil']
                ]);

                $requisito = RequisitoCandidato::where([
                    'candidatos_id' => $this->id_candidato,
                    'puestos_nominales_id' => $this->id_puesto,
                    'requisitos_id' => $this->id_requisito
                ])
                    ->join('requisitos', 'requisitos_candidatos.requisitos_id', '=', 'requisitos.id')
                    ->first();
                if ($requisito) {
                    $requisito->update([
                        'ubicacion' => '',
                        'observacion' => '',
                        'fecha_carga' => date("Y-m-d H:i:s"),
                        'valido' => 0,
                        'fecha_revision' => null
                    ]);
                    $requisito->revisado = 0;
                    $requisito->save();
                } else {
                    RequisitoCandidato::create([
                        'candidatos_id' => $this->id_candidato,
                        'puestos_nominales_id' => $this->id_puesto,
                        'requisitos_id' => $this->id_requisito,
                        'ubicacion' => ''
                    ]);
                }
                /* $documento = new FormularioController;
                $documento->generarDoc($this->empleado->id, $this->id_requisito, $this->id_candidato); */
            });
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
        $this->id_requisito = $id_requisito;
        $this->cargarPuesto($id_candidato);
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

    public function add_son()
    {
        $this->hijos[] = '';
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
        $this->idiomas[] = '';
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
        $this->programas[] = ['nombre' => '', 'valoracion' => ''];
    }

    public function remove_program($index)
    {
        unset($this->programas[$index]);
        $this->programas = array_values($this->programas);
    }
}
