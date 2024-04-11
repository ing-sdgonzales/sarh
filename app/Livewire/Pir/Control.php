<?php

namespace App\Livewire\Pir;

use App\Models\PirDireccion;
use Livewire\Component;
use Livewire\WithPagination;

class Control extends Component
{
    use WithPagination;

    public $busqueda, $filtro;
    public function render()
    {
        $direcciones = PirDireccion::select(
            'direccion',
            'hora_actualizacion'
        );
        if (!empty($this->filtro)) {
            $direcciones->where('direccion', 'NOT LIKE', '%' . $this->filtro . '%');
        }
        return view('livewire.pir.control', [
            'direcciones' => $direcciones->paginate(10)
        ]);
    }

    public function updatedBusqueda()
    {
        $this->filtro = $this->busqueda;
    }
}
