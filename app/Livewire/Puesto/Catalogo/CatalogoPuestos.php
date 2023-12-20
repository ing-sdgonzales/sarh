<?php

namespace App\Livewire\Puesto\Catalogo;

use App\Models\CatalogoPuesto;
use Livewire\WithPagination;
use App\Models\Renglon;
use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class CatalogoPuestos extends Component
{
    use WithPagination;

    /* Collecciones */
    public $renglones;

    public $renglon_filtro, $filtro;

    /* Variables modal crear y editar */
    public $modal = false;
    public $id_puesto, $codigo, $puesto, $cantidad, $renglon;

    public function render()
    {
        $this->renglones = Renglon::select('id', 'renglon', 'nombre')->where('tipo', '=', 0)->get();
        $puestos = CatalogoPuesto::select(
            'catalogo_puestos.id as id',
            'catalogo_puestos.codigo as codigo',
            'catalogo_puestos.puesto as puesto',
            'catalogo_puestos.cantidad as cantidad',
            'renglones.renglon as renglon'
        )
            ->join('renglones', 'catalogo_puestos.renglones_id', '=', 'renglones.id');
        if (!empty($this->filtro)) {
            $puestos->where('catalogo_puestos.renglones_id', '=', $this->filtro);
        }

        $puestos = $puestos->paginate(10);

        activity()
            ->causedBy(auth()->user())
            ->withProperties(['user_id' => auth()->id()])
            ->log("El usuario " . auth()->user()->name .  " visitó la página: " . request()->path());
        return view('livewire.puesto.catalogo.catalogo-puestos', [
            'puestos' => $puestos
        ]);
    }

    public function guardar()
    {
        try {
            $validated = $this->validate([
                'codigo' => 'required|filled|string',
                'renglon' => 'required|integer|min:1',
                'puesto' => 'required|filled|regex:/^[A-Za-záàéèíìóòúùÁÀÉÈÍÌÓÒÚÙüÜñÑ\s.-]+$/u',
                'cantidad' => 'required|integer|min:0'
            ]);
            DB::transaction(function () use ($validated) {
                CatalogoPuesto::updateOrCreate(['id' => $this->id_puesto], [
                    'codigo' => $validated['codigo'],
                    'renglones_id' => $validated['renglon'],
                    'puesto' => $validated['puesto'],
                    'cantidad' => $validated['cantidad']
                ]);
            });
            session()->flash('message');
            $this->cerrarModal();
            activity()
                ->causedBy(auth()->user())
                ->withProperties(['user_id' => auth()->id()])
                ->log("El usuario " . auth()->user()->name . " guardó el puesto: " . $this->codigo . '-' . $this->puesto);
            return redirect()->route('catalogo_puestos');
        } catch (Exception $e) {
            $errorMessages = "Ocurrió un error: " . $e->getMessage();
            session()->flash('error', $errorMessages);
            $this->cerrarModal();
            return redirect()->route('catalogo_puestos');
        }
    }

    public function editar($id_puesto)
    {
        $this->id_puesto = $id_puesto;
        $puesto = CatalogoPuesto::findOrFail($id_puesto);
        $this->codigo = $puesto->codigo;
        $this->cantidad = $puesto->cantidad;
        $this->renglon = $puesto->renglones_id;
        $this->puesto = $puesto->puesto;

        $this->modal = true;
    }

    public function getPuestosByRenglon()
    {
        $this->filtro = $this->renglon_filtro;
    }

    public function crear()
    {
        $this->modal = true;
    }

    public function cerrarModal()
    {
        $this->id_puesto = '';
        $this->codigo = '';
        $this->renglon = '';
        $this->puesto = '';
        $this->cantidad = '';
        $this->modal = false;
    }
}
