<?php

namespace App\Livewire\Clinica;

use App\Models\Empleado;
use Livewire\Component;
use Livewire\WithPagination;

class Historial extends Component
{
    use WithPagination;

    public $busqueda, $filtro;

    public function render()
    {
        $empleados = Empleado::select(
            'empleados.id as id',
            'empleados.imagen as imagen',
            'empleados.nombres as nombres',
            'empleados.apellidos as apellidos',
            'renglones.renglon as renglon',
            'contratos.vigente as vigente',
            'dependencias_nominales.dependencia as dependencia'
        )
            ->selectRaw('TIMESTAMPDIFF(YEAR, empleados.fecha_nacimiento, CURDATE()) as edad')
            ->join('contratos', 'empleados.id', '=', 'contratos.empleados_id')
            ->join('puestos_nominales', 'contratos.puestos_nominales_id', '=', 'puestos_nominales.id')
            ->join('renglones', 'puestos_nominales.renglones_id', '=', 'renglones.id')
            ->join('dependencias_nominales', 'puestos_nominales.dependencias_nominales_id', '=', 'dependencias_nominales.id');
        if (!empty($this->filtro)) {
            $empleados->where(function ($query) {
                $query->where('nombres', 'LIKE', '%' . $this->filtro . '%')
                    ->orWhere('apellidos', 'LIKE', '%' . $this->filtro . '%')
                    ->orWhere('renglon', 'LIKE', '%' . $this->filtro . '%')
                    ->orWhere('dependencia', 'LIKE', '%' . $this->filtro . '%');
            });
        }
        $empleados = $empleados->paginate(5);
        activity()
            ->causedBy(auth()->user())
            ->withProperties(['user_id' => auth()->id()])
            ->log("El usuario " . auth()->user()->name .  " visitó la página: " . request()->path());
        return view('livewire.clinica.historial', [
            'empleados' => $empleados
        ]);
    }

    public function updatedBusqueda()
    {
        $this->filtro = $this->busqueda;
    }
}
