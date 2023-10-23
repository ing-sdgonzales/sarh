<?php

namespace App\Livewire;

use App\Models\RequisitoCandidato;
use App\Models\RequisitoPuesto;
use App\Notifications\NotificacionCargaRequisitos;
use Exception;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
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
                'requisitos_candidatos.fecha_revision as fecha_revision',
                'requisitos_candidatos.valido as valido',
                'requisitos_candidatos.revisado as revisado',
                'requisitos_candidatos.fecha_carga as fecha_carga',
                'renglones.renglon as renglon'
            )
            ->where('aplicaciones_candidatos.candidatos_id', '=', $this->id_candidato)
            ->where('aplicaciones_candidatos.puestos_nominales_id', '=', $this->puesto);
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
        $this->porcentaje_requisitos_presentados = ($this->total_requisitos_cargados / $this->total_requisitos) * 100;
        $this->porcentaje_requisitos_aprobados = ($this->total_requisitos_aprobados / $this->total_requisitos) * 100;
        return view('livewire.listar-requisitos', [
            'requisitos' => $requisitos->paginate(10)
        ]);
    }

    public function guardar()
    {
        try {
            foreach ($this->requisito as $requisito_id => $archivo) {
                $this->validate([
                    "requisito.{$requisito_id}" => [
                        'required',
                        'file',
                        'mimes:pdf,doc,docx',
                        'max:5120',
                    ],
                ]);

                $requisito = RequisitoCandidato::where([
                    'candidatos_id' => $this->id_candidato,
                    'puestos_nominales_id' => $this->puesto,
                    'requisitos_id' => $requisito_id
                ])
                    ->join('requisitos', 'requisitos_candidatos.requisitos_id', '=', 'requisitos.id')
                    ->first();

                if ($requisito) {
                    if (Storage::disk('public')->exists($requisito->ubicacion)) {
                        Storage::disk('public')->delete($requisito->ubicacion);
                    }
                }
                $path = $archivo->store('requisitos', 'public');

                if ($requisito) {
                    $requisito->update([
                        'ubicacion' => $path,
                        'observacion' => '',
                        'fecha_carga' => date("Y-m-d H:i:s"),
                        'valido' => 0,
                        'fecha_revision' => null
                    ]);
                    $requisito->revisado = 0;
                    $requisito->save();
                    $this->requisitos_cargados[] = [
                        'requisito' => $requisito->requisito
                    ];
                } else {
                    $req = RequisitoCandidato::create([
                        'candidatos_id' => $this->id_candidato,
                        'puestos_nominales_id' => $this->puesto,
                        'requisitos_id' => $requisito_id,
                        'ubicacion' => $path
                    ]);

                    $this->requisitos_cargados[] = [
                        'requisito' => $req->requisito
                    ];
                }

                /* $this->requisitos_cargados[$requisito_id] = $archivo->getClientOriginalName(); */
            }
            Notification::route('mail', 'ing.sergiodaniel@gmail.com')
                ->notify(new NotificacionCargaRequisitos($this->requisitos_cargados, $this->nombre_candidato, $this->id_candidato));
        } catch (Exception $e) {
            $errorMessages = "Ocurrió un error: " . $e->getMessage();
            session()->flash('error', $errorMessages);
            return redirect()->route('presentar_requisitos', ['id_candidato' => $this->id_candidato]);
        }
        $this->resetPage();
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
