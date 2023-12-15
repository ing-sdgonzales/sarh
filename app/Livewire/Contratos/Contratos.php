<?php

namespace App\Livewire\Contratos;

use App\Models\Contrato;
use App\Models\DependenciaFuncional;
use App\Models\DependenciaNominal;
use App\Models\Empleado;
use App\Models\PuestoFuncional;
use App\Models\PuestoNominal;
use App\Models\Region;
use App\Models\RegistroPuesto;
use App\Models\TipoContratacion;
use App\Models\TipoServicio;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Contratos extends Component
{
    /* Colecciones */
    public $tipos_contrataciones, $tipos_servicios, $dependencias_nominales, $puestos_nominales, $regiones,
        $dependencias_funcionales, $puestos_funcionales;

    public $id_empleado, $id_contrato, $empleado, $puesto_actual, $rescision_form = false;

    /* Modal Crear y Editar */
    public $modal = false;
    public $modal_editar = false;
    public $puesto_nominal, $primer_puesto, $puesto_funcional, $dependencia_nominal, $dependencia_funcional, $vigente,
        $region, $fecha_inicio, $fecha_fin, $observacion, $salario, $tipo_servicio, $tipo_contratacion, $contrato_correlativo,
        $contrato_renglon, $contrato_year, $numero_contrato, $aprobacion_correlativo, $aprobacion_renglon, $aprobacion_year,
        $acuerdo_aprobacion, $nit_autorizacion, $fianza, $rescision_correlativo, $rescision_renglon, $rescision_year,
        $acuerdo_rescision;

    /* Modal Puestos de Contratos */
    public $modal_crear_puestos = false;
    public $fecha_min, $fecha_max, $contrato, $fechasLibres, $fechasOcupadas;
    public function render()
    {
        $this->tipos_contrataciones = TipoContratacion::select('id', 'tipo')->get();
        $this->tipos_servicios = TipoServicio::select('id', 'tipo_servicio')->get();
        $this->dependencias_nominales = DependenciaNominal::select('id', 'dependencia')->get();
        $this->regiones = Region::select('id', 'region', 'nombre')->get();
        $this->dependencias_funcionales = DependenciaFuncional::select('id', 'dependencia')->get();

        $this->empleado = Empleado::select(
            'empleados.id as id',
            'empleados.codigo as codigo',
            'empleados.imagen as imagen',
            'empleados.nombres as nombres',
            'empleados.apellidos as apellidos',
            'dpis.dpi as dpi'
        )
            ->join('dpis', 'empleados.id', '=', 'dpis.empleados_id')
            ->where('empleados.id', $this->id_empleado)
            ->first();

        $contratos = Contrato::select(
            'contratos.id as id',
            'contratos.numero as numero',
            'contratos.salario as salario',
            'contratos.fecha_inicio as fecha_inicio',
            'contratos.fecha_fin as fecha_fin',
            'puestos_nominales.codigo as codigo',
            'catalogo_puestos.puesto as puesto',
            'dependencias_nominales.dependencia as dependencia',
        )
            ->join('puestos_nominales', 'contratos.puestos_nominales_id', '=', 'puestos_nominales.id')
            ->join('catalogo_puestos', 'puestos_nominales.catalogo_puestos_id', '=', 'catalogo_puestos.id')
            ->join('dependencias_nominales', 'puestos_nominales.dependencias_nominales_id', '=', 'dependencias_nominales.id')
            ->where('contratos.empleados_id', $this->id_empleado);

        $contratos = $contratos->paginate(5);
        activity()
            ->causedBy(auth()->user())
            ->withProperties(['user_id' => auth()->id()])
            ->log("El usuario " . auth()->user()->name .  " visitó la página: " . request()->path());
        return view('livewire.contratos.contratos', [
            'contratos' => $contratos
        ]);
    }

    public function guardarContrato()
    {
        $validated = $this->validate([
            'tipo_contratacion' => 'required|integer|min:1',
            'tipo_servicio' => 'required|integer|min:1',
            'dependencia_nominal' => 'required|integer|min:1',
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
            DB::transaction(function () use ($validated) {
                $contrato = Contrato::create([
                    'numero' => $this->numero_contrato,
                    'fecha_inicio' => $validated['fecha_inicio'],
                    'fecha_fin' => $validated['fecha_fin'],
                    'salario' => $validated['salario'],
                    'acuerdo_aprobacion' => $this->acuerdo_aprobacion,
                    'nit_autorizacion' => $validated['nit_autorizacion'],
                    'fianza' => $validated['fianza'],
                    'vigente' => 0,
                    'tipos_contrataciones_id' => $validated['tipo_contratacion'],
                    'puestos_nominales_id' => $validated['puesto_nominal'],
                    'empleados_id' => $this->id_empleado
                ]);

                /* $pst = PuestoNominal::findOrFail($this->puesto_nominal);
                $pst->activo = 0;
                $pst->save(); */

                /* $emp = Empleado::findOrFail($this->id_empleado);
                $emp->estado = 1;
                $emp->fecha_ingreso = $validated['fecha_inicio'];
                $emp->save(); */

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
            return redirect()->route('contratos', ['id_empleado' => $this->id_empleado]);
        } catch (Exception $e) {
            $errorMessages = "Ocurrió un error: " . $e->getMessage();
            session()->flash('error', $errorMessages);
            $this->cerrarModalCrearContrato();
            return redirect()->route('contratos', ['id_empleado' => $this->id_empleado]);
        }
    }

    public function editar($id_contrato)
    {
        $this->id_contrato = $id_contrato;
        $contrato = Contrato::select(
            'contratos.tipos_contrataciones_id as tipo_contratacion',
            'contratos.puestos_nominales_id as puesto_nominal',
            'contratos.fecha_inicio as fecha_inicio',
            'contratos.fecha_fin as fecha_fin',
            'contratos.salario as salario',
            'contratos.fianza as fianza',
            'contratos.nit_autorizacion as nit_autorizacion',
            'contratos.acuerdo_aprobacion as acuerdo_aprobacion',
            'contratos.acuerdo_rescision as acuerdo_rescision',
            'contratos.vigente as vigente',
            'contratos.numero as numero_contrato',
            'contratos.acuerdo_aprobacion as acuerdo_aprobacion',
            'contratos.acuerdo_rescision as acuerdo_rescision',
            'contratos.fianza as fianza',
            'contratos.nit_autorizacion as nit_autorizacion',
            'puestos_nominales.tipos_servicios_id as tipo_servicio',
            'puestos_nominales.dependencias_nominales_id as dependencia_nominal',
            'registros_puestos.regiones_id as region',
            'registros_puestos.observacion as observacion',
            'puestos_funcionales.puesto as puesto_funcional',
            'dependencias_funcionales.id as dependencia_funcional'
        )
            ->join('puestos_nominales', 'contratos.puestos_nominales_id', '=', 'puestos_nominales.id')
            ->join('registros_puestos', 'contratos.id', '=', 'registros_puestos.contratos_id')
            ->leftjoin('puestos_funcionales', 'registros_puestos.puestos_funcionales_id', '=', 'puestos_funcionales.id')
            ->join('dependencias_funcionales', 'registros_puestos.dependencias_funcionales_id', '=', 'dependencias_funcionales.id')
            ->where('contratos.id', $this->id_contrato)
            ->where('contratos.empleados_id', $this->id_empleado)
            ->first();

        if ($contrato) {
            $this->tipo_contratacion = $contrato->tipo_contratacion;
            $this->tipo_servicio = $contrato->tipo_servicio;
            $this->dependencia_nominal = $contrato->dependencia_nominal;
            $this->getPuestosByDependencia();
            $this->puesto_nominal = $contrato->puesto_nominal;
            $this->puesto_actual = $contrato->puesto_nominal;
            $this->fecha_inicio = $contrato->fecha_inicio;
            $this->fecha_fin = $contrato->fecha_fin;
            $this->salario = $contrato->salario;
            $this->fianza = $contrato->fianza;
            $num = explode('-', $contrato->numero_contrato);
            $this->contrato_correlativo = $num[0];
            $this->contrato_renglon = $num[1];
            $this->contrato_year = $num[2];
            $this->region = $contrato->region;
            $this->dependencia_funcional = $contrato->dependencia_funcional;
            $this->getPuestosFuncionalesByDependenciaFuncional();
            $this->puesto_funcional = $contrato->puesto_funcional;
            $aprobacion = explode('-', $contrato->acuerdo_aprobacion);
            $this->aprobacion_correlativo = $aprobacion[0];
            $this->aprobacion_renglon = $aprobacion[1];
            $this->aprobacion_year = $aprobacion[2];
            $this->nit_autorizacion = $contrato->nit_autorizacion;
            if ($contrato->acuerdo_rescision != '') {
                $rescision = explode('-', $contrato->acuerdo_rescision);
                $this->rescision_correlativo = $rescision[0];
                $this->rescision_renglon = $rescision[1];
                $this->rescision_year = $rescision[2];
            }
            $this->observacion = $contrato->observacion;
        }
        $this->modal_editar = true;
    }

    public function editarContrato()
    {
        $validated = $this->validate([
            'tipo_contratacion' => 'required|integer|min:1',
            'tipo_servicio' => 'required|integer|min:1',
            'dependencia_nominal' => 'required|integer|min:1',
            'puesto_nominal' => 'required|integer|min:1',
            'fecha_inicio' => 'required|date|after_or_equal:1996-11-11',
            'fecha_fin' => 'required|date|after:fecha_inicio',
            'salario' => 'required|decimal:2',
            'fianza' => 'nullable',
            'contrato_correlativo' => 'required|integer|min:1|regex:/^[1-9]\d*$/',
            'contrato_renglon' => 'required|filled',
            'contrato_year' => ['required', 'regex:/^(19[9][6-9]|[2-9][0-9]{3})$/'],
            'region' => 'required|integer|min:1',
            'dependencia_funcional' => 'required|integer|min:1',
            'puesto_funcional' => 'nullable|integer',
            'aprobacion_correlativo' => ['required', 'filled', 'string', 'regex:/^(00\d|[0-9]{3})$/'],
            'aprobacion_renglon' => 'required|filled',
            'aprobacion_year' => ['required', 'regex:/^(19[9][6-9]|[2-9][0-9]{3})$/'],
            'nit_autorizacion' => 'required|filled',
            'rescision_correlativo' => ['required_if:fecha_fin,<,' . now()->format('Y-m-d'), 'nullable', 'string', 'regex:/^(00\d|[0-9]{3})$/'],
            'rescision_renglon' => 'nullable|required_if:fecha_fin,<,' . now()->format('Y-m-d'),
            'rescision_year' => ['required_if:fecha_fin,<,' . now()->format('Y-m-d'), 'nullable', 'regex:/^(19[9][6-9]|[2-9][0-9]{3})$/'],
            'observacion' => 'nullable|regex:/^[A-Za-záàéèíìóòúùÁÀÉÈÍÌÓÒÚÙüÜñÑ\s.,;:-]+$/'
        ]);
        try {
            $this->numero_contrato = $validated['contrato_correlativo'] . '-' . $validated['contrato_renglon'] . '-' . $validated['contrato_year'];
            $this->acuerdo_aprobacion = $validated['aprobacion_correlativo'] . '-' . $validated['aprobacion_renglon'] . '-' . $validated['aprobacion_year'];
            if (!empty($validated['rescision_correlativo']) && !empty($validated['rescision_renglon']) && !empty($validated['rescision_year'])) {
                $this->acuerdo_rescision = $validated['rescision_correlativo'] . '-' . $validated['rescision_renglon'] . '-' . $validated['rescision_year'];
            } else {
                $this->acuerdo_rescision = null;
            }

            DB::transaction(function () use ($validated) {
                $rp = RegistroPuesto::select('primer_puesto_id', 'id')
                    ->where('contratos_id', $this->id_contrato)
                    ->whereNotNull('primer_puesto_id')
                    ->first();

                $contrato = Contrato::findOrFail($this->id_contrato);

                $contrato->numero = $this->numero_contrato;
                $contrato->fecha_inicio = $validated['fecha_inicio'];
                $contrato->fecha_fin = $validated['fecha_fin'];
                $contrato->salario = $validated['salario'];
                $contrato->acuerdo_aprobacion = $this->acuerdo_aprobacion;
                $contrato->acuerdo_rescision = $this->acuerdo_rescision;
                $contrato->nit_autorizacion = $this->nit_autorizacion;
                $contrato->fianza = $validated['fianza'];
                $contrato->puestos_nominales_id = $validated['puesto_nominal'];
                $contrato->tipos_contrataciones_id = $validated['tipo_contratacion'];

                $registro_puesto = RegistroPuesto::findOrFail($rp->id);
                $rp2 = RegistroPuesto::select('id')
                    ->where('contratos_id', $this->id_contrato)
                    ->get();
                if (count($rp2) == 1) {
                    $registro_puesto->fecha_inicio = $validated['fecha_inicio'];
                    $registro_puesto->fecha_fin = $validated['fecha_fin'];
                }
                $ultimo_puesto = RegistroPuesto::select('fecha_fin', 'fecha_inicio')
                    ->where('contratos_id', $this->id_contrato)
                    ->orderBy('fecha_fin', 'desc')
                    ->first();

                if (strtotime($validated['fecha_fin']) < strtotime($ultimo_puesto->fecha_fin)) {
                    if ($ultimo_puesto->fecha_inicio < strtotime($validated['fecha_fin'])) {
                        $ultimo_puesto->update([
                            'fecha_fin' => $validated['fecha_fin']
                        ]);
                    }
                }

                $registro_puesto->observacion = $validated['observacion'];
                $registro_puesto->puestos_funcionales_id = $validated['puesto_funcional'];
                $registro_puesto->primer_puesto_id = $validated['puesto_nominal'];
                $registro_puesto->dependencias_funcionales_id = $validated['dependencia_funcional'];
                $registro_puesto->regiones_id = $validated['region'];

                if (($this->puesto_actual != $validated['puesto_nominal']) && $contrato->vigente == 1) {

                    $puesto = PuestoNominal::findOrFail($validated['puesto_nominal']);
                    $puesto->activo = 0;
                    $puesto->save();

                    $puesto = PuestoNominal::findOrFail($this->puesto_actual);
                    $puesto->activo = 1;
                    $puesto->save();
                }

                $registro_puesto->save();
                $contrato->save();
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
                ->log("El usuario " . auth()->user()->name .  " actualizó el contrato número: " . $this->numero_contrato . " para el empleado: " . $empleado->nombres . " " . $empleado->apellidos);

            activity()
                ->causedBy(auth()->user())
                ->withProperties(['user_id' => auth()->id()])
                ->log("El usuario " . auth()->user()->name .  " guardó el puesto: " . $puesto->codigo . '-' . $puesto->puesto . " para el empleado: " . $empleado->nombres . " " . $empleado->apellidos);
            session()->flash('message');
            $this->cerrarModalEditarContrato();
            return redirect()->route('contratos', ['id_empleado' => $this->id_empleado]);
        } catch (Exception $e) {
            $errorMessages = "Ocurrió un error: " . $e->getMessage();
            session()->flash('error', $errorMessages);
            $this->cerrarModalEditarContrato();
            return redirect()->route('contratos', ['id_empleado' => $this->id_empleado]);
        }
    }

    public function getPuestosByDependencia()
    {
        $this->puesto_nominal = '';
        if ($this->dependencia_nominal) {
            if ($this->id_contrato != '') {
                $puesto_actual = DB::table('contratos')
                    ->select(
                        'puestos_nominales.id as id',
                        'catalogo_puestos.puesto as puesto'
                    )
                    ->join('puestos_nominales', 'contratos.puestos_nominales_id', '=', 'puestos_nominales.id')
                    ->join('catalogo_puestos', 'puestos_nominales.catalogo_puestos_id', '=', 'catalogo_puestos.id')
                    ->where('contratos.empleados_id', $this->id_empleado)
                    ->where('puestos_nominales.dependencias_nominales_id', $this->dependencia_nominal)
                    ->where('contratos.id', $this->id_contrato);
                $this->puestos_nominales = DB::table('puestos_nominales')
                    ->select(
                        'puestos_nominales.id as id',
                        'catalogo_puestos.puesto as puesto'
                    )
                    ->join('catalogo_puestos', 'puestos_nominales.catalogo_puestos_id', '=', 'catalogo_puestos.id')
                    ->where('puestos_nominales.dependencias_nominales_id', '=', $this->dependencia_nominal)
                    ->where('puestos_nominales.activo', '=', 1)
                    ->where('puestos_nominales.tipos_servicios_id', '=', $this->tipo_servicio)
                    ->whereExists(function ($query) {
                        $query->select(DB::raw(1))
                            ->from('requisitos_puestos')
                            ->whereRaw('requisitos_puestos.puestos_nominales_id = puestos_nominales.id');
                    })
                    ->union($puesto_actual)
                    ->get();
            } else {
                $this->puestos_nominales = DB::table('puestos_nominales')
                    ->select(
                        'puestos_nominales.id as id',
                        'catalogo_puestos.puesto as puesto'
                    )
                    ->join('catalogo_puestos', 'puestos_nominales.catalogo_puestos_id', '=', 'catalogo_puestos.id')
                    ->where('puestos_nominales.dependencias_nominales_id', '=', $this->dependencia_nominal)
                    /* ->where('puestos_nominales.activo', '=', 1) */
                    ->where('puestos_nominales.tipos_servicios_id', '=', $this->tipo_servicio)
                    ->whereExists(function ($query) {
                        $query->select(DB::raw(1))
                            ->from('requisitos_puestos')
                            ->whereRaw('requisitos_puestos.puestos_nominales_id = puestos_nominales.id');
                    })
                    ->get();
            }


            $this->salario = '';
        } else {
            $this->puestos_nominales = [];
        }
    }

    public function getPuestosFuncionalesByDependenciaFuncional()
    {
        $this->puesto_funcional = '';
        if ($this->dependencia_funcional) {
            $this->puestos_funcionales = PuestoFuncional::select(
                'id',
                'puesto'
            )
                ->where('dependencias_funcionales_id', $this->dependencia_funcional)
                ->get();
        }
    }

    public function getPuestosByTipoServicio()
    {
        $this->puesto_nominal = '';
        $this->puestos_nominales = '';
        if ($this->tipo_servicio) {
            $this->puestos_nominales = DB::table('puestos_nominales')
                ->join('catalogo_puestos', 'puestos_nominales.catalogo_puestos_id', '=', 'catalogo_puestos.id')
                ->select(
                    'puestos_nominales.id as id',
                    'puestos_nominales.codigo as codigo',
                    'catalogo_puestos.puesto as puesto'
                )
                ->where('puestos_nominales.dependencias_nominales_id', '=', $this->dependencia_nominal)
                ->where('puestos_nominales.activo', '=', 1)
                ->where('puestos_nominales.tipos_servicios_id', '=', $this->tipo_servicio)
                ->whereExists(function ($query) {
                    $query->select(DB::raw(1))
                        ->from('requisitos_puestos')
                        ->whereRaw('requisitos_puestos.puestos_nominales_id = puestos_nominales.id');
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

    /* Verificación de puestos por fechas */
    public function getDisponibilidadPuesto()
    {
        if ($this->puesto_nominal != '' && $this->fecha_fin != '' && $this->fecha_inicio != '') {
            $fechas = Contrato::select(
                'fecha_inicio',
                'fecha_fin'
            )
                ->where('puestos_nominales_id', $this->puesto_nominal)
                ->where('id', '!=', $this->id_contrato)
                ->get();

            $puesto = PuestoNominal::select('catalogo_puestos.puesto as puesto')
                ->join('catalogo_puestos', 'puestos_nominales.catalogo_puestos_id', '=', 'catalogo_puestos.id')
                ->where('puestos_nominales.id', $this->puesto_nominal)
                ->first();
            $fecha_inicio = Carbon::createFromFormat('Y-m-d', $this->fecha_inicio);
            $fecha_fin = Carbon::createFromFormat('Y-m-d', $this->fecha_fin);
            foreach ($fechas as $fecha) {
                $fi = Carbon::createFromFormat('Y-m-d', $fecha->fecha_inicio);
                $ff = Carbon::createFromFormat('Y-m-d', $fecha->fecha_fin);
                if (($fecha_inicio->greaterThanOrEqualTo($fi) && $fecha_inicio->lessThanOrEqualTo($ff))
                    || ($fecha_fin->greaterThanOrEqualTo($fi) && $fecha_fin->lessThanOrEqualTo($ff))
                    || ($fecha_inicio->lessThanOrEqualTo($fi) && $fecha_fin->greaterThanOrEqualTo($ff))
                ) {
                    $this->dispatch('showSweetAlert', ['message' => 'El puesto ' . $puesto->puesto . ' tiene un registro en las fechas seleccionadas. Elija otras.']);
                    $this->fecha_inicio = '';
                    $this->fecha_fin = '';
                    $this->contrato_year = '';
                    $this->aprobacion_year = '';
                }
            }
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
        $this->getDisponibilidadPuesto();
    }

    public function cerrarModalCrearContrato()
    {
        $this->tipo_contratacion = '';
        $this->tipo_servicio = '';
        $this->dependencia_nominal = '';
        $this->puesto_nominal = '';
        $this->puesto_actual = '';
        $this->fecha_inicio = '';
        $this->fecha_fin = '';
        $this->salario = '';
        $this->fianza = '';
        $this->numero_contrato = '';
        $this->contrato_correlativo = '';
        $this->contrato_renglon = '';
        $this->contrato_year = '';
        $this->region = '';
        $this->dependencia_funcional = '';
        $this->puesto_funcional = '';
        $this->acuerdo_aprobacion = '';
        $this->aprobacion_correlativo = '';
        $this->aprobacion_renglon = '';
        $this->aprobacion_year = '';
        $this->nit_autorizacion = '';
        $this->observacion = '';
        $this->modal = false;
    }

    public function cerrarModalEditarContrato()
    {
        $this->tipo_contratacion = '';
        $this->tipo_servicio = '';
        $this->dependencia_nominal = '';
        $this->puesto_nominal = '';
        $this->puesto_actual = '';
        $this->fecha_inicio = '';
        $this->fecha_fin = '';
        $this->salario = '';
        $this->fianza = '';
        $this->numero_contrato = '';
        $this->contrato_correlativo = '';
        $this->contrato_renglon = '';
        $this->contrato_year = '';
        $this->region = '';
        $this->dependencia_funcional = '';
        $this->puesto_funcional = '';
        $this->acuerdo_aprobacion = '';
        $this->aprobacion_correlativo = '';
        $this->aprobacion_renglon = '';
        $this->aprobacion_year = '';
        $this->nit_autorizacion = '';
        $this->acuerdo_rescision = '';
        $this->rescision_correlativo = '';
        $this->rescision_renglon = '';
        $this->rescision_year = '';
        $this->observacion = '';
        $this->modal_editar = false;
    }

    public function guardarPuestoContrato()
    {
        try {
            $validated = $this->validate([
                'fecha_inicio' => 'required|date|after_or_equal:' . $this->fecha_min . '|before_or_equal:' . $this->fecha_max,
                'fecha_fin' => 'required|date|after_or_equal:' . $this->fecha_min . '|before_or_equal:' . $this->fecha_max,
                'observacion' => 'nullable|regex:/^[A-Za-záàéèíìóòúùÁÀÉÈÍÌÓÒÚÙüÜñÑ\s.,;:-]+$/',
                'dependencia_funcional' => 'required|integer|min:1',
                'puesto_funcional' => 'nullable|integer|min:1',
                'region' => 'required|integer|min:1'
            ]);
            DB::transaction(function ()  use ($validated) {
                RegistroPuesto::create([
                    'fecha_inicio' => $validated['fecha_inicio'],
                    'fecha_fin' => $validated['fecha_fin'],
                    'observacion' => $validated['observacion'],
                    'dependencias_funcionales_id' => $validated['dependencia_funcional'],
                    'puestos_funcionales_id' => $validated['puesto_funcional'],
                    'regiones_id' => $validated['region'],
                    'contratos_id' => $this->id_contrato
                ]);
            });
            $puesto = PuestoFuncional::select('puesto')->where('id', $this->puesto_funcional)->first();
            if ($puesto == null) {
                $puesto = '';
            } else {
                $puesto = $puesto->puesto;
            }
            $empleado = Empleado::findOrFail($this->id_empleado);
            activity()
                ->causedBy(auth()->user())
                ->withProperties(['user_id' => auth()->id()])
                ->log("El usuario " . auth()->user()->name .  " guardó el puesto: " . $puesto . " para el empleado: " . $empleado->nombres . " " . $empleado->apellidos);
            session()->flash('message');
            $this->cerrarModal();
            return redirect()->route('contratos', ['id_empleado' => $this->id_empleado]);
        } catch (Exception $e) {
            $errorMessages = "Ocurrió un error: " . $e->getMessage();
            session()->flash('error', $errorMessages);
            $this->cerrarModal();
            return redirect()->route('contratos', ['id_empleado' => $this->id_empleado]);
        }
    }

    public function crearPuestoContrato($id_contrato)
    {
        $this->id_contrato = $id_contrato;
        $this->contrato = $id_contrato;
        $this->getDisponibilidadFechas();
        $contrato = Contrato::findOrFail($id_contrato);
        $this->numero_contrato = $contrato->numero;
        $this->fecha_max = $contrato->fecha_fin;
        $this->fecha_min = $contrato->fecha_inicio;
        $this->modal_crear_puestos = true;
    }

    public function cerrarModalPuestoContrato()
    {
        $this->numero_contrato = '';
        $this->fecha_inicio = '';
        $this->fecha_fin = '';
        $this->observacion = '';
        $this->region = '';
        $this->dependencia_funcional = '';
        $this->puesto_funcional = '';
        $this->fecha_min = '';
        $this->fecha_max = '';
        $this->modal_crear_puestos = false;
    }

    public function verificarFechaFin()
    {
        $ultimo_puesto = RegistroPuesto::select('fecha_fin', 'fecha_inicio')
            ->where('contratos_id', $this->id_contrato)
            ->orderBy('fecha_fin', 'desc')
            ->first();

        if (strtotime($this->fecha_fin) < strtotime($ultimo_puesto->fecha_fin)) {
            if ($ultimo_puesto->fecha_inicio > strtotime($this->fecha_fin)) {
                $this->dispatch('errorUltimoPuesto', ['message' => 'No se puede elegir esta fecha de finalización debido a que es menor a la fecha de inicio del último puesto del empleado.']);
                $this->fecha_fin = '';
            }
        }
    }

    public function crear()
    {
        $this->modal = true;
    }

    public function getDisponibilidadFechas()
    {
        $this->fecha_min = '';
        $this->fecha_max = '';
        $this->fechasLibres = [];
        $this->fechasOcupadas = [];

        if ($this->contrato != '') {
            $fechas_contrato = Contrato::findOrFail($this->contrato);
            $puestos_contrato = RegistroPuesto::select('fecha_inicio', 'fecha_fin')
                ->where('contratos_id', $this->contrato)
                ->get()
                ->toArray();

            $fechaInicioContrato = $fechas_contrato->fecha_inicio;
            $fechaFinContrato = $fechas_contrato->fecha_fin;

            foreach ($puestos_contrato as $puesto) {
                $this->fechasOcupadas[] = ['fecha_inicio' => $puesto['fecha_inicio'], 'fecha_fin' => $puesto['fecha_fin']];
            }

            // Ordenar por fecha de inicio
            usort($this->fechasOcupadas, function ($a, $b) {
                return strtotime($a['fecha_inicio']) - strtotime($b['fecha_inicio']);
            });

            $inicioLibre = $fechaInicioContrato;

            foreach ($this->fechasOcupadas as $ocupada) {
                $finOcupada = $ocupada['fecha_fin'];

                if (strtotime($inicioLibre) < strtotime($ocupada['fecha_inicio'])) {
                    $this->fechasLibres[] = ['fecha_inicio' => $inicioLibre, 'fecha_fin' => date('Y-m-d', strtotime($ocupada['fecha_inicio'] . ' -1 day'))];
                }

                $inicioLibre = date('Y-m-d', strtotime($finOcupada . ' +1 day'));
            }

            if (strtotime($inicioLibre) <= strtotime($fechaFinContrato)) {
                $this->fechasLibres[] = ['fecha_inicio' => $inicioLibre, 'fecha_fin' => $fechaFinContrato];
            }

            if (empty($this->fechasLibres)) {
                $this->dispatch('fechasOcupadasAlert', ['message' => 'El contrato ' . $fechas_contrato->numero .
                    ' no tiene fechas disponibles para crear un nuevo puesto. Debe actualizar el registro del último puesto asignado.']);
                $this->contrato = '';
                $this->fecha_min = '';
                $this->fecha_max = '';
                $this->fechasLibres = [];
                $this->fechasOcupadas = [];
            } else {
                $this->fecha_min = end($this->fechasLibres)['fecha_inicio'];
                $this->fecha_max = end($this->fechasLibres)['fecha_fin'];
            }
        }
    }

    public function mount($id_empleado)
    {
        $this->id_empleado = $id_empleado;
        $this->rescision_form = true;
    }
}
