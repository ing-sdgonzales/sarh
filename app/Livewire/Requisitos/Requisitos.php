<?php

namespace App\Livewire\Requisitos;

use App\Models\Requisito;
use ErrorException;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Requisitos extends Component
{
    public $id_requisito, $requisito, $especificacion;
    public $modal = false, $modo_edicion = false;
    public function render()
    {
        activity()
            ->causedBy(auth()->user())
            ->withProperties(['user_id' => auth()->id()])
            ->log("El usuario " . auth()->user()->name .  " visitó la página: " . request()->path());
        return view('livewire.requisitos.requisitos', [
            'requisitos' => DB::table('requisitos')->paginate(10)
        ]);
    }

    public function guardar()
    {
        $validated = $this->validate([
            'requisito' => 'required|filled|regex:/^[A-Za-záàéèíìóòúùÁÀÉÈÍÌÓÒÚÙüÜñÑ\s.:;¡¿,!?]+$/u',
            'especificacion' => 'required|filled|regex:/^[A-Za-záàéèíìóòúùÁÀÉÈÍÌÓÒÚÙüÜñÑ\s.:;¡¿,!?]+$/u'
        ]);

        try {
            Requisito::updateOrCreate(['id' => $this->id_requisito], [
                'requisito' => $validated['requisito'],
                'especificacion' => $validated['especificacion']
            ]);
            activity()
                ->causedBy(auth()->user())
                ->withProperties(['user_id' => auth()->id()])
                ->log("El usuario " . auth()->user()->name . " guardó el requisito: " . $this->requisito);
            session()->flash('message');
            $this->cerrarModal();
            return redirect()->route('requisitos');
        } catch (ErrorException $e) {
            $errorMessages = "Ocurrió un error: " . $e->getMessage();
            session()->flash('error', $errorMessages);
            return redirect()->route('requisito');
        }
    }

    public function editar($id_requisito)
    {
        $this->id_requisito = $id_requisito;

        $requisito = Requisito::select(
            'requisito',
            'especificacion'
        )
            ->where('id', $id_requisito)
            ->first();
        $this->requisito = $requisito->requisito;
        $this->especificacion = $requisito->especificacion;

        $this->modo_edicion = true;
        $this->modal = true;
    }

    public function crear()
    {
        $this->modal = true;
    }

    public function cerrarModal()
    {
        $this->modal = false;
        $this->modo_edicion = false;
        $this->requisito = '';
        $this->especificacion = '';
    }
}
