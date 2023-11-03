<?php

namespace App\Livewire\Candidatos;

use App\Http\Controllers\FormularioController;
use App\Models\Empleado;
use App\Models\HijoEmpleado;
use App\Models\RequisitoCandidato;
use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Symfony\Component\CssSelector\Node\FunctionNode;

class VerFormulario extends Component
{
    public $id_empleado, $id_requisito_candidato;
    public $modal = false;
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
            'empleados.direccion as direccion',
            'empleados.pretension_salarial as pretension_salarial',
            'empleados.estudia_actualmente as estudia_actualmente',
            'empleados.estudio_actual as estudio_actual',
            'empleados.cantidad_personas_dependientes as cantidad_personas_dependientes',
            'empleados.ingresos_adicionales as ingresos_adicionales',
            'empleados.monto_ingreso_total as monto_ingreso_total',
            'empleados.posee_deudas as posee deudas',
            'empleados.trabajo_conred as trabajo_conred',
            'empleados.trabajo_estado as trabajo_estado',
            'empleados.jubilado_estado as jubilado_estado',
            'empleados.institucion_jubilacion as institucion_jubilacion',
            'empleados.personas_aportan_ingresos as personas_aportan_ingresos',
            'empleados.fuente_ingresos_adicionales as fuente_ingresos_adicionales',
            'empleados.pago_vivienda as pago_vivienda',
            'municipios.id as id_municipio',
            'municipios.nombre as municipio',
            'departamentos.id as id_departamento',
            'departamentos.nombre as departamento',
            'nacionalidades.id as id_nacionalidad',
            'nacionalidades.nacionalidad as nacionalidad',
            'estados_civiles.id as id_estado_civil',
            'estados_civiles.estado_civil as estado_civil',
            'dpis.dpi as dpi',
            'municipios.nombre as municipio_emision',
            'departamentos.nombre as departamento_emision'

        )
            ->join('municipios', 'empleados.municipios_id', '=', 'municipios.id')
            ->join('departamentos', 'municipios.departamentos_id', '=', 'departamentos.id')
            ->join('nacionalidades', 'empleados.nacionalidades_id', '=', 'nacionalidades.id')
            ->join('estados_civiles', 'empleados.estados_civiles_id', '=', 'estados_civiles.id')
            ->join('dpis', 'empleados.id', '=', 'dpis.empleados_id')
            ->join('municipios as mun_emision', 'dpis.municipios_id', '=', 'mun_emision.id')
            ->join('departamentos as dep_emision', 'municipios.departamentos_id', '=', 'dep_emision.id')
            ->first();
        $this->id_empleado = $candidato->id_empleado;
        $this->imagen = $candidato->imagen;
        $this->nombres = $candidato->nombres;
        $this->apellidos = $candidato->apellidos;
        $this->pretension_salarial = number_format($candidato->pretension_salarial, 2, '.', ',');
        $this->departamento = $candidato->departamento;
        $this->municipio = $candidato->municipio;
        $this->nacionalidad = $candidato->nacionalidad;
        $this->estado_civil = $candidato->estado_civil;
        $this->dpi = $candidato->dpi;
        $this->departamento_emision = $candidato->departamento_emision;
        $this->municipio_emision = $candidato->municipio_emision;
        $this->igss = $candidato->igss;
        $this->nit = $candidato->nit;


        
        $this->email = $candidato->email;
        $this->fecha_nacimiento = $candidato->fecha_nacimiento;
        $this->direccion = $candidato->direccion;

        $this->estudia_actualmente = $this->si_no[$candidato->estudia_actualmente]['res'];
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
                $documento = new FormularioController;
                $ubicacion = $documento->generarDoc($this->id_empleado);

                $requisito = RequisitoCandidato::findOrFail($this->id_requisito_candidato);

                $requisito->ubicacion = $ubicacion;
                $requisito->valido = 1;
                $requisito->revisado = 1;
                $requisito->fecha_revision = date("Y-m-d H:i:s");

                $requisito->save();
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
            $requisito = RequisitoCandidato::findOrFail($this->id_requisito_candidato);

            $requisito->observacion = $this->observacion;
            $requisito->valido = 0;
            $requisito->fecha_revision = date("Y-m-d H:i:s");

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
        $this->modal = true;
    }

    public function cerrarModal()
    {
        $this->modal = false;
    }
}
