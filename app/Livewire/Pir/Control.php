<?php

namespace App\Livewire\Pir;

use App\Models\PirDireccion;
use App\Models\PirSolicitud;
use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Control extends Component
{
    use WithPagination;

    public $busqueda, $filtro;
    public $modal = false, $id_direccion, $habilitado;

    public function render()
    {
        $direcciones = PirDireccion::select(
            'id',
            'direccion',
            'hora_actualizacion',
            'habilitado',
            DB::raw('(SELECT COUNT(*) FROM pir_solicitudes WHERE pir_solicitudes.pir_direccion_id = pir_direcciones.id AND pir_solicitudes.aprobada = 0) AS cantidad_solicitudes')
        )
            ->orderBy('cantidad_solicitudes', 'desc');

        if (!empty($this->filtro)) {
            $direcciones->where('direccion', 'LIKE', '%' . $this->filtro . '%');
        }
        return view('livewire.pir.control', [
            'direcciones' => $direcciones->paginate(10)
        ]);
    }

    public function habilitarDir()
    {
        try {
            DB::transaction(function () {
                $direccion = PirDireccion::findOrFail($this->id_direccion);
                $direccion->habilitado = 1;
                $direccion->save();

                $solicitud = PirSolicitud::where('pir_direccion_id', $this->id_direccion);
                $solicitud->update(['aprobada' => 1]);

                activity()
                    ->causedBy(auth()->user())
                    ->withProperties(['user_id' => auth()->id()])
                    ->log("El usuario " . auth()->user()->name . " habilitó el registro de: " . $direccion->direccion . " para actualizar el formulario PIR.");
            });
            session()->flash('message');
            $this->cerrarModal();
            return redirect()->route('control_pir');
        } catch (Exception $e) {
            $errorMessages = "Ocurrió un error: " . $e->getMessage();
            session()->flash('error', $errorMessages);
            $this->cerrarModal();
            return redirect()->route('control_pir');
        }
    }

    public function habilitar($id)
    {
        $this->id_direccion = $id;
        $direccion = PirDireccion::findOrFail($id);
        $this->habilitado = $direccion->habilitado;
        $this->modal = true;
    }

    public function updatedBusqueda()
    {
        $this->filtro = $this->busqueda;
    }

    public function cerrarModal()
    {
        $this->reset();
    }
}
