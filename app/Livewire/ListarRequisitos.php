<?php

namespace App\Livewire;

use App\Models\AplicacionCandidato;
use App\Models\EtapaAplicacion;
use App\Models\RequisitoCandidato;
use App\Models\RequisitoPuesto;
use App\Notifications\NotificacionCargaRequisitos;
use Exception;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class ListarRequisitos extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $id_candidato, $nombre_candidato, $filtro = '', $requisitos_candidato, $requisito = [], $requisitos_cargados = [], $archivo, $puestos;
    public $puesto;

    /* variables de progreso */
    public $porcentaje_requisitos_presentados = 0;
    public $porcentaje_requisitos_aprobados = 0;
    public $total_requisitos;
    public $total_requisitos_cargados = 0;
    public $total_requisitos_aprobados = 0;

    /* Listado de requisitos */
    #[Layout('layouts.app2')]
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

        $this->puesto = $this->puestos[0]->id;
        $requisitos = DB::table('requisitos')
            ->join('requisitos_puestos', 'requisitos.id', '=', 'requisitos_puestos.requisitos_id')
            ->leftJoin('requisitos_candidatos', function ($join) {
                $join->on('requisitos.id', '=', 'requisitos_candidatos.requisitos_id')
                    ->where('requisitos_candidatos.candidatos_id', '=', $this->id_candidato);
            })
            ->join('puestos_nominales', 'requisitos_puestos.puestos_nominales_id', '=', 'puestos_nominales.id')
            ->join('renglones', 'puestos_nominales.renglones_id', '=', 'renglones.id')
            ->join('aplicaciones_candidatos', 'puestos_nominales.id', '=', 'aplicaciones_candidatos.puestos_nominales_id')
            ->select(
                'requisitos.id as id',
                'requisitos.requisito as requisito',
                'requisitos.especificacion as especificacion',
                'requisitos_candidatos.id as id_requisito_cargado',
                'requisitos_candidatos.fecha_revision as fecha_revision',
                'requisitos_candidatos.valido as valido',
                'requisitos_candidatos.revisado as revisado',
                'requisitos_candidatos.fecha_carga as fecha_carga',
                'renglones.renglon as renglon'
            )
            ->where('aplicaciones_candidatos.candidatos_id', '=', $this->id_candidato)
            ->where('aplicaciones_candidatos.puestos_nominales_id', '=', $this->puesto)
            ->orderBy('requisitos.id', 'asc');
        $this->total_requisitos =  $requisitos->count();

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
        if ($this->total_requisitos_aprobados > 0) {
            session()->flash('requisito', 'requisitos_aprobados');
        }
        $this->porcentaje_requisitos_presentados = number_format(($this->total_requisitos_cargados / $this->total_requisitos) * 100, 2);

        $this->porcentaje_requisitos_aprobados = number_format(($this->total_requisitos_aprobados / $this->total_requisitos) * 100, 2);
        return view('livewire.listar-requisitos', [
            'requisitos' => $requisitos->paginate(10)
        ]);
    }

    public function guardar()
    {
        try {
            DB::transaction(function () {
                foreach ($this->requisito as $requisito_id => $archivo) {
                    $this->validate([
                        "requisito.{$requisito_id}" => [
                            'required',
                            'file',
                            'mimes:pdf,doc,docx',
                            'max:5120',
                        ]
                    ]);

                    $requisito = RequisitoCandidato::where([
                        'candidatos_id' => $this->id_candidato,
                        'puestos_nominales_id' => $this->puesto,
                        'requisitos_id' => $requisito_id
                    ])
                        ->join('requisitos', 'requisitos_candidatos.requisitos_id', '=', 'requisitos.id')
                        ->select(
                            'requisitos.requisito as requisito',
                            'requisitos_candidatos.id as id_requisito_candidato',
                            'requisitos_candidatos.ubicacion as ubicacion'
                        )
                        ->first();
                    if ($requisito) {
                        if (Storage::disk('public')->exists($requisito->ubicacion)) {
                            Storage::disk('public')->delete($requisito->ubicacion);
                        }
                    }
                    $path = $archivo->store('requisitos', 'public');

                    if ($requisito) {
                        $req = RequisitoCandidato::findOrFail($requisito->id_requisito_candidato);

                        $req->ubicacion = $path;
                        $req->observacion = '';
                        $req->fecha_carga = date("Y-m-d H:i:s");
                        $req->valido = 0;
                        $req->fecha_revision = null;
                        $req->revisado = 0;

                        $req->save();

                        $this->requisitos_cargados[] = [
                            'requisito' => $requisito->requisito
                        ];
                    } else {
                        RequisitoCandidato::create([
                            'candidatos_id' => $this->id_candidato,
                            'puestos_nominales_id' => $this->puesto,
                            'requisitos_id' => $requisito_id,
                            'ubicacion' => $path
                        ]);

                        $req = RequisitoCandidato::where([
                            'candidatos_id' => $this->id_candidato,
                            'puestos_nominales_id' => $this->puesto,
                            'requisitos_id' => $requisito_id
                        ])
                            ->join('requisitos', 'requisitos_candidatos.requisitos_id', '=', 'requisitos.id')
                            ->select('requisitos.requisito as requisito', 'requisitos_candidatos.id as id_requisito_candidato')
                            ->first();

                        $this->requisitos_cargados[] = [
                            'requisito' => $req->requisito
                        ];
                    }

                    /* $this->requisitos_cargados[$requisito_id] = $archivo->getClientOriginalName(); */
                }
                Notification::route('mail', 'ing.sergiodaniel@gmail.com')
                    ->notify(new NotificacionCargaRequisitos($this->requisitos_cargados, $this->nombre_candidato, $this->id_candidato));

                $reqs_puesto = RequisitoPuesto::select('requisitos_id')->where('puestos_nominales_id', $this->puesto)
                    ->orderBy('requisitos_id', 'asc')->pluck('requisitos_id')->toArray();
                $reqs_candidato = RequisitoCandidato::select('requisitos_id')->where('candidatos_id', $this->id_candidato)
                    ->orderBy('requisitos_id', 'asc')
                    ->pluck('requisitos_id')
                    ->toArray();

                $dif_reqs = array_diff($reqs_puesto, $reqs_candidato);
                if (count($dif_reqs) == 0) {
                    $aplicacion = AplicacionCandidato::select('id')->where('candidatos_id', $this->id_candidato)
                        ->where('puestos_nominales_id', $this->puesto)
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
            });
        } catch (Exception $e) {
            $errorMessages = "Ocurrió un error: " . $e->getMessage();
            session()->flash('error', $errorMessages);
            return redirect()->route('presentar_requisitos', ['id_candidato' => $this->id_candidato]);
        }
    }

    public function descargar($id_requisito)
    {
        $requisito = DB::table('requisitos_candidatos')
            ->join('requisitos', 'requisitos_candidatos.requisitos_id', '=', 'requisitos.id')
            ->join('candidatos', 'requisitos_candidatos.candidatos_id', '=', 'candidatos.id')
            ->select(
                'requisitos.requisito as requisito',
                'candidatos.dpi as dpi',
                'requisitos_candidatos.ubicacion as ubicacion'
            )
            ->where('requisitos_candidatos.id', '=', $id_requisito)
            ->first();

        $ext = pathinfo('storage/' . $requisito->ubicacion, PATHINFO_EXTENSION);

        return response()->download('storage/' . $requisito->ubicacion, $requisito->requisito . '_' . $requisito->dpi . '.' . $ext);
    }

    public function mount($id_candidato)
    {
        $this->id_candidato = $id_candidato;
        $nombre_candidato = DB::table('candidatos')->select('nombre')->where('id', '=', $id_candidato)->first();
        $this->nombre_candidato = $nombre_candidato->nombre;
    }

    public function getRequisitosByPuesto()
    {
        $this->filtro = $this->puesto;
    }
}
