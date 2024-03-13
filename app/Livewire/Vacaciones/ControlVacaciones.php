<?php

namespace App\Livewire\Vacaciones;

use App\Models\Empleado;
use App\Models\SolicitudVacacion;
use App\Models\VacacionDisponible;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ControlVacaciones extends Component
{
    public $id_empleado;
    public $validacion = [
        ['val' => 0, 'res' => 'No aprobada'],
        ['val' => 1, 'res' => 'Pendiente'],
        ['val' => 2, 'res' => 'Aprobada']
    ];

    /* Colecciones */
    public $dias_disponibles;

    /* Modal Crear y Editar */
    public $modal = false;
    public $id_solicitud, $fecha_salida, $fecha_ingreso, $periodo, $duracion, $duracion_int, $observacion,
        $fecha_min, $fecha_max, $mostrar_observacion = true;

    /* Modal Editar Días de Vacaciones */
    public $modal_vacaciones = false;
    public $id_vacacion, $ciclo, $tiempo;

    /* Modal Validación de Vacaciones */
    public $modal_validacion = false;
    public $aprobada, $nombre_empleado;

    public function render()
    {
        $this->dias_disponibles = VacacionDisponible::select(
            'id',
            'year',
            'dias_disponibles'
        )
            ->where('empleados_id', $this->id_empleado)
            ->orderBy('year', 'asc')
            ->get();

        $this->periodo = $this->dias_disponibles[0]->year . ' - ' . $this->dias_disponibles[0]->dias_disponibles . ' día(s)';

        $vacaciones = VacacionDisponible::select('id', 'year', 'dias_disponibles')
            ->where('empleados_id', $this->id_empleado)
            ->orderBy('year', 'asc');
        $vacaciones = $vacaciones->paginate(3, pageName: 'vacaciones');

        $solicitudes = SolicitudVacacion::select(
            'id',
            'fecha_salida',
            'fecha_ingreso',
            'duracion',
            'aprobada',
            'year',
            'created_at'
        )
            ->where('empleados_id', $this->id_empleado);
        $solicitudes = $solicitudes->paginate(5, pageName: 'solicitudes');
        $primer_solicitud = SolicitudVacacion::select('fecha_salida')
            ->where('empleados_id', $this->id_empleado)
            ->orderBy('fecha_salida', 'asc')
            ->first();

        activity()
            ->causedBy(auth()->user())
            ->withProperties(['user_id' => auth()->id()])
            ->log("El usuario " . auth()->user()->name .  " visitó la página: " . request()->path());
        return view('livewire.vacaciones.control-vacaciones', [
            'vacaciones' => $vacaciones,
            'solicitudes' => $solicitudes,
            'primera_solicitud' => $primer_solicitud
        ]);
    }

    public function guardar()
    {
        try {
            $validated = $this->validate([
                'fecha_salida' => 'required|date',
                'fecha_ingreso' => 'required|date|after:fecha_salida',
                'periodo' => 'required|filled',
                'duracion' => 'required|filled',
                'observacion' => 'nullable|/^[A-Za-záàéèíìóòúùÁÀÉÈÍÌÓÒÚÙüÜñÑ\s0-9.:;¡¿,!?]+$/u'
            ]);

            DB::transaction(function () use ($validated) {
                $fecha_ingreso = $validated['fecha_salida'];
                foreach ($this->dias_disponibles as $vacacion) {
                    if ($this->duracion_int > $vacacion->dias_disponibles) {
                        SolicitudVacacion::updateOrCreate(['id' => $this->id_solicitud], [
                            'fecha_salida' => $fecha_ingreso,
                            'fecha_ingreso' => $this->getFechaIngreso($fecha_ingreso, $vacacion->dias_disponibles),
                            'year' => $vacacion->year,
                            'duracion' => $vacacion->dias_disponibles,
                            'empleados_id' => $this->id_empleado
                        ]);

                        $fecha_ingreso = $this->getFechaIngreso($fecha_ingreso, $vacacion->dias_disponibles);
                        $this->duracion_int -= $vacacion->dias_disponibles;
                    } else {
                        SolicitudVacacion::updateOrCreate(['id' => $this->id_solicitud], [
                            'fecha_salida' => $fecha_ingreso,
                            'fecha_ingreso' => $this->getFechaIngreso($fecha_ingreso, $this->duracion_int),
                            'year' => $vacacion->year,
                            'duracion' => $this->duracion_int,
                            'empleados_id' => $this->id_empleado
                        ]);
                        break;
                    }
                }
            });
            $empleado = Empleado::findOrFail($this->id_empleado);
            activity()
                ->causedBy(auth()->user())
                ->withProperties(['user_id' => auth()->id()])
                ->log("El usuario " . auth()->user()->name .  " guardó una solicitud de vacaciones de " . $this->duracion . " para el empleado " . $empleado->nombres . " " . $empleado->apellidos);
            session()->flash('message');
            $this->cerrarModal();
            $this->limpiarModal();
            return redirect()->route('control_vacaciones', ['id_empleado' => $this->id_empleado]);
        } catch (Exception $e) {
            $errorMessages = "Ocurrió un error: " . $e->getMessage();
            session()->flash('error', $errorMessages);
            $this->cerrarModal();
            $this->limpiarModal();
            return redirect()->route('control_vacaciones', ['id_empleado' => $this->id_empleado]);
        }
    }

    protected function getFechaIngreso($fecha_ingreso, $duracion)
    {
        $fecha_ingreso = Carbon::parse($fecha_ingreso);
        $dias_habiles = 0;

        while ($dias_habiles < $duracion) {
            if ($fecha_ingreso->isWeekday()) {
                $dias_habiles++;
            }
            $fecha_ingreso->addDay();
        }
        return $fecha_ingreso;
    }

    public function guardarVacacion()
    {
        try {
            $validated = $this->validate([
                'tiempo' => 'required|filled|integer|max:20|min:0'
            ]);
            VacacionDisponible::where('id', $this->id_vacacion)->update([
                'dias_disponibles' => $validated['tiempo']
            ]);
            $empleado = Empleado::findOrFail($this->id_empleado);
            activity()
                ->causedBy(auth()->user())
                ->withProperties(['user_id' => auth()->id()])
                ->log("El usuario " . auth()->user()->name .  " actualizó los días de vacaciones del empleado " . $empleado->nombres . " " . $empleado->apellidos . " del año " . $this->ciclo);
            session()->flash('message');
            $this->cerrarModalVacacion();
            return redirect()->route('control_vacaciones', ['id_empleado' => $this->id_empleado]);
        } catch (Exception $e) {
            $errorMessages = "Ocurrió un error: " . $e->getMessage();
            session()->flash('error', $errorMessages);
            $this->cerrarModalVacacion();
            return redirect()->route('control_vacaciones', ['id_empleado' => $this->id_empleado]);
        }
    }

    public function guardarValidacion()
    {
        try {
            $validated = $this->validate([
                'aprobada' => 'required|integer|min:0|max:2'
            ]);
            DB::transaction(function () use ($validated) {
                SolicitudVacacion::where('id', $this->id_solicitud)->update([
                    'aprobada' => $validated['aprobada']
                ]);

                if ($validated['aprobada'] == 2) {
                    $vacaciones_disponibles = VacacionDisponible::orderBy('year', 'asc')->get();
                    foreach ($vacaciones_disponibles as $vacacion) {
                        if ($this->duracion > 0) {
                            if ($vacacion->dias_disponibles >= $this->duracion) {
                                $vacacion->dias_disponibles -= $this->duracion;
                                $this->duracion = 0;
                            } else {
                                $this->duracion -= $vacacion->dias_disponibles;
                                $vacacion->dias_disponibles = 0;
                            }
                            $vacacion->update([
                                'dias_disponibles' => $vacacion->dias_disponibles
                            ]);
                        } else {
                            break;
                        }
                    }
                }
            });
            $estado = '';
            if ($validated['aprobada'] == 2) {
                $estado = 'aprobó';
            } else {
                $estado = 'denegó';
            }
            activity()
                ->causedBy(auth()->user())
                ->withProperties(['user_id' => auth()->id()])
                ->log("El usuario " . auth()->user()->name .  $estado . " la solicitud de vacaciones del empleado " . $this->nombre_empleado);
            session()->flash('message');
            $this->cerrarModalValidacion();
            return redirect()->route('control_vacaciones', ['id_empleado' => $this->id_empleado]);
        } catch (Exception $e) {
            $errorMessages = "Ocurrió un error: " . $e->getMessage();
            session()->flash('error', $errorMessages);
            $this->cerrarModalValidacion();
            return redirect()->route('control_vacaciones', ['id_empleado' => $this->id_empleado]);
        }
    }

    public function editar($id_solicitud)
    {
        $this->id_solicitud = $id_solicitud;
        $solicitud = SolicitudVacacion::findOrFail($id_solicitud);
        if (!empty($solicitud)) {
            $this->fecha_salida = $solicitud->fecha_salida;
            $this->fecha_ingreso = $solicitud->fecha_ingreso;
            $this->duracion = $solicitud->duracion . ' día(s)';
            $this->duracion_int = $solicitud->duracion;
            $this->observacion = $solicitud->observacion;
            $this->modal = true;
        }
    }

    public function validarSolicitud($id_solicitud)
    {
        $this->id_solicitud = $id_solicitud;
        $vacacion = SolicitudVacacion::select(
            'solicitudes_vacaciones.fecha_salida as fecha_salida',
            'solicitudes_vacaciones.fecha_ingreso as fecha_ingreso',
            'solicitudes_vacaciones.duracion as duracion',
            'empleados.nombres as nombres',
            'empleados.apellidos as apellidos'
        )
            ->join('empleados', 'solicitudes_vacaciones.empleados_id', '=', 'empleados.id')
            ->where('solicitudes_vacaciones.id', $this->id_solicitud)
            ->first();
        $this->nombre_empleado = $vacacion->nombres . " " . $vacacion->apellidos;
        $this->fecha_salida = $vacacion->fecha_salida;
        $this->fecha_ingreso = $vacacion->fecha_ingreso;
        $this->duracion = $vacacion->duracion;
        $this->modal_validacion = true;
    }

    public function updatedFechaSalida()
    {
        /* $this->fecha_max = date('Y-m-d', strtotime($this->fecha_salida . ' + ' . $this->dias_disponibles->dias_disponibles . ' days')); */
        $this->fecha_min = date('Y-m-d', strtotime($this->fecha_salida . '+1 day'));
        if (!empty($this->fecha_salida)) {
            $this->updatedFechaIngreso();
        }
    }

    public function updatedFechaIngreso()
    {
        if (!empty($this->fecha_salida) && !empty($this->fecha_ingreso)) {
            $fecha_salida = Carbon::parse($this->fecha_salida);
            $fecha_ingreso = Carbon::parse($this->fecha_ingreso);

            $dias_vacaciones = 0;
            while ($fecha_salida->lessThan($fecha_ingreso)) {
                if ($fecha_salida->isWeekday()) {
                    $dias_vacaciones++;
                }
                $fecha_salida->addDay();
            }
            $this->duracion_int = $dias_vacaciones;
            $this->duracion = $dias_vacaciones . ' día(s)';

            $dias_disponibles = $this->dias_disponibles->sum('dias_disponibles');
            if ($dias_disponibles < $this->duracion_int) {
                $this->dispatch('diasInsuficientesAlert', ['message' => 'El empleado no cuenta con los días suficientes de vacaciones para realizar la solicitud']);
                $this->fecha_salida = '';
                $this->fecha_ingreso = '';
                $this->duracion = '';
                $this->observacion = '';
            } elseif ($this->duracion_int == 0) {
                $this->dispatch('diasInsuficientesAlert', ['message' => 'Las fechas que ha seleccionado no son válidas']);
                $this->fecha_salida = '';
                $this->fecha_ingreso = '';
                $this->duracion = '';
                $this->observacion = '';
            }
        }
    }

    public function crear()
    {
        $this->modal = true;
    }

    public function editarVacacion($id_vacacion)
    {
        $this->id_vacacion = $id_vacacion;
        $vacacion = VacacionDisponible::findOrFail($id_vacacion);
        if (!empty($vacacion)) {
            $this->tiempo = $vacacion->dias_disponibles;
            $this->ciclo = $vacacion->year;
        }
        $this->modal_vacaciones = true;
    }

    public function limpiarModal()
    {
        $this->fecha_salida = '';
        $this->fecha_ingreso = '';
        $this->periodo = '';
        $this->duracion = '';
        $this->observacion = '';
        $this->fecha_min = '';
        $this->id_solicitud = '';
    }

    public function cerrarModal()
    {
        $this->modal = false;
        $this->limpiarModal();
    }

    public function cerrarModalVacacion()
    {
        $this->modal_vacaciones = false;
        $this->tiempo = '';
        $this->ciclo = '';
        $this->id_vacacion = '';
    }

    public function cerrarModalValidacion()
    {
        $this->modal_validacion = false;
        $this->nombre_empleado = '';
        $this->fecha_ingreso = '';
        $this->fecha_salida = '';
        $this->duracion = '';
        $this->id_solicitud = '';
    }

    public function mount($id_empleado)
    {
        $this->id_empleado = $id_empleado;
    }
}
