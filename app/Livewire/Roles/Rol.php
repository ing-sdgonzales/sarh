<?php

namespace App\Livewire\Roles;

use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class Rol extends Component
{
    use WithPagination;

    public $id, $rol, $permiso = [];
    public $modal = false;
    public function render()
    {
        activity()
            ->causedBy(auth()->user())
            ->withProperties(['user_id' => auth()->id()])
            ->log("El usuario " . auth()->user()->name .  " visitó la página: " . request()->path());
        return view('livewire.roles.rol', [
            'roles' => DB::table('roles')->paginate(10, pageName: 'roles-page'),
            'permisos' => DB::table('permissions')->paginate(7, pageName: 'permisos-page')
        ]);
    }

    public function guardar()
    {
        DB::transaction(function () {
            $rl = Role::updateOrCreate(['id' => $this->id], [
                'name' => $this->rol,
                'guard_name' => 'web'
            ]);

            if (!empty($this->permiso)) {
                $rl->syncPermissions($this->permiso);
            }
            activity()
                ->causedBy(auth()->user())
                ->withProperties(['user_id' => auth()->id()])
                ->log("El usuario " . auth()->user()->name . " guardó el rol: " . $rl->name);
        });

        session()->flash('message');
        $this->cerrarModal();
        return redirect()->route('roles');
    }

    public function editar($id)
    {
        $this->id = $id;
        $rl = Role::findOrFail($id);
        $this->rol = $rl->name;
        $this->permiso = DB::table('role_has_permissions')
            ->select(
                'permission_id'
            )
            ->where('role_id', '=', $id)
            ->pluck('permission_id')
            ->toArray();
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
        $this->resetPage(pageName: 'permisos-page');
        return redirect()->route('roles');
    }

    public function limpiarModal()
    {
        $this->rol = '';
        $this->permiso = [];
    }
}
