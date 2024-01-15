<?php

namespace App\Livewire\Capacitaciones;

use App\Models\Capacitacion;
use App\Models\CapacitacionEmpleado;
use App\Models\DependenciaNominal;
use App\Models\Empleado;
use App\Models\SesionCapacitacion;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Sesiones extends Component
{
    public $id_capacitacion, $filtro, $query, $participantes_actuales;

    /* Colecciones */
    public $dependencias_nominales;

    /* Variables modal crear y editar */
    public $modal = false;
    public $fecha, $hora_inicio, $hora_fin, $ubicacion, $participante = [], $dependencia_nominal, $busqueda_empleado,
        $id_sesion, $marcador_dependencia = [], $marcador = false;

    public function render()
    {
        $this->dependencias_nominales = DependenciaNominal::select('id', 'dependencia')->get();
        $empleados = Empleado::select(
            'empleados.id as id',
            'empleados.nombres as nombres',
            'empleados.apellidos as apellidos'
        )
            ->join('contratos', 'empleados.id', '=', 'contratos.empleados_id')
            ->join('puestos_nominales', 'contratos.puestos_nominales_id', '=', 'puestos_nominales.id')
            ->where('contratos.vigente', 1);

        if (!empty($this->filtro)) {
            $empleados->where('puestos_nominales.dependencias_nominales_id', $this->filtro);
        }

        if (!empty($this->busqueda_empleado)) {
            $empleados->where(function ($query) {
                $query->where('empleados.nombres', 'LIKE', '%' . $this->query . '%')
                    ->orWhere('empleados.nombres', 'LIKE', '%' . $this->query . '%');
            });
        }

        $empleados = $empleados->paginate(7, pageName: 'empleados');

        $sesiones = SesionCapacitacion::select(
            'sesiones_capacitaciones.id as id',
            'sesiones_capacitaciones.fecha as fecha',
            'sesiones_capacitaciones.hora_inicio as hora_inicio',
            'sesiones_capacitaciones.hora_fin as hora_fin',
            'sesiones_capacitaciones.ubicacion as ubicacion',
            DB::raw('(SELECT COUNT(*) FROM capacitaciones_empleados WHERE sesiones_capacitaciones_id = sesiones_capacitaciones.id) as total_participantes')
        )
            ->where('sesiones_capacitaciones.capacitaciones_id', $this->id_capacitacion);

        $sesiones = $sesiones->paginate(7, pageName: 'sesiones');

        activity()
            ->causedBy(auth()->user())
            ->withProperties(['user_id' => auth()->id()])
            ->log("El usuario " . auth()->user()->name .  " visitó la página: " . request()->path());
        return view('livewire.capacitaciones.sesiones.sesiones', [
            'sesiones' => $sesiones,
            'empleados' => $empleados
        ]);
    }

    public function guardar()
    {
        try {
            $this->hora_inicio = Carbon::parse($this->hora_inicio)->format('H:i');
            $this->hora_fin = Carbon::parse($this->hora_fin)->format('H:i');
            $validated = $this->validate([
                'fecha' => 'required|date',
                'hora_inicio'  => 'required|date_format:H:i',
                'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
                'ubicacion' => 'required|filled'
            ]);

            DB::transaction(function () use ($validated) {
                $sesion = SesionCapacitacion::updateOrCreate(['id' => $this->id_sesion], [
                    'fecha' => $validated['fecha'],
                    'hora_inicio' => $validated['hora_inicio'],
                    'hora_fin' => $validated['hora_fin'],
                    'ubicacion' => $validated['ubicacion'],
                    'capacitaciones_id' => $this->id_capacitacion
                ]);

                if (!empty($this->participantes_actuales)) {
                    $participantes_eliminados = array_diff($this->participantes_actuales, $this->participante);
                }

                if (!empty($participantes_eliminados)) {
                    CapacitacionEmpleado::where('sesiones_capacitaciones_id', $this->id_sesion)
                        ->whereIn('empleados_id', $participantes_eliminados)
                        ->delete();
                }

                if (!empty($this->participante)) {
                    foreach ($this->participante as $participante) {
                        CapacitacionEmpleado::create([
                            'empleados_id' => $participante,
                            'sesiones_capacitaciones_id' => $sesion->id
                        ]);
                    }
                }
            });
            $capacitacion = Capacitacion::findOrFail($this->id_capacitacion);
            session()->flash('message');
            $this->cerrarModal();
            activity()
                ->causedBy(auth()->user())
                ->withProperties(['user_id' => auth()->id()])
                ->log("El usuario " . auth()->user()->name . " guardó una sesión a la capacitación: " . $capacitacion->capacitacion);
            return redirect()->route('sesiones', ['id_capacitacion' => $this->id_capacitacion]);
        } catch (Exception $e) {
            $errorMessages = "Ocurrió un error: " . $e->getMessage();
            session()->flash('error', $errorMessages);
            $this->cerrarModal();
            return redirect()->route('sesiones', ['id_capacitacion' => $this->id_capacitacion]);
        }
    }

    public function editar($id_sesion)
    {
        $this->id_sesion = $id_sesion;
        $sesion = SesionCapacitacion::findOrFail($this->id_sesion);
        $this->fecha = $sesion->fecha;
        $this->hora_inicio = $sesion->hora_inicio;
        $this->hora_fin = $sesion->hora_fin;
        $this->ubicacion = $sesion->ubicacion;
        $participantes = CapacitacionEmpleado::select('empleados_id')->where('sesiones_capacitaciones_id', $this->id_sesion)->get();
        foreach ($participantes as $participante) {
            $this->participante[] = $participante->empleados_id;
        }
        $this->participantes_actuales = $this->participante;
        $this->modal = true;
    }

    public function getEmpleadosByDependencia()
    {
        if ($this->dependencia_nominal) {
            $this->filtro = $this->dependencia_nominal;
            $this->marcador_dependencia[$this->filtro] = false;
        } else {
            $this->filtro = '';
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

    public function updatedBusquedaEmpleado()
    {
        $this->query = $this->busqueda_empleado;
    }

    public function crear()
    {
        $this->modal = true;
    }

    public function cerrarModal()
    {
        $this->modal = false;
        $this->fecha = '';
        $this->hora_inicio = '';
        $this->hora_fin = '';
        $this->ubicacion = '';
        $this->dependencia_nominal = '';
        $this->participante = [];
        $this->participantes_actuales = [];
        $this->busqueda_empleado = '';
    }

    public function mount($id_capacitacion)
    {
        $this->id_capacitacion = $id_capacitacion;
    }
}
