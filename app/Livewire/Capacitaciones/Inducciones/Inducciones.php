<?php

namespace App\Livewire\Capacitaciones\Inducciones;

use App\Models\Capacitacion;
use App\Models\CapacitacionEmpleado;
use App\Models\Empleado;
use App\Models\InduccionPendiente;
use App\Models\SesionCapacitacion;
use Exception;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Inducciones extends Component
{
    use WithPagination;

    /* Colecciones */
    public $capacitaciones, $sesiones;

    /* Barra de búsqueda */
    public $busqueda, $filtro;
    public $participante = [], $marcador = false, $marcador_dependencia = [];

    /* Modal asignar empleados a inducción */
    public $modal = false;
    public $capacitacion, $sesion;

    public function render()
    {
        $this->capacitaciones = Capacitacion::select('id', 'capacitacion')
            ->whereRaw('LOWER(capacitacion) LIKE ?', ['%' . strtolower('inducción') . '%'])
            ->orWhere(function ($query) {
                $query->whereRaw('LOWER(capacitacion) LIKE ?', ['%' . strtolower('induccion') . '%']);
            })
            ->get();

        $empleados = Empleado::select(
            'empleados.id as id',
            'empleados.imagen as imagen',
            'empleados.nombres as nombres',
            'empleados.apellidos as apellidos',
            'dependencias_nominales.dependencia as dependencia'
        )
            ->join('inducciones_pendientes', 'empleados.id', '=', 'inducciones_pendientes.empleados_id')
            ->join('contratos', 'empleados.id', '=', 'contratos.empleados_id')
            ->join('puestos_nominales', 'contratos.puestos_nominales_id', '=', 'puestos_nominales.id')
            ->join('dependencias_nominales', 'puestos_nominales.dependencias_nominales_id', '=', 'dependencias_nominales.id')
            ->where('contratos.vigente', 1)
            ->where('inducciones_pendientes.pendiente', 1);

        if (!empty($this->filtro)) {
            $empleados->where(function ($query) {
                $query->where('nombres', 'LIKE', '%' . $this->filtro . '%')
                    ->orWhere('apellidos', 'LIKE', '%' . $this->filtro . '%')
                    ->orWhere('dependencia', 'LIKE', '%' . $this->filtro . '%');
            });
        }

        $empleados->orderBy('inducciones_pendientes.created_at', 'asc');
        $empleados = $empleados->paginate(5);

        activity()
            ->causedBy(auth()->user())
            ->withProperties(['user_id' => auth()->id()])
            ->log("El usuario " . auth()->user()->name .  " visitó la página: " . request()->path());
        return view('livewire.capacitaciones.inducciones.inducciones', [
            'empleados' => $empleados
        ]);
    }

    public function guardar()
    {
        try {
            DB::transaction(function () {
                foreach ($this->participante as $participante) {
                    CapacitacionEmpleado::create([
                        'empleados_id' => $participante,
                        'sesiones_capacitaciones_id' => $this->sesion
                    ]);

                    InduccionPendiente::where('empleados_id', $participante)->update([
                        'pendiente' => 0
                    ]);
                }
            });
            $capacitacion = Capacitacion::findOrFail($this->capacitacion);
            session()->flash('message');
            $this->cerrarModal();
            activity()
                ->causedBy(auth()->user())
                ->withProperties(['user_id' => auth()->id()])
                ->log("El usuario " . auth()->user()->name . " asignó empleados a la capacitación: " . $capacitacion->capacitacion . ".");
            return redirect()->route('inducciones');
        } catch (Exception $e) {
            $errorMessages = "Ocurrió un error: " . $e->getMessage();
            session()->flash('error', $errorMessages);
            $this->cerrarModal();
            return redirect()->route('inducciones');
        }
    }

    public function getSesionesByCapacitacion()
    {
        if (!empty($this->capacitacion)) {
            $this->sesiones = SesionCapacitacion::select(
                'id',
                'fecha',
                'hora_inicio',
            )
                ->where('capacitaciones_id', $this->capacitacion)->orderBy('fecha', 'asc')
                ->get();
        }
    }

    public function marcarEmpleados()
    {
        if (!empty($this->filtro)) {
            $empleados = Empleado::select(
                'empleados.id as id'
            )
                ->join('contratos', 'empleados.id', '=', 'contratos.empleados_id')
                ->join('puestos_nominales', 'contratos.puestos_nominales_id', '=', 'puestos_nominales.id')
                ->where('contratos.vigente', 1)
                ->where('puestos_nominales.dependencias_nominales_id', $this->filtro)
                ->get();
            foreach ($empleados as $empleado) {
                if (!in_array($empleado->id, $this->participante)) {
                    $this->participante[] = $empleado->id;
                }
            }
            $this->marcador_dependencia[$this->filtro] = true;
        } else {
            $empleados = Empleado::select(
                'empleados.id as id'
            )
                ->join('contratos', 'empleados.id', '=', 'contratos.empleados_id')
                ->join('puestos_nominales', 'contratos.puestos_nominales_id', '=', 'puestos_nominales.id')
                ->where('contratos.vigente', 1)
                ->get();
            foreach ($empleados as $empleado) {
                if (!in_array($empleado->id, $this->participante)) {
                    $this->participante[] = $empleado->id;
                }
            }
            $this->marcador = true;
        }
    }

    public function desmarcarEmpleados()
    {
        if (!empty($this->filtro)) {
            $empleados = Empleado::select('empleados.id as id')
                ->join('contratos', 'empleados.id', '=', 'contratos.empleados_id')
                ->join('puestos_nominales', 'contratos.puestos_nominales_id', '=', 'puestos_nominales.id')
                ->where('contratos.vigente', 1)
                ->where('puestos_nominales.dependencias_nominales_id', $this->filtro)
                ->get();

            foreach ($empleados as $empleado) {
                $key = array_search($empleado->id, $this->participante);
                if ($key !== false) {
                    unset($this->participante[$key]);
                }
            }

            if (empty($this->participante)) {
                $this->marcador_dependencia[$this->filtro] = false;
            }
        } else {
            $this->participante = [];

            $this->marcador = false;
        }
    }

    public function updatedBusqueda()
    {
        $this->filtro = $this->busqueda;
    }

    public function crear()
    {
        if (!empty($this->participante)) {
            $this->modal = true;
        } else {
            $this->dispatch('sinParticipantesAlert', ['message' => 'Debe seleccionar uno o varios empleados para realizar esta acción.']);
        }
    }

    public function cerrarModal()
    {
        $this->modal = false;
        $this->capacitacion = '';
        $this->sesion = '';
    }
}
