<?php

namespace App\Livewire\Usuarios;

use App\Livewire\Roles\Rol;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class Usuarios extends Component
{
    public $roles, $role;
    public $modal = false, $modo_edicion = false, $modal_eliminar = false;
    public $id_user, $nombre, $password, $email, $rol;
    public function render()
    {
        $this->roles = Role::select('id', 'name')->get();
        $usuarios = DB::table('users')->select(
            'id',
            'name',
            'email',
            'created_at',
            'last_login_at',
            'last_login_ip'
        );
        activity()
            ->causedBy(auth()->user())
            ->withProperties(['user_id' => auth()->id()])
            ->log("El usuario " . auth()->user()->name .  " visitó la página: " . request()->path());
        return view('livewire.usuarios.usuarios', [
            'usuarios' => $usuarios->paginate(10)
        ]);
    }

    public function guardar()
    {
        $accion = 'creó';
        try {
            $validated = $this->validate([
                'nombre' => 'required|string|regex:/^[A-Za-záàéèíìóòúùÁÀÉÈÍÌÓÒÚÙüÜñÑ\s.]+$/|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $this->id_user,
                'password' => 'required|string|min:8|regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d).+$/',
                'rol' => 'required|integer|min:1'
            ]);
            DB::transaction(function () use ($validated) {

                $this->role = Role::select('name')->where('id', $this->rol)->first();

                User::updateOrCreate(['id' => $this->id_user], [
                    'name' => ucwords(mb_strtolower($validated['nombre'])),
                    'email' => $validated['email'],
                    'password' => Hash::make($validated['password'])
                ])->syncRoles($this->role->name);
            });
            if ($this->modo_edicion) {
                $accion = 'actualizó';
            }

            activity()
                ->causedBy(auth()->user())
                ->withProperties(['user_id' => auth()->id()])
                ->log("El usuario " . auth()->user()->name .  " " . $accion . " el usuario: " . $this->nombre . " con el rol: " . $this->role->name);
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

        $role = DB::table('model_has_roles')->select('role_id')->where('model_id', $id_user)->first();

        $this->rol = $role->role_id;
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
        $this->modal = false;
        $this->nombre = '';
        $this->password = '';
        $this->email = '';
    }

    public function cerrarModalEliminar()
    {
        $this->reset();
    }
}
