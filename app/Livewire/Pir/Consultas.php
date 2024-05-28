<?php

namespace App\Livewire\Pir;

use App\Http\Controllers\EstadoFuerzaController;
use App\Models\PirDireccion;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class Consultas extends Component
{
    use WithPagination;

    public $busqueda, $filtro;
    public function render()
    {
        $direcciones = PirDireccion::select(
            'id',
            'direccion',
            'hora_actualizacion'
        );

        if (!empty($this->filtro)) {
            $direcciones->where('direccion', 'LIKE', '%' . $this->filtro . '%');
        }
        return view('livewire.pir.consultas', [
            'direcciones' => $direcciones->paginate(10)
        ]);
    }

    public function descargarReporte($id_direccion)
    {
        $region = '';
        $direccion = PirDireccion::findOrFail($id_direccion);
        if (Str::startsWith($direccion->direccion, 'Región')) {
            $region = $direccion->direccion;
        }
        $reporte = new EstadoFuerzaController();
        $path = $reporte->generateDisponibilidadReport($direccion->id, $region);
        $this->dispatch('download', ['message' => 'El formulario se ha actualizado correctamente']);
        return response()->download($path)->deleteFileAfterSend(true);
    }

    public function updatedBusqueda()
    {
        $this->filtro = $this->busqueda;
    }
}
