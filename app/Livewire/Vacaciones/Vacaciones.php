<?php

namespace App\Livewire\Vacaciones;

use App\Models\Empleado;
use Livewire\Component;
use Livewire\WithPagination;

class Vacaciones extends Component
{
    use WithPagination;

    /* Búsqueda */
    public $busqueda, $filtro;
    public function render()
    {
        $empleados = Empleado::select(
            'empleados.id as id',
            'empleados.codigo as codigo',
            'empleados.imagen as imagen',
            'empleados.nombres as nombres',
            'empleados.apellidos as apellidos',
            'dependencias_nominales.dependencia as dependencia',
        )
            ->join('contratos', 'empleados.id', '=', 'contratos.empleados_id')
            ->join('puestos_nominales', 'contratos.puestos_nominales_id', '=', 'puestos_nominales.id')
            ->join('renglones', 'puestos_nominales.renglones_id', '=', 'renglones.id')
            ->join('dependencias_nominales', 'puestos_nominales.dependencias_nominales_id', '=', 'dependencias_nominales.id')
            ->join('vacaciones_disponibles', 'empleados.id', '=', 'vacaciones_disponibles.empleados_id')
            ->where('empleados.estado', 1)
            ->where('renglones.renglon', 'NOT LIKE', '029')
            ->where('contratos.vigente', 1);
        if (!empty($this->filtro)) {
            $empleados->where(function ($query) {
                $query->where('codigo', 'LIKE', '%' . $this->filtro . '%')
                    ->orWhere('nombres', 'LIKE', '%' . $this->filtro . '%')
                    ->orWhere('apellidos', 'LIKE', '%' . $this->filtro . '%')
                    ->orWhere('dependencia', 'LIKE', '%' . $this->filtro . '%');
            });
        }
        $empleados = $empleados->groupBy('empleados.id')->paginate(5);

        activity()
            ->causedBy(auth()->user())
            ->withProperties(['user_id' => auth()->id()])
            ->log("El usuario " . auth()->user()->name .  " visitó la página: " . request()->path());
        return view('livewire.vacaciones.vacaciones', [
            'empleados' => $empleados
        ]);
    }
}
