<?php

namespace App\Livewire\Conred;

use App\Models\PuestoNominal;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class Postularse extends Component
{
    use WithPagination;
    #[Layout('layouts.app2')]
    public function render()
    {
        $vacantes = PuestoNominal::select(
            'puestos_nominales.id as id_puesto',
            'catalogo_puestos.puesto as puesto',
            'renglones.renglon as renglon'
        )
            ->join('catalogo_puestos', 'puestos_nominales.catalogo_puestos_id', '=', 'catalogo_puestos.id')
            ->join('renglones', 'puestos_nominales.renglones_id', '=', 'renglones.id')
            ->where('puestos_nominales.activo', 1);

        return view('livewire.conred.postularse', [
            'vacantes' => $vacantes->paginate(10)
        ]);
    }
}
