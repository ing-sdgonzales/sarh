<?php

namespace App\Livewire\Usuarios;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class Usuarios extends Component
{

    use WithPagination;

    public $modal = false, $modo_edicion = false, $modal_eliminar = false;
    public $id_user, $nombre, $password, $email, $rol = [];
    public function render()
    {
        $roles = Role::select('id', 'name')->orderBy('name', 'asc');

        if ($this->modo_edicion && !empty($this->rol)) {
            $roles = DB::table('roles')
                ->leftJoin('model_has_roles', function ($join) {
                    $join->on('roles.id', '=', 'model_has_roles.role_id')
                        ->where('model_has_roles.model_id', '=', $this->id_user);
                })
                ->select('roles.id', 'roles.name')
                ->orderByRaw('model_has_roles.role_id IS NULL, roles.name ASC');
        }

        $usuarios = DB::table('users')->select(
            'id',
            'name',
            'email',
            'created_at',
            'last_login_at',
            'last_login_ip'
        )->paginate(10, pageName: 'usuarios-page');
        
        activity()
            ->causedBy(auth()->user())
            ->withProperties(['user_id' => auth()->id()])
            ->log("El usuario " . auth()->user()->name .  " visitó la página: " . request()->path());
        return view('livewire.usuarios.usuarios', [
            'usuarios' => $usuarios,
            'roles' => $roles->paginate(5, pageName: 'roles-page')
        ]);
    }

    public function guardar()
    {
        $accion = 'creó';
        try {
            $validated = $this->validate([
                'nombre' => 'required|string|regex:/^[A-Za-záàéèíìóòúùÁÀÉÈÍÌÓÒÚÙüÜñÑ\s.]+$/|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $this->id_user,
                'password' => [$this->id_user ? 'nullable' : 'required', 'string', 'min:8', 'regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d).+$/'],
                'rol' => 'required|array'
            ]);
            DB::transaction(function () use ($validated) {

                $user = User::updateOrCreate(['id' => $this->id_user], [
                    'name' => ucwords(mb_strtolower($validated['nombre'])),
                    'email' => $validated['email'],
                    'password' => Hash::make($validated['password'])
                ]);

                $user->syncRoles($this->rol);
            });
            if ($this->modo_edicion) {
                $accion = 'actualizó';
            }

            activity()
                ->causedBy(auth()->user())
                ->withProperties(['user_id' => auth()->id()])
                ->log("El usuario " . auth()->user()->name .  " " . $accion . " el usuario: " . $this->nombre . ".");
            session()->flash('message');
            $this->cerrarModal();
            $this->modo_edicion = false;
            return redirect()->route('usuarios');
        } catch (Exception $e) {
            $errorMessages = "Ocurrió un error: " . $e->getMessage();
            session()->flash('error', $errorMessages);
            $this->cerrarModal();
            return redirect()->route('usuarios');
        }
    }

    public function editar($id_user)
    {
        $user = User::findOrfail($id_user);

        $this->id_user = $id_user;
        $this->nombre = $user->name;
        $this->email = $user->email;
        $this->rol = DB::table('model_has_roles')->select('role_id')->where('model_id', $id_user)->pluck('role_id')->toArray();

        $this->modo_edicion = true;
        $this->modal = true;
    }

    public function delete($id_user)
    {
        $user = User::findOrFail($id_user);
        $this->id_user = $id_user;
        $this->nombre = $user->name;
        $this->modal_eliminar = true;
    }

    public function deleteUser()
    {
        try {
            DB::transaction(function () {
                User::where('id', $this->id_user)->delete();
                activity()
                    ->causedBy(auth()->user())
                    ->withProperties(['user_id' => auth()->id()])
                    ->log("El usuario " . auth()->user()->name .  " eliminó el usuario: " . $this->nombre . ".");
            });
            session()->flash('message');
            $this->cerrarModalEliminar();
            return redirect()->route('usuarios');
        } catch (Exception $e) {
            $errorMessages = "Ocurrió un error: " . $e->getMessage();
            session()->flash('error', $errorMessages);
            $this->cerrarModalEliminar();
            return redirect()->route('usuarios');
        }
    }

    public function crear()
    {
        $this->modal = true;
    }

    public function cerrarModal()
    {
        $this->reset();
        $this->resetPage('roles-page');
    }

    public function cerrarModalEliminar()
    {
        $this->reset();
    }
}
