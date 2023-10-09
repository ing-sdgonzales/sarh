<?php

namespace App\Livewire\Puestos;

use App\Models\PuestoNominal;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class CrearPuesto extends Component
{

    public $departamentos, $municipios, $puestos;
    public $selectedRegion =  1;
    public $selectedDepartamento = 1;
    public $selectedRenglon = 1;
    public $fecha_actual = null;

    public function render()
    {
        $regiones = DB::table('regiones')->select('id', 'region', 'nombre')->get();
        $especialidades = DB::table('especialidades')->select('id', 'codigo', 'especialidad')->get();
        $fuentes = DB::table('fuentes_financiamientos')->select('id', 'codigo', 'fuente')->get();
        $plazas = DB::table('plazas')->select('id', 'codigo', 'plaza')->get();
        $dependencias = DB::table('dependencias_nominales')->select('id', 'dependencia')->get();
        $puestos = DB::table('catalogo_puestos')->select('id', 'codigo', 'puesto')->get();
        $renglones = DB::table('renglones')
            ->select(
                'id',
                'renglon',
                'nombre'
            )
            ->where('tipo', '=', 0)
            ->get();
        $this->fecha_actual = date("Y-m-d");
        $this->getDepartamentosByRegion($this->selectedRegion);
        $this->getPuestosByRenglon();
        $this->getMunicipiosByDepartamento($this->selectedDepartamento);
        return view('livewire.puestos.crear-puesto', [
            'regiones' => $regiones,
            'renglones' => $renglones,
            'especialidades' => $especialidades,
            'fuentes' => $fuentes,
            'plazas' => $plazas,
            'dependencias' => $dependencias,
            'puestos' => $puestos,
            'fecha' => $this->fecha_actual
        ]);
    }


    public function store()
    {
        /* $validated = $request->validate([
            'código' => 'bail|required|filled',
            'renglón' => 'bail|required',
            'nombre' => 'bail|required|filled',
            'partida_presupuestaria' => 'bail|required|filled',
            'región' => 'bail|required',
            'departamento' => 'bail|required',
            'municipio' => 'bail|required',
            'fecha_de_registro' => 'bail|required',
            'gastos_de_representación' => 'bail|required|numeric|filled',
            'especialidad' => 'bail|required',
            'fuentes_financiamientos' => 'bail|required',
            'dependencias_nominales' => 'bail|required',
            'plaza' => 'bail|required'
        ]);
        return back()->withErrors($validated);
 */
        /* try { */
        PuestoNominal::create([
            'codigo' => request('código'),
            'partida_presupuestaria' => request('partida_presupuestaria'),
            'estado' => 1,
            'financiado' => 1,
            'gastos_representacion' => request('gastos_de_representación'),
            'fecha_registro' => request('fecha_de_registro'),
            'especialidades_id' => request('especialidad'),
            'renglones_id' => request('renglón'),
            'plazas_id' => request('plaza'),
            'fuentes_financiamientos_id' => request('fuentes_financiamientos'),
            'dependencias_nominales_id' => request('dependencias_nominales'),
            'municipios_id' => request('municipio'),
            'catalogo_puestos_id' => request('puesto')
        ]);

        return redirect()->route('puestos');


        /* session()->flash('message', 'Registro agregado');
            return back();
        } catch (\Illuminate\Database\QueryException $exception) {
            $errorInfo = $exception->errorInfo;
            session()->flash('error', implode($errorInfo));
            return back();
        } */

        /* session()->flash('message', 'Registro agregado');
            return back();
        } catch (\Illuminate\Database\QueryException $exception) {

            $errorInfo = $exception->errorInfo;
            session()->flash('error', implode($errorInfo));
            return back();
        } */
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

    public function getPuestosByRenglon(){
        if ($this->selectedRenglon) {
            $this->puestos = DB::table('catalogo_puestos')
                ->select('id', 'codigo', 'puesto')
                ->where('renglones_id', '=', $this->selectedRenglon)
                ->get();
            /* if ($this->puestos->count() > 0) {
                $this->selectedRenglon =  $this->selectedRenglon[0]->id;
            } */
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
}
