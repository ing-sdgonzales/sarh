<?php

namespace App\Livewire\Pir;

use App\Http\Controllers\EstadoFuerzaController;
use App\Models\PirDireccion;
use App\Models\PirEmpleado;
use App\Models\PirGrupo;
use App\Models\PirReporte;
use App\Models\PirSeccion;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;

class Formulario extends Component
{
    use WithPagination;
    /* Colecciones */
    public $grupos, $reportes;
    public $personal = [
        'nombre' => '',
        'pir_reporte_id' => '',
        'pir_grupo_id' => '',
        'observacion'
    ];

    public $contratista = [
        'nombre' => '',
        'pir_reporte_id' => '',
        'pir_grupo_id' => '',
        'observacion'
    ];
    public $seccion, $id_direccion, $direccion, $reporte, $observacion, $grupo, $fecha, $hora;
    public function render()
    {
        $this->reportes = PirReporte::all();
        $this->grupos = PirGrupo::all();
        $this->personal = PirEmpleado::select(
            'pir_empleados.nombre',
            'pir_empleados.observacion',
            'pir_empleados.pir_reporte_id',
            'pir_empleados.pir_grupo_id'
        )
            ->join('renglones', 'pir_empleados.renglon_id', '=', 'renglones.id')
            ->where('pir_direccion_id', $this->id_direccion)
            ->where('renglones.renglon', '011')
            ->orWhere('renglones.renglon', '021')
            ->orWhere('renglones.renglon', '022')
            ->orWhere('renglones.renglon', '031')
            ->get()
            ->toArray();

        $this->contratista = PirEmpleado::select(
            'pir_empleados.nombre',
            'pir_empleados.observacion',
            'pir_empleados.pir_reporte_id',
            'pir_empleados.pir_grupo_id'
        )
            ->join('renglones', 'pir_empleados.renglon_id', '=', 'renglones.id')
            ->where('pir_direccion_id', $this->id_direccion)
            ->where('renglones.renglon', '029')
            ->get()
            ->toArray();

        activity()
            ->causedBy(auth()->user())
            ->withProperties(['user_id' => auth()->id()])
            ->log("El usuario " . auth()->user()->name .  " visitó la página: " . request()->path());
        return view('livewire.pir.formulario');
    }

    public function guardar()
    {
        $validated = $this->validate([
            'personal.*.nombre' => ['required', 'filled', 'regex:/^[A-Za-záàéèíìóòúùÁÀÉÈÍÌÓÒÚÙüÜñÑ\s]+$/'],
            'personal.*.observacion' => ['nullable', 'regex:/^[A-Za-záàéèíìóòúùÁÀÉÈÍÌÓÒÚÙüÜñÑ\s.,;:-]+$/'],
            'personal.*.pir_reporte_id' => 'required|integer|min:1',
            'personal.*.pir_grupo_id' => 'required|integer|min:1',
            'contratista.*.nombre' => ['required', 'filled', 'regex:/^[A-Za-záàéèíìóòúùÁÀÉÈÍÌÓÒÚÙüÜñÑ\s]+$/'],
            'contratista.*.observacion' => ['nullable', 'regex:/^[A-Za-záàéèíìóòúùÁÀÉÈÍÌÓÒÚÙüÜñÑ\s.,;:-]+$/'],
            'contratista.*.pir_reporte_id' => 'required|integer|min:1',
            'contratista.*.pir_grupo_id' => 'required|integer|min:1'
        ]);

        try {
            DB::transaction(function () use ($validated) {
                foreach ($validated['personal'] as $personal) {
                    PirEmpleado::updateOrCreate(['nombre' => $personal['nombre']], [
                        'observacion' => (!empty($personal['observacion'])) ? $personal['observacion'] : null,
                        'pir_reporte_id' => $personal['pir_reporte_id'],
                        'pir_grupo_id' => $personal['pir_grupo_id']
                    ]);
                }

                if (!empty($this->contratista)) {
                    foreach ($validated['contratista'] as $contratista) {
                        PirEmpleado::updateOrCreate(['nombre' => $contratista['nombre']], [
                            'observacion' => (!empty($contratista['observacion'])) ? $contratista['observacion'] : null,
                            'pir_reporte_id' => $contratista['pir_reporte_id'],
                            'pir_grupo_id' => $contratista['pir_grupo_id']
                        ]);
                    }
                }
            });
            session()->flash('message');
            $formulario = new EstadoFuerzaController();
            $path = $formulario->generarFormularioPIR($this->id_direccion);
            $this->dispatch('download', ['message' => 'El formulario se ha actualizado correctamente']);
            return response()->download($path)->deleteFileAfterSend(true);
        } catch (QueryException $exception) {
            $error = $exception->errorInfo;
            session()->flash('error', implode($error));
            return redirect()->route('postularse.formulario.index', ['id_puesto' => $this->id_puesto]);
        }
    }

    public function mount()
    {
        $rol = auth()->user()->getRoleNames()->first();
        $this->direccion = $rol;
        $direccion = PirDireccion::where('direccion', $rol)->first();
        $this->id_direccion = $direccion->id;
        $seccion = PirSeccion::findOrFail($direccion->pir_seccion_id);
        $this->seccion = $seccion->seccion;
    }
}
