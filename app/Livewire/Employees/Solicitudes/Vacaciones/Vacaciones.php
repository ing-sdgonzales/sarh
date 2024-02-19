<?php

namespace App\Livewire\Employees\Solicitudes\Vacaciones;

use App\Models\Empleado;
use App\Models\SolicitudVacacion;
use App\Models\VacacionDisponible;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Vacaciones extends Component
{
    use WithPagination;

    public $id_empleado;

    /* Colecciones */
    public $vacaciones_disponibles;

    /* Modal Crear y Editar */
    public $modal = false;
    public $id_solicitud, $fecha_salida, $fecha_ingreso, $periodo, $duracion, $duracion_int, $observacion,
        $fecha_min, $fecha_max, $mostrar_observacion = false;


    public function render()
    {
        $this->vacaciones_disponibles = VacacionDisponible::select(
            'id',
            'year',
            'dias_disponibles'
        )
            ->where('empleados_id', $this->id_empleado)
            ->orderBy('year', 'asc')
            ->get();

        $vacaciones = VacacionDisponible::select(
            'year',
            'dias_disponibles'
        )
            ->where('empleados_id', $this->id_empleado)
            ->orderBy('year', 'asc');
        $vacaciones = $vacaciones->paginate(3, pageName: 'vacaciones');

        $this->periodo = $this->vacaciones_disponibles[0]->year . ' - ' . $this->vacaciones_disponibles[0]->dias_disponibles . ' día(s)';

        $solicitudes = SolicitudVacacion::select(
            'id',
            'fecha_salida',
            'fecha_ingreso',
            'duracion',
            'aprobada',
            'year',
            'created_at as fecha_solicitud'
        )
            ->where('empleados_id', $this->id_empleado)
            ->orderBy('fecha_salida', 'asc');

        $solicitudes = $solicitudes->paginate(5, pageName: 'solicitudes');
        $ultima_solicitud = SolicitudVacacion::select('fecha_salida')
            ->where('empleados_id', $this->id_empleado)
            ->orderBy('fecha_salida', 'desc')
            ->first();
        return view('livewire.employees.solicitudes.vacaciones.vacaciones', [
            'vacaciones' => $vacaciones,
            'solicitudes' => $solicitudes,
            'utlima_solicitud' => $ultima_solicitud
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
            ]);
            DB::transaction(function () use ($validated) {
                $fecha_ingreso = $validated['fecha_salida'];
                foreach ($this->vacaciones_disponibles as $vacacion) {
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
            session()->flash('message');
            $this->cerrarModal();
            $this->limpiarModal();
            return redirect()->route('empleados-solicitudes-vacaciones');
        } catch (Exception $e) {
            $errorMessages = "Ocurrió un error: " . $e->getMessage();
            session()->flash('error', $errorMessages);
            $this->cerrarModal();
            $this->limpiarModal();
            return redirect()->route('empleados-solicitudes-vacaciones');
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
            $dias_disponibles = $this->vacaciones_disponibles->sum('dias_disponibles');
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
            $this->verificarFechas($this->fecha_salida, $this->fecha_ingreso);
        }
    }

    public function verificarFechas($fecha_salida, $fecha_ingreso)
    {
        if (!empty($fecha_salida) && !empty($fecha_ingreso)) {
            $solicitudes = SolicitudVacacion::select(
                'fecha_salida',
                'fecha_ingreso',
            )
                ->where('empleados_id', $this->id_empleado)
                ->get();
            $fecha_inicio = Carbon::createFromFormat('Y-m-d', $fecha_salida);
            $fecha_fin = Carbon::createFromFormat('Y-m-d', $fecha_ingreso);
            foreach ($solicitudes as $solicitud) {
                $fi = Carbon::createFromFormat('Y-m-d', $solicitud->fecha_salida);
                $ff = Carbon::createFromFormat('Y-m-d', $solicitud->fecha_ingreso);
                if (($fecha_inicio->greaterThan($fi) && $fecha_inicio->lessThan($ff))
                    || ($fecha_fin->greaterThan($fi) && $fecha_fin->lessThan($ff))
                    || ($fecha_inicio->lessThan($fi) && $fecha_fin->greaterThan($ff))
                ) {
                    $this->dispatch('showSolicitudesAlert', ['message' => 'Ya posee una solicitud con una o ambas fechas. Por favor elija otras o espere a que su solicitud actual sea procesada.']);
                    $this->fecha_salida = '';
                    $this->fecha_ingreso = '';
                    $this->duracion = '';
                    $this->duracion_int = '';
                }
            }
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

    public function updatedFechaSalida()
    {
        /* $this->fecha_max = date('Y-m-d', strtotime($this->fecha_salida . ' + ' . $this->dias_disponibles->dias_disponibles . ' days')); */
        $this->fecha_min = date('Y-m-d', strtotime($this->fecha_salida . '+1 day'));
        if (!empty($this->fecha_salida)) {
            $this->updatedFechaIngreso();
        }
    }

    public function eliminar($id_solicitud)
    {
    }

    public function crear()
    {
        $this->modal = true;
    }

    public function cerrarModal()
    {
        $this->modal = false;
    }

    public function limpiarModal()
    {
        $this->fecha_salida = '';
        $this->fecha_ingreso = '';
        $this->duracion = '';
        $this->duracion_int = '';
        $this->periodo = '';
        $this->fecha_min = '';
        $this->fecha_max = '';
        $this->observacion = '';
    }

    public function mount()
    {
        $empleado = Empleado::select('id')->where('email', auth()->user()->email)->first();
        $this->id_empleado = $empleado->id;
    }
}
