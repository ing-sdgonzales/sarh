<?php

namespace App\Livewire\Candidatos;

use App\Models\AplicacionCandidato;
use App\Models\Candidato;
use App\Models\EtapaAplicacion;
use App\Models\RequisitoCandidato;
use App\Models\RequisitoPuesto;
use App\Notifications\AvisoRequisitosRechazados;
use App\Notifications\NotificacionPresentarExpediente;
use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use setasign\Fpdi\Fpdi;

class Expediente extends Component
{
    public $id_candidato, $id_requisito_candidato, $estado;
    public $requisitos, $puestos, $pdf, $candidato;
    public $control_requisito = [['val' => 0, 'res' => 'No aprobado'], ['val' => 1, 'res' => 'Aprobado']];
    public $puesto, $aprobado, $observacion;
    public $modal = false;

    /* variables de progreso */
    public $porcentaje_requisitos_presentados = 0;
    public $porcentaje_requisitos_aprobados = 0;
    public $total_requisitos;
    public $total_requisitos_cargados = 0;
    public $total_requisitos_aprobados = 0;
    public $requisitos_no_validos;
    public $notificar = false;

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

        $this->requisitos_no_validos = RequisitoCandidato::select('id')
            ->where('valido', 0)
            ->where('revisado', 1)
            ->get();
        if (count($this->requisitos_no_validos) > 0) {
            $this->notificar = true;
        } else {
            $this->notificar = false;
        }

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
        $validated = $this->validate([
            'aprobado' => 'required|integer|min:0',
            'observacion' => 'required_if:aprobado,0|nullable'
        ]);
        try {
            DB::transaction(function () use ($validated) {
                $req = RequisitoCandidato::findOrFail($this->id_requisito_candidato);

                $req->observacion = $validated['observacion'];
                $req->valido = $validated['aprobado'];
                $req->revisado = 1;
                $req->fecha_revision = date("Y-m-d H:i:s");

                $this->estado = 'rechazó';
                if ($this->aprobado == 1) {
                    $this->estado = 'aprobó';
                    $this->addWaterMark($req->ubicacion);
                }

                $req->save();

                $reqs_puesto = RequisitoPuesto::select('requisitos_id')->where('puestos_nominales_id', $this->puesto)
                    ->orderBy('requisitos_id', 'asc')->pluck('requisitos_id')->toArray();

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
                        ->where('puestos_nominales_id', $this->puesto)
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
                ->where('requisitos_candidatos.puestos_nominales_id', '=', $this->puesto)
                ->where('requisitos_candidatos.id', '=', $this->id_requisito_candidato)
                ->first();

            session()->flash('message');
            $this->cerrarModal();
            $this->limpiarModal();
            activity()
                ->causedBy(auth()->user())
                ->withProperties(['user_id' => auth()->id()])
                ->log("El usuario " . auth()->user()->name . " " . $this->estado . " el requisito: " . $log->requisito . " del candidato " . $log->nombre);
            session()->flash('message');
            return redirect()->route('expedientes', ['candidato_id' => $this->id_candidato]);
        } catch (Exception $e) {
            $errorMessages = "Ocurrió un error: " . $e->getMessage();
            session()->flash('error', $errorMessages);
            $this->cerrarModal();
            $this->limpiarModal();
            return redirect()->route('expedientes', ['candidato_id' => $this->id_candidato]);
        }
    }

    public function notificar()
    {
        $requisitoRechazados = DB::table('requisitos_candidatos')
            ->join('requisitos', 'requisitos_candidatos.requisitos_id', '=', 'requisitos.id')
            ->select(
                'requisitos.requisito as requisito',
                'requisitos_candidatos.observacion as observacion'
            )
            ->where('requisitos_candidatos.candidatos_id', '=', $this->id_candidato)
            ->where('requisitos_candidatos.puestos_nominales_id', '=', $this->puesto)
            ->where('requisitos_candidatos.valido', '=', 0)
            ->where('requisitos_candidatos.revisado', '=', 1)
            ->get();

        if ($requisitoRechazados->count() > 0) {
            $candidato = Candidato::findOrFail($this->id_candidato);
            $candidato->notify(new AvisoRequisitosRechazados($requisitoRechazados));

            activity()
                ->causedBy(auth()->user())
                ->withProperties(['user_id' => auth()->id()])
                ->log("El usuario " . auth()->user()->name .  " notificó al candidato: " . $candidato->nombre . " que debe actualizar sus requisitos.");

            session()->flash('message');
            return redirect()->route('expedientes', ['candidato_id' => $this->id_candidato]);
        }
    }

    public function addWaterMark($archivo)
    {
        $fpdi = new Fpdi();
        $count = $fpdi->setSourceFile(public_path('storage/' . $archivo));

        for ($i = 1; $i <= $count; $i++) {

            $template = $fpdi->importPage($i);
            $size = $fpdi->getTemplateSize($template);
            $fpdi->AddPage($size['orientation'], array($size['width'], $size['height']));
            $fpdi->useTemplate($template);

            $fpdi->SetFont("Arial", "", 5);
            $fpdi->SetTextColor(128, 128, 128);

            $left = 2;
            $top = 2;
            $text = "Revisado por:\n" . iconv('utf-8', 'ISO-8859-2', auth()->user()->name) . "\n" . date('d/m/Y H:m:s');
            $fpdi->SetXY($left, $top);
            $fpdi->MultiCell(0, 2, $text);
            $fpdi->Output(public_path('storage/' . $archivo), 'F');
        }
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
            ->where('requisitos_id', '=', $requisito_id)
            ->where('puestos_nominales_id', '=', $this->puesto)
            ->first();
        if (is_null($this->pdf->fecha_revision) != 1 && ($this->pdf->valido == 0 || $this->pdf->valido == 1)) {
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
                'requisitos_candidatos.candidatos_id',
                'requisitos_candidatos.fecha_carga as fecha_carga'
            )
            ->where('aplicaciones_candidatos.candidatos_id', '=', $this->id_candidato)
            ->where('aplicaciones_candidatos.puestos_nominales_id', '=', $this->puesto)
            ->orderBy('requisitos.id', 'asc')
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
