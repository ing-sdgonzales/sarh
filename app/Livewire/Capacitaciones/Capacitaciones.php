<?php

namespace App\Livewire\Capacitaciones;

use App\Models\Capacitacion;
use App\Models\DependenciaNominal;
use Exception;
use Livewire\Component;
use Livewire\WithPagination;

class Capacitaciones extends Component
{
    use WithPagination;

    /* Colecciones */
    public $dependencias_nominales;

    public $id_capacitacion, $busqueda, $query;

    /* Variables modal crear y editar */
    public $modal = false, $modo_edicion = false;
    public $capacitacion, $origen, $organizador, $capacitador;

    public function render()
    {
        $this->dependencias_nominales = DependenciaNominal::select('id', 'dependencia')->get();

        $capacitaciones = Capacitacion::select(
            'capacitaciones.id as id',
            'capacitaciones.capacitacion as capacitacion',
            'capacitaciones.origen as origen',
            'capacitaciones.capacitador as capacitador',
            'dependencias_nominales.dependencia as organizador'
        )
            ->join('dependencias_nominales', 'capacitaciones.dependencias_nominales_id', '=', 'dependencias_nominales.id');

        $capacitaciones = $capacitaciones->paginate(5);

        if (!empty($this->query)) {
            $capacitaciones->where(function ($query) {
                $query->where('capacitacion', 'LIKE', '%' . $this->query . '%')
                    ->orWhere('capacitador', 'LIKE', '%' . $this->query . '%')
                    ->orWhere('organizador', 'LIKE', '%' . $this->query . '%');
            });
        }
        activity()
            ->causedBy(auth()->user())
            ->withProperties(['user_id' => auth()->id()])
            ->log("El usuario " . auth()->user()->name .  " visitó la página: " . request()->path());
        return view('livewire.capacitaciones.capacitaciones', [
            'capacitaciones' => $capacitaciones
        ]);
    }

    public function guardar()
    {
        try {
            $validated = $this->validate([
                'capacitacion' => ['required', 'filled', 'regex:/^[\d]+(?:\.\d{1,2})?|[A-Za-záéíóúÁÉÍÓÚüÜñÑ\s.:;,-]+$/u'],
                'origen' => ['nullable', 'regex:/^[\d]+(?:\.\d{1,2})?|[A-Za-záéíóúÁÉÍÓÚüÜñÑ\s.:;,-]+$/u'],
                'capacitador' => 'required|filled|regex:/^[A-Za-záéíóúÁÉÍÓÚüÜñÑ\s.:;,-]+$/u',
                'organizador' => 'required|integer|min:1'
            ]);

            Capacitacion::updateOrCreate(['id' => $this->id_capacitacion], [
                'capacitacion' => $validated['capacitacion'],
                'origen' => $validated['origen'],
                'capacitador' => $validated['capacitador'],
                'dependencias_nominales_id' => $validated['organizador']
            ]);

            session()->flash('message');
            $this->cerrarModal();
            activity()
                ->causedBy(auth()->user())
                ->withProperties(['user_id' => auth()->id()])
                ->log("El usuario " . auth()->user()->name . " guardó la capacitación: " . $this->capacitacion);
            return redirect()->route('capacitaciones');
        } catch (Exception $e) {
            $errorMessages = "Ocurrió un error: " . $e->getMessage();
            session()->flash('error', $errorMessages);
            $this->cerrarModal();
            return redirect()->route('capacitaciones');
        }
    }

    public function editar($id)
    {
        $this->id_capacitacion = $id;
        $capacitacion = Capacitacion::findOrFail($id);
        $this->capacitacion = $capacitacion->capacitacion;
        $this->origen = $capacitacion->origen;
        $this->capacitador = $capacitacion->capacitador;
        $this->organizador = $capacitacion->dependencias_nominales_id;
        $this->modo_edicion = true;
        $this->modal = true;
    }

    public function crear()
    {
        $this->modal = true;
    }

    public function updatedBusqueda()
    {
        $this->query = $this->busqueda;
    }

    public function cerrarModal()
    {
        $this->modal = false;
        $this->modo_edicion = false;
        $this->id_capacitacion = '';
        $this->capacitacion = '';
        $this->origen = '';
        $this->capacitador = '';
        $this->organizador = '';
    }
}
