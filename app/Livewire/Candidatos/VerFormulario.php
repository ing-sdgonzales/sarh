<?php

namespace App\Livewire\Candidatos;

use App\Http\Controllers\FormularioController;
use App\Models\AplicacionCandidato;
use App\Models\Candidato;
use App\Models\Empleado;
use App\Models\EtapaAplicacion;
use App\Models\HijoEmpleado;
use App\Models\HistorialLaboral;
use App\Models\Idioma;
use App\Models\PersonaDependiente;
use App\Models\ProgramaComputacion;
use App\Models\ReferenciaLaboral;
use App\Models\ReferenciaPersonal;
use App\Models\RegistroAcademicoEmpleado;
use App\Models\RequisitoCandidato;
use App\Models\RequisitoPuesto;
use App\Notifications\NotificacionPresentarExpediente;
use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Symfony\Component\CssSelector\Node\FunctionNode;

use function PHPSTORM_META\map;

class VerFormulario extends Component
{
    public $id_empleado, $id_requisito_candidato, $observacion;
    public $modal = false;
    public $departamentos, $municipios, $municipios_emision,
        $hijos = [['nombre' => '']],
        $idiomas = [['idioma' => '', 'habla' => '', 'lee' => '', 'escribe' => '']],
        $si_no = [['val' => 0, 'res' => 'No'], ['val' => 1, 'res' => 'Sí']],
        $programas = [['nombre' => '', 'valoracion' => '']],
        $personas_dependientes = [['nombre' => '', 'parentesco' => '']];
    public $valoracion = [
        ['val' => 1, 'res' => 'Nada'],
        ['val' => 2, 'res' => 'Regular'], ['val' => 3, 'res' => 'Bueno'],
        ['val' => 4, 'res' => 'Excelente']
    ];
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

    public function render()
    {
        activity()
            ->causedBy(auth()->user())
            ->withProperties(['user_id' => auth()->id()])
            ->log("El usuario " . auth()->user()->name .  " visitó la página: " . request()->path());
        return view('livewire.candidatos.ver-formulario');
    }

