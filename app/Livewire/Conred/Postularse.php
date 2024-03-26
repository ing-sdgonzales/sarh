<?php

namespace App\Livewire\Conred;

use App\Models\PuestoNominal;
use Illuminate\Support\Facades\DB;
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
            'renglones.renglon as renglon',
            'perfiles.descripcion as descripcion',
            'perfiles.experiencia as experiencia',
            'perfiles.estudios as estudios',
            'registros_academicos.nivel as nivel_academico'
        )
            ->join('catalogo_puestos', 'puestos_nominales.catalogo_puestos_id', '=', 'catalogo_puestos.id')
            ->join('renglones', 'puestos_nominales.renglones_id', '=', 'renglones.id')
            ->join('perfiles', 'puestos_nominales.id', '=', 'perfiles.puestos_nominales_id')
            ->join('registros_academicos', 'perfiles.registros_academicos_id', '=', 'registros_academicos.id')
            ->where('puestos_nominales.activo', 1)
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('requisitos_puestos')
                    ->whereRaw('requisitos_puestos.puestos_nominales_id = puestos_nominales.id');
            })
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('perfiles')
                    ->whereRaw('perfiles.puestos_nominales_id = puestos_nominales.id');
            });

        return view('livewire.conred.postularse', [
            'vacantes' => $vacantes->paginate(10)
        ]);
    }
}
