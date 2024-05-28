<?php

namespace App\Livewire\Pir;

use App\Models\CatalogoPuesto;
use App\Models\Departamento;
use App\Models\PirDireccion;
use App\Models\PirEmpleado;
use App\Models\PirPuesto;
use App\Models\Region;
use App\Models\Renglon;
use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Contratistas extends Component
{
    use WithPagination;

    /* Collections */
    public $renglones, $puestos, $regiones, $departamentos, $direcciones;

    public $modal = false, $delete_modal = false, $modo_edicion = false, $busqueda, $filtro;

    /* Variables del modal */
    public $id_empleado, $nombre, $region, $direccion, $departamento, $puesto, $renglon, $regional;

    public function render()
    {
        $this->renglones = Renglon::whereIn('renglon', ['011', '021', '022', '029', '031'])->get();
        $this->regiones = Region::all();
        $this->direcciones = PirDireccion::where('direccion', 'NOT LIKE', 'Región%')->get();

        $contratistas = PirEmpleado::select(
            'pir_empleados.id as id',
            'pir_empleados.nombre as nombre',
            'renglones.renglon as renglon',
            'regiones.region as region',
            'regiones.nombre as region_nombre',
            'pir_direcciones.direccion as direccion',
            'catalogo_puestos.puesto as puesto'
        )
            ->join('regiones', 'pir_empleados.region_id', '=', 'regiones.id')
            ->join('pir_puestos', 'pir_empleados.id', '=', 'pir_puestos.pir_empleado_id')
            ->join('catalogo_puestos', 'pir_puestos.catalogo_puesto_id', '=', 'catalogo_puestos.id')
            ->join('renglones', 'catalogo_puestos.renglones_id', '=', 'renglones.id')
            ->join('pir_direcciones', 'pir_empleados.pir_direccion_id', '=', 'pir_direcciones.id')
            ->where('renglones.renglon', '029')
            ->where('pir_empleados.activo', 1)
            ->orderBy('pir_empleados.id');

        if (!empty($this->filtro)) {
            $contratistas->where('pir_empleados.nombre', 'LIKE', '%' . $this->filtro . '%');
        }

        activity()
            ->causedBy(auth()->user())
            ->withProperties(['user_id' => auth()->id()])
            ->log("El usuario " . auth()->user()->name .  " visitó la página: " . request()->path());
        return view('livewire.pir.contratistas', [
            'contratistas' => $contratistas->paginate(10)
        ]);
    }

    public function guardar()
    {
        $validated = $this->validate([
            'nombre' => 'required|filled|regex:/^[A-Za-záàéèíìóòúùÁÀÉÈÍÌÓÒÚÙüÜñÑ\s]+$/',
            'renglon' => 'required|integer|min:1',
            'puesto' => 'required|integer|min:1',
            'direccion' => 'required|integer|min:1',
            'region' => 'required|integer|min:1',
            'departamento' => 'required|integer|min:1'
        ]);

        try {
            DB::transaction(function () use ($validated) {
                $empleado = PirEmpleado::updateOrCreate(['id' => $this->id_empleado], [
                    'nombre' => $validated['nombre'],
                    'pir_direccion_id' => $validated['direccion'],
                    'region_id' => $validated['region'],
                    'departamento_id' => $validated['departamento'],
                    'is_regional_i' => ($this->regional) ? 1 : 0,
                    'pir_reporte_id' => ($validated['puesto'] == 94 || $validated['puesto'] == 95) ? 11 : 1
                ]);

                PirPuesto::updateOrCreate(['pir_empleado_id' => $empleado->id], [
                    'catalogo_puesto_id' => $validated['puesto']
                ]);
            });
            session()->flash('message');
            $mensaje = $this->modo_edicion ? "actualizó el registro" : "guardó el registro";
            activity()
                ->causedBy(auth()->user())
                ->withProperties(['user_id' => auth()->id()])
                ->log("El usuario " . auth()->user()->name . " " . $mensaje . " de: " . $this->nombre);
            $this->cerrarModal();
            return redirect()->route('contratistas_pir');
        } catch (Exception $e) {
            $errorMessages = "Ocurrió un error: " . $e->getMessage();
            session()->flash('error', $errorMessages);
            $this->cerrarModal();
            return redirect()->route('contratistas_pir');
        }
    }

    public function editar($id_empleado)
    {
        $this->id_empleado = $id_empleado;
        $empleado = PirEmpleado::select(
            'pir_empleados.nombre as nombre',
            'pir_empleados.pir_direccion_id as direccion',
            'pir_empleados.region_id as region',
            'pir_empleados.departamento_id as departamento',
            'renglones.id as renglon',
            'catalogo_puestos.id as puesto'
        )
            ->join('pir_puestos', 'pir_empleados.id', '=', 'pir_puestos.pir_empleado_id')
            ->join('catalogo_puestos', 'pir_puestos.catalogo_puesto_id', '=', 'catalogo_puestos.id')
            ->join('renglones', 'catalogo_puestos.renglones_id', '=', 'renglones.id')
            ->where('pir_empleados.id', $this->id_empleado)
            ->first();
        $this->nombre = $empleado->nombre;
        $this->direccion = $empleado->direccion;
        $this->renglon = $empleado->renglon;
        $this->getPuestosByRenglon();
        $this->puesto = $empleado->puesto;
        $this->region = $empleado->region;
        $this->getDepartamentosByRegion();
        $this->departamento = $empleado->departamento;

        $this->modal = true;
    }

    public function deleteEmpleado()
    {
        try {
            DB::transaction(function () {
                $empleado = PirEmpleado::findOrFail($this->id_empleado);
                $empleado->activo = 0;
                $empleado->save();
            });
            session()->flash('message');
            activity()
                ->causedBy(auth()->user())
                ->withProperties(['user_id' => auth()->id()])
                ->log("El usuario " . auth()->user()->name . " eliminó el registro de: " . $this->nombre);
            $this->cerrarDeleteModal();
            return redirect()->route('contratistas_pir');
        } catch (Exception $e) {
            $errorMessages = "Ocurrió un error: " . $e->getMessage();
            session()->flash('error', $errorMessages);
            $this->cerrarDeleteModal();
            return redirect()->route('contratistas_pir');
        }
    }

    public function updatedBusqueda()
    {
        $this->filtro = $this->busqueda;
    }

    public function delete($id_empleado)
    {
        $this->id_empleado = $id_empleado;
        $empleado = PirEmpleado::findOrFail($id_empleado);
        $this->nombre = $empleado->nombre;
        $this->delete_modal = true;
    }

    public function getPuestosByRenglon()
    {
        if (!empty($this->renglon)) {
            $this->puestos = CatalogoPuesto::where('renglones_id', $this->renglon)->get();
        }
    }

    public function getDepartamentosByRegion()
    {
        if (!empty($this->region)) {
            $this->departamentos = Departamento::where('regiones_id', $this->region)->get();
        }
    }

    public function crear()
    {
        $this->modal = true;
    }

    public function cerrarModal()
    {
        $this->reset();
    }

    public function cerrarDeleteModal()
    {
        $this->delete_modal = false;
        $this->reset();
    }
}
