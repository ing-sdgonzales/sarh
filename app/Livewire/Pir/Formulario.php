<?php

namespace App\Livewire\Pir;

use App\Http\Controllers\EstadoFuerzaController;
use App\Models\Departamento;
use App\Models\PirDireccion;
use App\Models\PirEmpleado;
use App\Models\PirGrupo;
use App\Models\PirReporte;
use App\Models\PirSeccion;
use App\Models\Region;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class Formulario extends Component
{
    use WithPagination;

    /* Colecciones */
    public $grupos, $reportes;

    #[Validate([
        'personal.*.nombre' => ['required', 'filled', 'regex:/^[A-Za-záàéèíìóòúùÁÀÉÈÍÌÓÒÚÙüÜñÑ\s]+$/'],
        'personal.*.pir_reporte_id' => 'required|integer|min:1',
        'personal.*.departamento_id' => 'required|integer|min:1',
        'personal.*.observacion' => ['nullable', 'required_if:personal.*.pir_reporte_id,2,3,4,5,6,7,9', 'regex:/^[A-Za-záàéèíìóòúùÁÀÉÈÍÌÓÒÚÙüÜñÑ\s.,;:-]+$/'],
        'personal.*.pir_grupo_id' => 'required|integer|min:1',
    ], message: [
        'personal.*.observacion' => 'El campo observación es obligatorio cuando el empleado o contratista no está presente en sedes'
    ])]
    public $personal = [
        'nombre' => '',
        'pir_reporte_id' => '',
        'departamento_id' => '',
        'pir_grupo_id' => '',
        'observacion'
    ];

    #[Validate([
        'contratista.*.nombre' => ['required', 'filled', 'regex:/^[A-Za-záàéèíìóòúùÁÀÉÈÍÌÓÒÚÙüÜñÑ\s]+$/'],
        'contratista.*.pir_reporte_id' => 'required|integer|min:1',
        'contratista.*.departamento_id' => 'required|integer|min:1',
        'contratista.*.observacion' => ['nullable', 'required_if:contratista.*.pir_reporte_id,2,3,4,5,6,7,9', 'regex:/^[A-Za-záàéèíìóòúùÁÀÉÈÍÌÓÒÚÙüÜñÑ\s.,;:-]+$/'],
        'contratista.*.pir_grupo_id' => 'required|integer|min:1'
    ], message: [
        'contratista.*.observacion' => 'El campo observación es obligatorio cuando el empleado o contratista no está presente en sedes'
    ])]
    public $contratista = [
        'nombre' => '',
        'pir_reporte_id' => '',
        'departamento_id' => '',
        'pir_grupo_id' => '',
        'observacion'
    ];

    public $seccion, $id_direccion, $direccion, $region, $default_depto, $id_region, $departamentos, $reporte, $observacion, $grupo, $fecha, $hora;

    public function render()
    {
        $this->reportes = PirReporte::all();
        $this->grupos = PirGrupo::all();
        if (!empty($this->region)) {
            $this->departamentos = Departamento::where('regiones_id', $this->id_region)->get();
        } else {
            $this->departamentos = Departamento::where('regiones_id', 1)->get();
        }

        $this->default_depto = $this->departamentos->first();

        $this->personal = PirEmpleado::select(
            'pir_empleados.nombre',
            'pir_empleados.observacion',
            'pir_empleados.departamento_id',
            'pir_empleados.pir_reporte_id',
            'pir_empleados.pir_grupo_id'
        )
            ->join('pir_puestos', 'pir_empleados.id', '=', 'pir_puestos.pir_empleado_id')
            ->join('catalogo_puestos', 'pir_puestos.catalogo_puesto_id', '=', 'catalogo_puestos.id')
            ->join('renglones', 'catalogo_puestos.renglones_id', '=', 'renglones.id')
            ->join('regiones', 'pir_empleados.region_id', '=', 'regiones.id');

        if (!empty($this->id_region)) {
            $this->personal = $this->personal->where('region_id', $this->id_region);
        } else {
            $this->personal = $this->personal->where('pir_direccion_id', $this->id_direccion);
        }
        $this->personal = $this->personal->whereIn('renglones.renglon', ['011', '021', '022', '031'])
            ->orderBy('pir_empleados.nombre')
            ->get()
            ->toArray();

        foreach ($this->personal as &$emp) {
            if (empty($emp['departamento_id'])) {
                $emp['departamento_id'] = $this->default_depto->id;
            }
        }

        $this->contratista = PirEmpleado::select(
            'pir_empleados.nombre',
            'pir_empleados.observacion',
            'pir_empleados.departamento_id',
            'pir_empleados.pir_reporte_id',
            'pir_empleados.pir_grupo_id'
        )
            ->join('pir_puestos', 'pir_empleados.id', '=', 'pir_puestos.pir_empleado_id')
            ->join('catalogo_puestos', 'pir_puestos.catalogo_puesto_id', '=', 'catalogo_puestos.id')
            ->join('renglones', 'catalogo_puestos.renglones_id', '=', 'renglones.id')
            ->join('regiones', 'pir_empleados.region_id', '=', 'regiones.id');

        if (!empty($this->id_region)) {
            $this->contratista = $this->contratista->where('region_id', $this->id_region);
        } else {
            $this->contratista = $this->contratista->where('pir_direccion_id', $this->id_direccion);
        }

        $this->contratista = $this->contratista->where('renglones.renglon', '029')
            ->orderBy('pir_empleados.nombre')
            ->get()
            ->toArray();

        foreach ($this->contratista as &$emp) {
            if (empty($emp['departamento_id'])) {
                $emp['departamento_id'] = $this->default_depto->id;
            }
        }

        activity()
            ->causedBy(auth()->user())
            ->withProperties(['user_id' => auth()->id()])
            ->log("El usuario " . auth()->user()->name .  " visitó la página: " . request()->path());
        return view('livewire.pir.formulario');
    }

    public function guardar()
    {
        try {
            $validated = $this->validate();
            DB::transaction(function () use ($validated) {
                foreach ($validated['personal'] as $personal) {
                    PirEmpleado::updateOrCreate(['nombre' => $personal['nombre']], [
                        'observacion' => ($personal['pir_reporte_id'] == 1 || $personal['pir_reporte_id'] == 10) ? null : $personal['observacion'],
                        'pir_reporte_id' => $personal['pir_reporte_id'],
                        'departamento_id' => $personal['departamento_id'],
                        'pir_grupo_id' => $personal['pir_grupo_id']
                    ]);
                }

                if (!empty($this->contratista)) {
                    foreach ($validated['contratista'] as $contratista) {
                        PirEmpleado::updateOrCreate(['nombre' => $contratista['nombre']], [
                            'observacion' => ($contratista['pir_reporte_id'] == 1 || $contratista['pir_reporte_id'] == 10) ? null : $contratista['observacion'],
                            'departamento_id' => $contratista['departamento_id'],
                            'pir_reporte_id' => $contratista['pir_reporte_id'],
                            'pir_grupo_id' => $contratista['pir_grupo_id']
                        ]);
                    }
                }

                if (!empty($this->id_region)) {
                    PirDireccion::where('direccion', $this->region)->update(['hora_actualizacion' => date('Y-m-d H:i:s')]);
                } else {
                    $direccion = PirDireccion::findOrFail($this->id_direccion);
                    $direccion->hora_actualizacion = date('Y-m-d H:i:s');
                    $direccion->save();
                }
            });
            session()->flash('message');
            $reporte = new EstadoFuerzaController();
            $path = $reporte->generateDisponibilidadReport($this->id_direccion, $this->region);
            activity()
                ->causedBy(auth()->user())
                ->withProperties(['user_id' => auth()->id()])
                ->log("El usuario " . auth()->user()->name . " guardó el formulario PIR.");
            $this->dispatch('download', ['message' => 'El formulario se ha actualizado correctamente']);
            return response()->download($path)->deleteFileAfterSend(true);
        } catch (QueryException $exception) {
            $error = $exception->errorInfo;
            session()->flash('error', implode($error));
            return redirect()->route('postularse.formulario.index', ['id_puesto' => $this->id_puesto]);
        } catch (Exception $e) {
            $errorMessages = "Ocurrió un error: " . $e->getMessage();
            session()->flash('error', $errorMessages);
            return redirect()->route('formulario_pir');
        }
    }

    public function generarFromularioPIR()
    {
        $formulario = new EstadoFuerzaController();
        $path = $formulario->generarFormularioPIR($this->id_direccion, $this->region);

        return response()->download($path)->deleteFileAfterSend(true);
    }

    public function generarReporteDiario()
    {
        $reporte = new EstadoFuerzaController();
        $path = $reporte->generarReporteDiario();

        return response()->download($path)->deleteFileAfterSend(true);
    }

    public function generarReporteAusencias()
    {
        $reporte = new EstadoFuerzaController();
        $path = $reporte->generarReporteAusencias();

        return response()->download($path)->deleteFileAfterSend(true);
    }

    public function consolidarPIR()
    {
        $reporte = new EstadoFuerzaController();
        $path = $reporte->consolidarPIR();

        return response()->download($path)->deleteFileAfterSend(true);
    }

    public function mount()
    {
        $rol = auth()->user()->getRoleNames()->first();
        $this->direccion = $rol;
        if (Str::startsWith($rol, 'Región')) {
            $this->region = $rol;
            $region = Region::where('region', $this->region)->first();
            $this->id_region = $region->id;
        } else {
            $direccion = PirDireccion::where('direccion', $rol)->first();
            $this->id_direccion = $direccion->id;
            $seccion = PirSeccion::findOrFail($direccion->pir_seccion_id);
            $this->seccion = $seccion->seccion;
        }
    }
}
