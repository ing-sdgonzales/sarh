<?php

namespace App\Livewire\Renglones;

use App\Models\Renglon as ModelsRenglon;
use Exception;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class Renglon extends Component
{
    use WithPagination;

    public $id_renglon, $renglon, $nombre, $asignado, $modificaciones, $vigente, $pre_comprometido, $comprometido, $devengado, $pagado,
        $saldo_por_comprometer, $saldo_por_devengar, $saldo_por_pagar, $tipo;
    public $modal = false, $modo_edicion = false;
    public $busqueda, $filtro;
    public function render()
    {
        $renglones = ModelsRenglon::query();

        if (!empty($this->filtro)) {
            $renglones->where('renglon', 'LIKE', '%' . $this->filtro . '%');
        }

        return view('livewire.renglones.renglon', [
            'renglones' => $renglones->paginate(7)
        ]);
    }

    public function guardar()
    {
        $validated = $this->validate([
            'renglon' => ['required', 'string', 'size:3', Rule::unique('renglones', 'renglon')->ignore($this->id_renglon)],
            'nombre' => 'required|filled|regex:/^[A-Za-záàéèíìóòúùÁÀÉÈÍÌÓÒÚÙüÜñÑ\s.-]+$/u',
            'asignado' => 'required|decimal:2|numeric',
            'modificaciones' => 'required|decimal:2|numeric',
            'vigente' => 'required|decimal:2|numeric',
            'pre_comprometido' => 'required|decimal:2|numeric',
            'comprometido' => 'required|decimal:2|numeric',
            'devengado' => 'required|decimal:2|numeric',
            'pagado' => 'required|decimal:2|numeric',
            'saldo_por_comprometer' => 'required|decimal:2|numeric',
            'saldo_por_devengar' => 'required|decimal:2|numeric',
            'saldo_por_pagar' => 'required|decimal:2|numeric',
        ]);

        try {
            ModelsRenglon::updateOrCreate(['id' => $this->id_renglon], [
                'renglon' => $validated['renglon'],
                'nombre' => $validated['nombre'],
                'asignado' => $validated['asignado'],
                'modificaciones' => $validated['modificaciones'],
                'vigente' => $validated['vigente'],
                'pre_comprometido' => $validated['pre_comprometido'],
                'comprometido' => $validated['comprometido'],
                'devengado' => $validated['devengado'],
                'pagado' => $validated['pagado'],
                'saldo_por_comprometer' => $validated['saldo_por_comprometer'],
                'saldo_por_devengar' => $validated['saldo_por_devengar'],
                'saldo_por_pagar' => $validated['saldo_por_pagar']
            ]);
            session()->flash('message');
            $status = $this->modo_edicion ? ' actualizó' : ' guardó';
            activity()
                ->causedBy(auth()->user())
                ->withProperties(['user_id' => auth()->id()])
                ->log("El usuario " . auth()->user()->name . $status . " el renglón: " . $this->renglon);
            $this->cerrarModal();
            return redirect()->route('renglones');
        } catch (Exception $e) {
            $errorMessages = "Ocurrió un error: " . $e->getMessage();
            session()->flash('error', $errorMessages);
            $this->cerrarModal();
            return redirect()->route('renglones');
        }
    }

    public function editar($id)
    {
        $this->id_renglon = $id;
        $renglon = ModelsRenglon::findOrFail($this->id_renglon);
        if ($renglon) {
            $this->renglon = $renglon->renglon;
            $this->nombre = $renglon->nombre;
            $this->asignado = $renglon->asignado;
            $this->modificaciones = $renglon->modificaciones;
            $this->vigente = $renglon->vigente;
            $this->pre_comprometido = $renglon->pre_comprometido;
            $this->comprometido = $renglon->comprometido;
            $this->devengado = $renglon->devengado;
            $this->pagado = $renglon->pagado;
            $this->saldo_por_comprometer = $renglon->saldo_por_comprometer;
            $this->saldo_por_devengar = $renglon->saldo_por_devengar;
            $this->saldo_por_pagar = $renglon->saldo_por_pagar;
        }
        $this->modal = true;
        $this->modo_edicion = true;
    }

    public function cerrarModal()
    {
        $this->reset();
    }

    public function updatedBusqueda()
    {
        $this->filtro = $this->busqueda;
    }
}
