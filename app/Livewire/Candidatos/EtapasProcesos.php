<?php

namespace App\Livewire\Candidatos;

use App\Models\AplicacionCandidato;
use App\Models\EtapaAplicacion;
use App\Models\EtapaProceso;
use Livewire\Component;
use Livewire\Attributes\Layout;

class EtapasProcesos extends Component
{
    public $id_candidato, $id_aplicacion, $etapas;
    public $etapas_array = [['id_etapa' => '', 'etapa' => '', 'fecha_inicio' => '', 'fecha_fin' => '']];
    #[Layout('layouts.apptl')]
    public function render()
    {
        return view('livewire.candidatos.etapas-procesos');
    }

    public function comprobarEtapas()
    {
        $etapas = EtapaProceso::select('id', 'etapa')->get()->toArray();
        $registro_etapas = EtapaAplicacion::select('id', 'fecha_inicio', 'fecha_fin', 'etapas_procesos_id')
            ->where('aplicaciones_candidatos_id', $this->id_aplicacion)
            ->get();

        foreach ($etapas as $e) {
            $this->etapas_array[] = [
                'id_etapa' => $e['id'],
                'etapa' => $e['etapa'],
                'fecha_inicio' => null,
                'fecha_fin' => null
            ];
        }
        foreach ($registro_etapas as $paso) {
            foreach ($this->etapas_array as $key => $etapa) {
                if ($etapa['id_etapa'] == $paso->etapas_procesos_id) {
                    $this->etapas_array[$key]['fecha_inicio'] = $paso->fecha_inicio;
                    $this->etapas_array[$key]['fecha_fin'] = $paso->fecha_fin;
                    break;
                }
            }
        }
    }

    public function mount($id_candidato)
    {
        $this->id_candidato = $id_candidato;
        $aplicacion = AplicacionCandidato::where('candidatos_id', $id_candidato)->first();
        $this->id_aplicacion = $aplicacion->id;
        $this->comprobarEtapas();
    }
}
