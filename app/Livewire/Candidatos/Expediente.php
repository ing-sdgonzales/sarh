<?php

namespace App\Livewire\Candidatos;

use App\Models\RequisitoCandidato;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

use function Laravel\Prompts\select;

class Expediente extends Component
{
    public $id_candidato, $id_requisito_candidato;
    public $requisitos, $puestos, $pdf, $candidato;
    public $control_requisito = [['val' => 0, 'res' => 'No aprobado'], ['val' => 1, 'res' => 'Aprobado']];
    public $puesto = 1, $aprobado, $observacion;
    public $modal = false;

    /* variables de progreso */
    public $porcentaje_requisitos_presentados = 0;
    public $porcentaje_requisitos_aprobados = 0;
    public $total_requisitos;
    public $total_requisitos_cargados = 0;
    public $total_requisitos_aprobados = 0;

    public function render()
    {
        $this->puestos = DB::table('puestos_nominales')
            ->join('aplicaciones_candidatos', 'puestos_nominales.id', '=', 'aplicaciones_candidatos.puestos_nominales_id')
            ->join('catalogo_puestos', 'puestos_nominales.catalogo_puestos_id', '=', 'catalogo_puestos.id')
            ->select(
                'catalogo_puestos.puesto as puesto',
                'puestos_nominales.id as id'
            )
            ->where('aplicaciones_candidatos.candidatos_id', '=', $this->id_candidato)
            ->get();
        $this->candidato = DB::table('candidatos')
            ->select(
                'imagen',
                'nombre'
            )
            ->where('id', '=', $this->id_candidato)
            ->first();
        $this->total_requisitos_cargados = DB::table('requisitos_candidatos')
            ->select('id')
            ->where('candidatos_id', '=', $this->id_candidato)
            ->count();


        $this->total_requisitos_aprobados = DB::table('requisitos_candidatos')
            ->select('id')
            ->where('candidatos_id', '=', $this->id_candidato)
            ->where('valido', '=', 1)
            ->count();
        $this->puesto = $this->puestos[0]->id;
        $this->getRequisitosByPuesto();
        activity()
            ->causedBy(auth()->user())
            ->withProperties(['user_id' => auth()->id()])
            ->log("El usuario " . auth()->user()->name .  " visitó la página: " . request()->path());
        $this->porcentaje_requisitos_presentados = ($this->total_requisitos_cargados / $this->total_requisitos) * 100;
        $this->porcentaje_requisitos_aprobados = ($this->total_requisitos_aprobados / $this->total_requisitos) * 100;
        return view('livewire.candidatos.expediente');
    }

    public function guardar()
    {
        $req = RequisitoCandidato::findOrFail($this->id_requisito_candidato);

        $req->observacion = $this->observacion;
        $req->valido = $this->aprobado;
        $req->revisado = 1;
        $req->fecha_revision = date("Y-m-d h:i:s");

        $req->save();

        $estado =  'rechazó';
        if ($this->aprobado == 1) {
            $estado = 'aprobó';
        }

        $log = DB::table('requisitos_candidatos')
            ->join('candidatos', 'requisitos_candidatos.candidatos_id', '=', 'candidatos.id')
            ->join('requisitos', 'requisitos_candidatos.requisitos_id', '=', 'requisitos.id')
            ->select(
                'candidatos.nombre as nombre',
                'requisitos.requisito as requisito',
            )
            ->where('requisitos_candidatos.candidatos_id', '=', $this->id_candidato)
            ->where('requisitos_candidatos.puestos_nominales_id', '=', $this->puesto)
            ->where('requisitos_candidatos.id', '=', $this->id_requisito_candidato)
            ->first();

        session()->flash('message');
        $this->cerrarModal();
        $this->limpiarModal();
        activity()
            ->causedBy(auth()->user())
            ->withProperties(['user_id' => auth()->id()])
            ->log("El usuario " . auth()->user()->name . " " . $estado . " el requisito: " . $log->requisito . " del candidato " . $log->nombre);
        return back();
    }

    public function verificarRequisito($requisito_id)
    {
        $this->pdf = DB::table('requisitos_candidatos')
            ->select(
                'id',
                'ubicacion',
                'valido',
                'fecha_revision',
                'observacion'
            )
            ->where('candidatos_id', '=', $this->id_candidato)
            ->where('id', '=', $requisito_id)
            ->where('puestos_nominales_id', '=', $this->puesto)
            ->first();
        if ($this->pdf->fecha_revision != null && ($this->pdf->valido == 0 || $this->pdf->valido == 1)) {
            $this->aprobado = $this->pdf->valido;
        } else {
            $this->aprobado = '';
        }
        $this->observacion = $this->pdf->observacion;
        $this->id_requisito_candidato =  $this->pdf->id;
        $this->abrirModal();
    }

    public function getRequisitosByPuesto()
    {
        $this->requisitos = DB::table('requisitos')
            ->join('requisitos_puestos', 'requisitos.id', '=', 'requisitos_puestos.requisitos_id')
            ->leftJoin('requisitos_candidatos', function ($join) {
                $join->on('requisitos.id', '=', 'requisitos_candidatos.requisitos_id')
                    ->where('requisitos_candidatos.candidatos_id', '=', $this->id_candidato);
            })
            ->join('puestos_nominales', 'requisitos_puestos.puestos_nominales_id', '=', 'puestos_nominales.id')
            ->join('aplicaciones_candidatos', 'puestos_nominales.id', '=', 'aplicaciones_candidatos.puestos_nominales_id')
            ->select(
                'requisitos.id as id',
                'requisitos.requisito as requisito',
                'requisitos.especificacion as especificacion',
                'requisitos_candidatos.fecha_revision as fecha_revision',
                'requisitos_candidatos.valido as valido',
                'requisitos_candidatos.revisado as revisado',
                'requisitos_candidatos.fecha_carga as fecha_carga'
            )
            ->where('aplicaciones_candidatos.candidatos_id', '=', $this->id_candidato)
            ->where('aplicaciones_candidatos.puestos_nominales_id', '=', $this->puesto)
            ->get();
        $this->total_requisitos =  $this->requisitos->count();
    }

    public function mount($candidato_id)
    {
        $this->id_candidato = $candidato_id;
    }

    public function abrirModal()
    {
        $this->modal =  true;
    }

    public function cerrarModal()
    {
        $this->modal = false;
    }

    public function limpiarModal()
    {
        $this->aprobado = '';
        $this->observacion = '';
    }
}
