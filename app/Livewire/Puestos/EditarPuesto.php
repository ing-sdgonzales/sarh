<?php

namespace App\Livewire\Puestos;

use App\Models\Renglon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class EditarPuesto extends Component
{
    public $departamentos, $municipios, $puestos;
    public $selectedRegion;
    public $selectedDepartamento;
    public $selectedRenglon;
    public $selectedPuesto;
    public $id, $puesto;

    public function render()
    {
        $regiones = DB::table('regiones')->select('id', 'region', 'nombre')->get();
        $especialidades = DB::table('especialidades')->select('id', 'codigo', 'especialidad')->get();
        $fuentes = DB::table('fuentes_financiamientos')->select('id', 'codigo', 'fuente')->get();
        $plazas = DB::table('plazas')->select('id', 'codigo', 'plaza')->get();
        $dependencias = DB::table('dependencias_nominales')->select('id', 'dependencia')->get();
        $renglones = DB::table('renglones')
            ->select(
                'id',
                'renglon',
                'nombre'
            )
            ->where('tipo', '=', 0)
            ->get();
        $this->puesto = DB::table('puestos_nominales')
            ->join('catalogo_puestos', 'puestos_nominales.catalogo_puestos_id', '=', 'catalogo_puestos.id')
            ->join('renglones', 'catalogo_puestos.renglones_id', '=', 'renglones.id')
            ->select(
                'puestos_nominales.id as id',
                'puestos_nominales.codigo as codigo',
                'catalogo_puestos_id as id_puesto',
                'renglones.id as id_renglon'
            )
            ->where('puestos_nominales.id', '=', $this->id)
            ->get();
        /* $this->selectedRenglon = $this->puesto[0]->id_renglon; */
        $this->getDepartamentosByRegion($this->selectedRegion);
        $this->getPuestosByRenglon();
        $this->getMunicipiosByDepartamento($this->selectedDepartamento);
        return view('livewire.puestos.editar-puesto', [
            'regiones' => $regiones,
            'renglones' => $renglones,
            'especialidades' => $especialidades,
            'fuentes' => $fuentes,
            'plazas' => $plazas,
            'dependencias' => $dependencias,
            'puesto' => $this->puesto
        ]);
        /* return view('livewire.puestos.editar-puesto'); */
    }

    public function getDepartamentosByRegion()
    {
        if ($this->selectedRegion) {
            $this->departamentos = DB::table('departamentos')
                ->select('id', 'nombre', 'regiones_id')
                ->where('regiones_id', '=', $this->selectedRegion)
                ->get();
            /* if ($this->departamentos->count() > 0) {
                $this->selectedDepartamento = $this->departamentos[0]->id;
            } */
        } else {
            $this->departamentos = [];
        }
    }

    public function getPuestosByRenglon()
    {
        if ($this->selectedRenglon) {
            $this->puestos = DB::table('catalogo_puestos')
                ->select('id', 'codigo', 'puesto', 'renglones_id')
                ->where('renglones_id', '=', $this->selectedRenglon)
                ->get();
            if ($this->puestos->count() > 0) {
                $this->selectedPuesto = $this->puestos[0]->renglones_id;
            }
        } else {
            $this->puestos = [];
        }
    }

    public function updatedSelectedRegion()
    {
        $this->getDepartamentosByRegion();
        $this->getMunicipiosByDepartamento();
    }

    public function getMunicipiosByDepartamento()
    {
        if ($this->selectedDepartamento) {
            $this->municipios = DB::table('municipios')
                ->select('id', 'nombre', 'departamentos_id')
                ->where('departamentos_id', '=', $this->selectedDepartamento)
                ->get();
        } else {
            $this->municipios = [];
        }
    }
    public function getInfoByPuestoId($id)
    {
        $this->id = $id;
        $this->puesto = DB::table('puestos_nominales')
            ->join('catalogo_puestos', 'puestos_nominales.catalogo_puestos_id', '=', 'catalogo_puestos.id')
            ->join('renglones', 'catalogo_puestos.renglones_id', '=', 'renglones.id')
            ->select(
                'puestos_nominales.id as id',
                'puestos_nominales.codigo as codigo',
                'catalogo_puestos_id as id_puesto',
                'renglones.id as id_renglon'
            )
            ->where('puestos_nominales.id', '=', $this->id)
            ->get();
        /* if ($this->puesto->count() > 0) {
            $this->selectedRenglon = $this->puesto[0]->id_renglon;
            $this->getPuestosByRenglon($this->selectedRenglon);
        } */
    }
}
