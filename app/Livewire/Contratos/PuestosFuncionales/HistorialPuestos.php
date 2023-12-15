<?php

namespace App\Livewire\Contratos\PuestosFuncionales;

use App\Livewire\Puesto\Puestos;
use App\Models\Contrato;
use App\Models\DependenciaFuncional;
use App\Models\Empleado;
use App\Models\PuestoFuncional;
use App\Models\Region;
use App\Models\RegistroPuesto;
use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class HistorialPuestos extends Component
{
    public $id_empleado, $empleado;

    /* Colecciones */
    public $contratos, $dependencias_funcionales, $regiones;

    /* Variables de formulario */
    public $id_puesto, $contrato, $numero_contrato, $fecha_inicio, $fecha_fin, $observacion, $region, $dependencia_funcional, $puesto_funcional,
        $fecha_min, $fecha_max;

    /* Modal crear y editar */
    public $modal = false;
    public $fechasLibres, $fechasOcupadas;
    public function render()
    {
        $this->dependencias_funcionales = DependenciaFuncional::select('id', 'dependencia')->get();
        $this->regiones = Region::select('id', 'region', 'nombre')->get();

        $this->empleado = Empleado::select(
            'empleados.id as id',
            'empleados.codigo as codigo',
            'empleados.imagen as imagen',
            'empleados.nombres as nombres',
            'empleados.apellidos as apellidos',
            'dpis.dpi as dpi'
        )
            ->join('dpis', 'empleados.id', '=', 'dpis.empleados_id')
            ->where('empleados.id', $this->id_empleado)
            ->first();

        $this->contratos = Contrato::select(
            'id',
            'numero'
        )
            ->where('empleados_id', $this->id_empleado)
            ->get();

        $registros_puestos = RegistroPuesto::select(
            'registros_puestos.id as id',
            'registros_puestos.fecha_inicio as fecha_inicio',
            'registros_puestos.fecha_fin as fecha_fin',
            'contratos.numero as numero_contrato',
            'puestos_funcionales.puesto as puesto_funcional',
            'dependencias_funcionales.dependencia as dependencia_funcional'
        )
            ->join('contratos', 'registros_puestos.contratos_id', '=', 'contratos.id')
            ->leftjoin('puestos_funcionales', 'registros_puestos.puestos_funcionales_id', 'puestos_funcionales.id')
            ->join('dependencias_funcionales', 'registros_puestos.dependencias_funcionales_id', '=', 'dependencias_funcionales.id')
            ->where('contratos.empleados_id', $this->id_empleado)
            ->orderBy('registros_puestos.fecha_fin', 'desc');

        $registros_puestos = $registros_puestos->paginate(10);

        activity()
            ->causedBy(auth()->user())
            ->withProperties(['user_id' => auth()->id()])
            ->log("El usuario " . auth()->user()->name .  " visitó la página: " . request()->path());
        return view('livewire.contratos.puestos-funcionales.historial-puestos', [
            'registros_puestos' => $registros_puestos
        ]);
    }

    public function guardar()
    {
        $validated = $this->validate([
            'contrato' => 'required|integer|min:1',
            'dependencia_funcional' => 'required|integer|min:1',
            'puesto_funcional' => 'nullable|integer',
            'region' => 'required|integer|min:1',
            'fecha_inicio' => 'required|date|after_or_equal:' . $this->fecha_min . '|before_or_equal:' . $this->fecha_max,
            'fecha_fin' => 'required|date|after_or_equal:' . $this->fecha_min . '|before_or_equal:' . $this->fecha_max,
            'observacion' => 'nullable|regex:/^[A-Za-záàéèíìóòúùÁÀÉÈÍÌÓÒÚÙüÜñÑ\s.,;:-]+$/',
        ]);
        try {
            DB::transaction(function () use ($validated) {
                RegistroPuesto::updateOrCreate(['id' => $this->id_puesto], [
                    'fecha_inicio' => $validated['fecha_inicio'],
                    'fecha_fin' => $validated['fecha_fin'],
                    'observacion' => $validated['observacion'],
                    'dependencias_funcionales_id' => $validated['dependencia_funcional'],
                    'puestos_funcionales_id' => $validated['puesto_funcional'],
                    'regiones_id' => $validated['region'],
                    'contratos_id' => $validated['contrato']
                ]);
            });
            $puesto = PuestoFuncional::select('puesto')->where('id', $this->puesto_funcional)->first();
            if ($puesto == null) {
                $puesto = '';
            } else {
                $puesto = $puesto->puesto;
            }
            $empleado = Empleado::findOrFail($this->id_empleado);
            activity()
                ->causedBy(auth()->user())
                ->withProperties(['user_id' => auth()->id()])
                ->log("El usuario " . auth()->user()->name .  " guardó el puesto: " . $puesto . " para el empleado: " . $empleado->nombres . " " . $empleado->apellidos);
            session()->flash('message');
            $this->cerrarModal();
            return redirect()->route('historial_puestos', ['id_empleado' => $this->id_empleado]);
        } catch (Exception $e) {
            $errorMessages = "Ocurrió un error: " . $e->getMessage();
            session()->flash('error', $errorMessages);
            $this->cerrarModal();
            return redirect()->route('historial_puestos', ['id_empleado' => $this->id_empleado]);
        }
    }

    public function editar($id_puesto)
    {
        $this->id_puesto = $id_puesto;
        $puesto = RegistroPuesto::findOrFail($id_puesto);
        if ($puesto) {
            $this->contrato = $puesto->contratos_id;
            $this->getDisponibilidadPuesto();
            $this->fecha_inicio = $puesto->fecha_inicio;
            $this->fecha_fin = $puesto->fecha_fin;
            $this->dependencia_funcional = $puesto->dependencias_funcionales_id;
            $this->puesto_funcional = $puesto->puestos_funcionales_id;
            $this->region = $puesto->regiones_id;
            $this->observacion = $puesto->observacion;
        }

        $this->modal = true;
    }

    public function getDisponibilidadFechas()
    {
        $this->fecha_min = '';
        $this->fecha_max = '';
        $this->fechasLibres = [];
        $this->fechasOcupadas = [];

        if ($this->contrato != '') {
            $fechas_contrato = Contrato::findOrFail($this->contrato);
            $puestos_contrato = RegistroPuesto::select('fecha_inicio', 'fecha_fin')
                ->where('contratos_id', $this->contrato)
                ->where('id', '!=', $this->id_puesto)
                ->get()
                ->toArray();

            $fechaInicioContrato = $fechas_contrato->fecha_inicio;
            $fechaFinContrato = $fechas_contrato->fecha_fin;

            foreach ($puestos_contrato as $puesto) {
                $this->fechasOcupadas[] = ['fecha_inicio' => $puesto['fecha_inicio'], 'fecha_fin' => $puesto['fecha_fin']];
            }

            // Ordenar por fecha de inicio
            usort($this->fechasOcupadas, function ($a, $b) {
                return strtotime($a['fecha_inicio']) - strtotime($b['fecha_inicio']);
            });

            $inicioLibre = $fechaInicioContrato;

            foreach ($this->fechasOcupadas as $ocupada) {
                $finOcupada = $ocupada['fecha_fin'];

                if (strtotime($inicioLibre) < strtotime($ocupada['fecha_inicio'])) {
                    $this->fechasLibres[] = ['fecha_inicio' => $inicioLibre, 'fecha_fin' => date('Y-m-d', strtotime($ocupada['fecha_inicio'] . ' -1 day'))];
                }

                $inicioLibre = date('Y-m-d', strtotime($finOcupada . ' +1 day'));
            }

            if (strtotime($inicioLibre) <= strtotime($fechaFinContrato)) {
                $this->fechasLibres[] = ['fecha_inicio' => $inicioLibre, 'fecha_fin' => $fechaFinContrato];
            }

            if (empty($this->fechasLibres)) {
                $this->dispatch('fechasOcupadasAlert', ['message' => 'El contrato ' . $fechas_contrato->numero .
                    ' no tiene fechas disponibles para crear un nuevo puesto. Debe actualizar el registro del último puesto asignado.']);
                $this->contrato = '';
                $this->fecha_min = '';
                $this->fecha_max = '';
                $this->fechasLibres = [];
                $this->fechasOcupadas = [];
            } else {
                $this->fecha_min = end($this->fechasLibres)['fecha_inicio'];
                $this->fecha_max = end($this->fechasLibres)['fecha_fin'];
            }
        }
    }

    public function crear()
    {
        $this->modal = true;
    }

    public function cerrarModalPuestoContrato()
    {
        $this->id_puesto = '';
        $this->numero_contrato = '';
        $this->contrato = '';
        $this->fecha_inicio = '';
        $this->fecha_fin = '';
        $this->observacion = '';
        $this->region = '';
        $this->dependencia_funcional = '';
        $this->puesto_funcional = '';
        $this->fecha_min = '';
        $this->fecha_max = '';
        $this->modal = false;
    }

    public function mount($id_empleado)
    {
        $this->id_empleado = $id_empleado;
    }
}
