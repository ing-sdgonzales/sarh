<?php

namespace App\Livewire\Usuarios;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Yajra\DataTables\DataTables;

class UsuariosTable extends Component
{
    use WithPagination;

    public function render()
    {
        $usuarios = User::query()->paginate(10);
        return view('livewire.usuarios.usuarios-table', [
            'usuarios' => $usuarios,
        ]);
    }

    public function dataTable()
    {
        return DataTables::of(User::query())->make(true);
    }
}
