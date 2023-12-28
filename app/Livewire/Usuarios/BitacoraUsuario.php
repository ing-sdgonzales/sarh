<?php

namespace App\Livewire\Usuarios;

use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;
use Livewire\Component;
use Spatie\Activitylog\Models\Activity;

class BitacoraUsuario extends Component
{
    use WithPagination;

    public $usuarios, $usuario, $filtro = '';
    public function render()
    {
        $this->usuarios = DB::table('users')
            ->select(
                'id',
                'name',
                'last_login_at',
                'last_login_ip'
            )
            ->get();
        $actividades = Activity::orderby('created_at', 'desc')
            ->select('activity_log.*', 'users.name as name')
            ->leftJoin('users', 'activity_log.causer_id', '=', 'users.id')
            ->whereNot('description', 'LIKE', '%livewire/update%');
        if (!empty($this->filtro)) {
            $actividades->where('activity_log.causer_id', '=', $this->filtro);
        }

        $actividades = $actividades->paginate(10);

        activity()
            ->causedBy(auth()->user())
            ->withProperties(['user_id' => auth()->id()])
            ->log("El usuario " . auth()->user()->name .  " visitó la página: " . request()->path());
        return view('livewire.usuarios.bitacora-usuario', [
            'actividades' => $actividades
        ]);
    }

    public function getActividadesByUsuario()
    {
        $this->filtro = $this->usuario;
    }
}
