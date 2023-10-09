<?php

namespace App\Livewire\Permisos;

use ErrorException;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;

class Permiso extends Component
{
    use WithPagination;

    public $id, $permiso = '';
    public $modal = false;
    public function render()
    {
        activity()
            ->causedBy(auth()->user())
            ->withProperties(['user_id' => auth()->id()])
            ->log("El usuario " . auth()->user()->name .  " visitó la página: " . request()->path());
        return view('livewire.permisos.permisos', [
            'permisos' => DB::table('permissions')->paginate(10)
        ]);
    }

    public function guardar()
    {
        $validated = $this->validate([
            'permiso' => 'required|string|min:3|regex:/[^0-9]/',
        ]);

        try {
            DB::table('permissions')->updateOrInsert(['id' => $this->id], [
                'name' => $validated['permiso'],
                'guard_name' => 'web'
            ]);
            session()->flash('message');
            $this->cerrarModal();
            activity()
                ->causedBy(auth()->user())
                ->withProperties(['user_id' => auth()->id()])
                ->log("El usuario " . auth()->user()->name . " guardó el permiso: " . $this->permiso);
            return redirect()->route('permisos');
        } catch (ErrorException $e) {
            $errorMessages = "Ocurrió un error: " . $e->getMessage();
            session()->flash('error', $errorMessages);
            return redirect()->route('permisos');
        } catch (QueryException $ex) {
            $errorInfo = $ex->errorInfo;
            session()->flash('error', implode($errorInfo));
            $this->cerrarModal();
            return redirect()->route('permisos');
        }
        $this->resetPage();
    }

    public function editar($id)
    {
        $this->id = $id;
        $per = Permission::findOrFail($id);
        $this->permiso = $per->name;

        $this->abrirModal();
    }

    public function crear()
    {
        $this->abrirModal();
    }

    public function abrirModal()
    {
        $this->modal = true;
    }

    public function cerrarModal()
    {
        $this->modal = false;
        $this->limpiarModal();
        return redirect()->route('permisos');
    }

    public function limpiarModal()
    {
    }
}
