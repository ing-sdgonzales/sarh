<?php

namespace App\Livewire\Puestos;

use App\Models\PuestoNominal;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ListarPuestos extends Component
{
    public $modal = false;
    public $codigo;
    public function render()
    {
        $puestos_list =  DB::table('puestos_nominales')
            ->join('renglones', 'puestos_nominales.renglones_id', '=', 'renglones.id')
            ->select(
                'puestos_nominales.id as id',
                'puestos_nominales.codigo as codigo',
                'puestos_nominales.partida_presupuestaria as partida_presupuestaria', 
                'puestos_nominales.estado',
                'renglones.renglon'
            )->get();
        return view('livewire.puestos.listar-puestos', [
            'puestos' => $puestos_list
        ]);
    }

    public function crear(){

    }

    public function abrirModal(){
        $this->modal = true;
    }

    public function editar($id){
        $puesto = PuestoNominal::findOrFail($id);
        $this->codigo =  $puesto->codigo;
        $this->abrirModal();
    }
}
