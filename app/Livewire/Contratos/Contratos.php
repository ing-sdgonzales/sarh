<?php

namespace App\Livewire\Contratos;

use App\Models\Contrato;
use App\Models\DependenciaNominal;
use App\Models\Empleado;
use App\Models\PuestoNominal;
use App\Models\TipoContratacion;
use App\Models\TipoServicio;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Contratos extends Component
{
    /* Colecciones */
    public $tipos_contrataciones, $tipos_servicios, $dependencias_nominales, $puestos_nominales, $regiones, $dependencias_funcionales,
        $puestos_funcionales;

    public $id_empleado, $id_contrato, $empleado, $contratos;

    /* Modal Crear y Editar */
    public $modal = false;
    public $modal_editar = false;
    public $puesto_nominal, $puesto_funcional, $dependencia_nominal, $dependencia_funcional, $region, $fecha_inicio,
        $fecha_fin, $observacion, $salario, $tipo_servicio, $tipo_contratacion, $contrato_correlativo, $contrato_renglon,
        $contrato_year, $numero_contrato;
    public function render()
    {
        $this->tipos_contrataciones = TipoContratacion::select('id', 'tipo')->get();
        $this->tipos_servicios = TipoServicio::select('id', 'tipo_servicio')->get();
        $this->dependencias_nominales = DependenciaNominal::select('id', 'dependencia')->get();

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

        $this->contratos = Contrato::select(
            'contratos.id as id_contrato',
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
            ->where('contratos.empleados_id', $this->id_empleado)
            ->get();
        return view('livewire.contratos.contratos');
    }

    public function guardarContrato()
    {
    }

    public function editar($id_contrato)
    {
        $this->id_contrato = $id_contrato;
        $contrato = Contrato::select(
            'contratos.tipos_contrataciones_id as tipo_contratacion',
            'puestos_nominales.tipos_servicios_id as tipo_servicio',
            'puestos_nominales.dependencias_nominales_id as dependencia_nominal',
            'contratos.fecha_inicio as fecha_inicio',
            'contratos.fecha_fin as fecha_fin',
            'contratos.salario as salario',
            'contratos.numero as numero_contrato'
        )
            ->join('puestos_nominales', 'contratos.puestos_nominales_id', '=', 'puestos_nominales.id')
            ->where('contratos.id', $this->id_contrato)
            ->where('contratos.empleados_id', $this->id_empleado)
            ->first();

        if ($contrato) {
            $this->tipo_contratacion = $contrato->tipo_contratacion;
            $this->tipo_servicio = $contrato->tipo_servicio;
            $this->dependencia_nominal = $contrato->dependencia_nominal;
            $this->getPuestosByDependencia();
            $this->fecha_inicio = $contrato->fecha_inicio;
            $this->fecha_fin = $contrato->fecha_fin;
            $this->salario = $contrato->salario;
            $num = explode('-', $contrato->numero_contrato);
            $this->contrato_correlativo = $num[0];
            $this->contrato_renglon = $num[1];
            $this->contrato_year = $num[2];
        }
        $this->modal_editar = true;
    }

    public function getPuestosByDependencia()
    {
        $this->puesto_nominal = '';
        if ($this->dependencia_nominal) {
            $this->puestos_nominales = DB::table('puestos_nominales')
                ->join('catalogo_puestos', 'puestos_nominales.catalogo_puestos_id', '=', 'catalogo_puestos.id')
                ->join('contratos', 'puestos_nominales.id', '=', 'contratos.puestos_nominales_id')
                ->select(
                    'puestos_nominales.id as id',
                    'puestos_nominales.codigo as codigo',
                    'catalogo_puestos.puesto as puesto'
                )
                ->where('puestos_nominales.dependencias_nominales_id', '=', $this->dependencia_nominal)
                ->where('puestos_nominales.estado', '=', 1)
                ->where('puestos_nominales.tipos_servicios_id', '=', $this->tipo_servicio)
                ->where(function ($query) {
                    $query->where('contratos.empleados_id', '=', $this->id_empleado)
                        ->orWhere('contratos.id', '=', $this->id_contrato);
                })
                ->whereNotExists(function ($query) {
                    $query->select(DB::raw(1))
                        ->from('contratos AS c2')
                        ->whereRaw('c2.puestos_nominales_id = puestos_nominales.id')
                        ->where('c2.empleados_id', '<>', $this->id_empleado);
                })
                ->whereExists(function ($query) {
                    $query->select(DB::raw(1))
                        ->from('requisitos_puestos')
                        ->whereRaw('requisitos_puestos.puestos_nominales_id = puestos_nominales.id');
                })
                ->get();
            $this->salario = '';
        } else {
            $this->puestos_nominales = [];
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
                ->where('puestos_nominales.estado', '=', 1)
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
        } else {
            $this->salario = '';
        }
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
        $this->modal = false;
    }

    public function cerrarModalEditarContrato()
    {
        $this->puesto_nominal = '';
        $this->dependencia_nominal = '';
        $this->fecha_inicio = '';
        $this->fecha_fin = '';
        $this->salario = '';
        $this->tipo_servicio = '';
        $this->tipo_contratacion = '';
        $this->contrato_correlativo = '';
        $this->contrato_renglon = '';
        $this->contrato_year = '';
        $this->numero_contrato = '';
        $this->modal_editar = false;
    }

    public function crear()
    {
        $this->modal = true;
    }

    public function mount($id_empleado)
    {
        $this->id_empleado = $id_empleado;
    }
}