    public function mount($id_candidato, $id_requisito)
    {
        $this->id_candidato = $id_candidato;
        $this->id_requisito = $id_requisito;
        $this->cargarPuesto($id_candidato);

        $this->id_requisito_candidato =  DB::table('requisitos_candidatos')
            ->select(
                'id'
            )
            ->where('candidatos_id', '=', $id_candidato)
            ->where('requisitos_id', '=', $id_requisito)
            ->where('puestos_nominales_id', '=', $this->id_puesto)
            ->first();
        $this->id_requisito_candidato = $this->id_requisito_candidato->id;

        /* consulta para los campos del candidato (tabla empleado) */
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
            'mun_residencia.id as id_municipio_residencia',
            'mun_residencia.nombre as municipio_residencia',
            'dep_residencia.id as id_departamento_residencia',
            'dep_residencia.nombre as departamento_residencia',
            'municipios.id as id_municipio',
            'municipios.nombre as municipio',
            'departamentos.id as id_departamento',
            'departamentos.nombre as departamento',
            'nacionalidades.id as id_nacionalidad',
            'nacionalidades.nacionalidad as nacionalidad',
            'estados_civiles.id as id_estado_civil',
            'estados_civiles.estado_civil as estado_civil',
            'dpis.dpi as dpi',
            'mun_emision.nombre as municipio_emision',
            'dep_emision.nombre as departamento_emision',
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
            'grupos_sanguineos.id as id_grupo_sanguineo',
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
            ->first();

        $this->id_empleado = $candidato->id_empleado;
        $this->imagen = $candidato->imagen;
        $this->nombres = $candidato->nombres;
        $this->apellidos = $candidato->apellidos;
        $this->pretension_salarial = 'Q ' . number_format($candidato->pretension_salarial, 2, '.', ',');
        $this->departamento = $candidato->departamento;
        $this->municipio = $candidato->municipio;
        $this->fecha_nacimiento = $candidato->fecha_nacimiento;
        $this->nacionalidad = $candidato->nacionalidad;
        $this->estado_civil = $candidato->estado_civil;
        $this->direccion = $candidato->direccion . ', ' . $candidato->municipio_residencia . ', ' . $candidato->departamento_residencia;
        $this->dpi = $candidato->dpi;
        $this->departamento_emision = $candidato->departamento_emision;
        $this->municipio_emision = $candidato->municipio_emision;
        $this->igss = $candidato->igss;
        $this->nit = $candidato->nit;
        $this->licencia = $candidato->licencia;
        $this->tipo_licencia = $candidato->tipo_licencia;
        $this->tipo_vehiculo = $candidato->tipo_vehiculo;
        $this->placa = $candidato->placa;
        $this->telefono_casa = $candidato->telefono_casa;
        $this->telefono_movil = $candidato->telefono;
        $this->email = $candidato->email;
        $this->familiar_conred = $this->si_no[$candidato->familiar_conred]['res'];
        $this->nombre_familiar_conred = $candidato->nombre_familiar_conred;
        $this->cargo_familiar_conred = $candidato->cargo_familiar_conred;
        $this->conocido_conred = $this->si_no[$candidato->conocido_conred]['res'];
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
        $this->estudia_actualmente = $this->si_no[$candidato->estudia_actualmente]['res'];
        $this->estudio_actual = $candidato->estudio_actual;
        $this->horario_estudio_actual = $candidato->horario_estudio_actual;
        $this->establecimiento_estudio_actual = $candidato->establecimiento_estudio_actual;
        $this->etnia = $candidato->etnia;
        $this->otro_etnia = $candidato->otro_etnia;
        $this->idiomas = Idioma::where('empleados_id', $candidato->id_empleado)->get()->toArray();
        $this->programas = ProgramaComputacion::where('empleados_id', $candidato->id_empleado)->get()->toArray();
        foreach ($this->programas as &$programa) {
            $programa['valoracion'] = $this->valoracion[$programa['valoracion'] - 1]['res'];
        }
        $this->historiales_laborales = HistorialLaboral::where('empleados_id', $candidato->id_empleado)->get()->toArray();
        foreach ($this->historiales_laborales as &$historial) {
            $historial['verificar_informacion'] = $this->si_no[$historial['verificar_informacion']]['res'];
            $historial['ultimo_sueldo'] = 'Q ' . number_format($historial['ultimo_sueldo'], 2, '.', ',');
        }
        $this->referencias_personales = ReferenciaPersonal::where('empleados_id', $candidato->id_empleado)->get()->toArray();
        $this->referencias_laborales = ReferenciaLaboral::where('empleados_id', $candidato->id_empleado)->get()->toArray();
        $this->tipo_vivienda = $candidato->tipo_vivienda;
        $this->pago_vivienda = 'Q ' . number_format($candidato->pago_vivienda, 2, '.', ',');
        $this->cantidad_personas_dependientes = $candidato->cantidad_personas_dependientes;
        $this->personas_dependientes = PersonaDependiente::where('empleados_id', $candidato->id_empleado)->get()->toArray();
        $this->ingresos_adicionales = $this->si_no[$candidato->ingresos_adicionales]['res'];
        $this->fuente_ingresos_adicionales = $candidato->fuente_ingresos_adicionales;
        $this->personas_aportan_ingresos = $candidato->personas_aportan_ingresos;
        $this->monto_ingreso_total = $candidato->monto_ingreso_total;
        $this->posee_deudas = $this->si_no[$candidato->posee_deudas]['res'];
        $this->tipo_deuda = $candidato->tipo_deuda;
        if ($candidato->monto_deuda > 0) {
            $this->monto_deuda = 'Q ' . number_format($candidato->monto_deuda, 2, '.', ',');
        } else {
            $this->monto_deuda = number_format($candidato->monto_deuda, 2, '.', ',');
        }
        $this->trabajo_conred = $this->si_no[$candidato->trabajo_conred]['res'];
        $this->trabajo_estado = $this->si_no[$candidato->trabajo_estado]['res'];
        $this->jubilado_estado = $this->si_no[$candidato->jubilado_estado]['res'];
        $this->institucion_jubilacion = $candidato->institucion_jubilacion;
        $this->padecimiento_salud = $this->si_no[$candidato->padecimiento_salud]['res'];
        $this->tipo_enfermedad = $candidato->tipo_enfermedad;
        $this->intervencion_quirurgica = $this->si_no[$candidato->intervencion_quirurgica]['res'];
        $this->tipo_intervencion = $candidato->tipo_intervencion;
        $this->sufrido_accidente = $this->si_no[$candidato->sufrido_accidente]['res'];
        $this->tipo_accidente = $candidato->tipo_accidente;
        $this->alergia_medicamento = $this->si_no[$candidato->alergia_medicamento]['res'];
        $this->tipo_medicamento = $candidato->tipo_medicamento;
        $this->tipo_sangre = $candidato->tipo_sangre;
        $this->nombre_contacto_emergencia = $candidato->nombre_contacto_emergencia;
        $this->telefono_contacto_emergencia = $candidato->telefono_contacto_emergencia;
        $this->direccion_contacto_emergencia = $candidato->direccion_contacto_emergencia;
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

    public function aprobar()
    {

        try {
            DB::transaction(function () {

                $reqs_puesto = RequisitoPuesto::select('requisitos_id')->where('puestos_nominales_id', $this->puesto)
                    ->orderBy('requisitos_id', 'asc')->pluck('requisitos_id')->toArray();

                $requisito = RequisitoCandidato::findOrFail($this->id_requisito_candidato);
                $requisito->valido = 1;
                $requisito->revisado = 1;
                $requisito->fecha_revision = date("Y-m-d H:i:s");
                $requisito->save();

                $requisito = RequisitoCandidato::findOrFail($this->id_requisito_candidato);
                $documento = new FormularioController;
                $ubicacion = $documento->generarDoc($this->id_empleado, auth()->user()->name);
                $requisito->ubicacion = $ubicacion;
                $requisito->save();

                $reqs_candidato = RequisitoCandidato::select('requisitos_id')->where('candidatos_id', $this->id_candidato)
                    ->where('fecha_revision', '!=', null)
                    ->where('revisado', 1)
                    ->where('valido', 1)
                    ->orderBy('requisitos_id', 'asc')
                    ->pluck('requisitos_id')
                    ->toArray();

                $dif_reqs = array_diff($reqs_puesto, $reqs_candidato);
                if (count($dif_reqs) == 0) {
                    $aplicacion = AplicacionCandidato::select('id')->where('candidatos_id', $this->id_candidato)
                        ->where('puestos_nominales_id', $this->id_puesto)
                        ->first();
                    $id_aplicacion = $aplicacion->id;
                    EtapaAplicacion::where('etapas_procesos_id', 2)
                        ->where('aplicaciones_candidatos_id', $id_aplicacion)
                        ->update([
                            'fecha_fin' => date('Y-m-d H:i:s')
                        ]);

                    EtapaAplicacion::create([
                        'fecha_inicio' => date('Y-m-d H:i:s'),
                        'etapas_procesos_id' => 3,
                        'aplicaciones_candidatos_id' => $id_aplicacion
                    ]);

                    $can = Candidato::findOrFail($this->id_candidato);
                    $can->notify(new NotificacionPresentarExpediente);
                }
            });
            $log = DB::table('requisitos_candidatos')
                ->join('candidatos', 'requisitos_candidatos.candidatos_id', '=', 'candidatos.id')
                ->join('requisitos', 'requisitos_candidatos.requisitos_id', '=', 'requisitos.id')
                ->select(
                    'candidatos.nombre as nombre',
                    'requisitos.requisito as requisito',
                )
                ->where('requisitos_candidatos.candidatos_id', '=', $this->id_candidato)
                ->where('requisitos_candidatos.puestos_nominales_id', '=', $this->id_puesto)
                ->where('requisitos_candidatos.id', '=', $this->id_requisito_candidato)
                ->first();

            activity()
                ->causedBy(auth()->user())
                ->withProperties(['user_id' => auth()->id()])
                ->log("El usuario " . auth()->user()->name . " aprobó el requisito: " . $log->requisito . " del candidato " . $log->nombre);
            session()->flash('message');

            return redirect()->route('expedientes', ['candidato_id' => $this->id_candidato]);
        } catch (Exception $e) {
            $errorMessages = "Ocurrió un error: " . $e->getMessage();
            session()->flash('error', $errorMessages);
            return redirect()->route('expedientes', ['candidato_id' => $this->id_candidato]);
        }
    }

    public function rechazarFormulario()
    {
        try {
            $validated = $this->validate([
                'observacion' => 'required|filled|regex:/^[A-Za-záàéèíìóòúùÁÀÉÈÍÌÓÒÚÙüÜñÑ\s.,;:-]+$/'
            ]);

            $requisito = RequisitoCandidato::findOrFail($this->id_requisito_candidato);

            $requisito->observacion = $validated['observacion'];
            $requisito->revisado = 1;
            $requisito->valido = 0;
            $requisito->fecha_revision = date("Y-m-d H:i:s");

            $requisito->save();

            $log = DB::table('requisitos_candidatos')
                ->join('candidatos', 'requisitos_candidatos.candidatos_id', '=', 'candidatos.id')
                ->join('requisitos', 'requisitos_candidatos.requisitos_id', '=', 'requisitos.id')
                ->select(
                    'candidatos.nombre as nombre',
                    'requisitos.requisito as requisito',
                )
                ->where('requisitos_candidatos.candidatos_id', '=', $this->id_candidato)
                ->where('requisitos_candidatos.puestos_nominales_id', '=', $this->id_puesto)
                ->where('requisitos_candidatos.id', '=', $this->id_requisito_candidato)
                ->first();

            activity()
                ->causedBy(auth()->user())
                ->withProperties(['user_id' => auth()->id()])
                ->log("El usuario " . auth()->user()->name . " rechazó el requisito: " . $log->requisito . " del candidato " . $log->nombre);
            session()->flash('message');

            return redirect()->route('expedientes', ['candidato_id' => $this->id_candidato]);
        } catch (Exception $e) {
            $errorMessages = "Ocurrió un error: " . $e->getMessage();
            session()->flash('error', $errorMessages);
            return redirect()->route('expedientes', ['candidato_id' => $this->id_candidato]);
        }
    }

    public function abrirModal()
    {
        $requisito = RequisitoCandidato::findOrFail($this->id_requisito_candidato);
        $this->observacion = $requisito->observacion;
        $this->modal = true;
    }

    public function cerrarModal()
    {
        $this->modal = false;
    }
}
