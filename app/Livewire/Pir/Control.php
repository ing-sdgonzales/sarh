<?php

namespace App\Livewire\Pir;

use App\Models\PirDireccion;
use Exception;
use Livewire\Component;
use Livewire\WithPagination;
use Symfony\Component\CssSelector\Node\FunctionNode;

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
            'hora_actualizacion'
        );
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
            $direccion = PirDireccion::findOrFail($this->id_direccion);
            $direccion->habilitado = 1;
            $direccion->save();
            
            session()->flash('message');
            $this->cerrarModal();
            activity()
                ->causedBy(auth()->user())
                ->withProperties(['user_id' => auth()->id()])
                ->log("El usuario " . auth()->user()->name . " habilitó el registro de: " . $direccion->direccion . " para actualizar el formulario PIR.");
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
