<?php

namespace App\Livewire\Formularios;

use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;

use Livewire\Component;

class Formulario extends Component
{
    use WithFileUploads;

    public $departamentos, $municipios, $municipios_emision,
        $hijos = [''],
        $idiomas = [['idioma' => '', 'habla' => '', 'lee' => '', 'escribe' => '']],
        $si_no = [['val' => 0, 'res' => 'No'], ['val' => 1, 'res' => 'Sí']],
        $programas = [['nombre' => '', 'valoracion' => '']],
        $personas_dependientes = [['nombre' => '', 'parentesco' => '']];
    public $historiales_laborales = [
        [
            'empresa' => '',
            'direccion' => '',
            'telefono' => '',
            'jefe' => '',
            'cargo' => '',
            'desde' => '',
            'hasta' => '',
            'ultimo_sueldo' => '',
            'motivo_salida' => '',
            'verificar_informacion' => '',
            'razon_informacion' => ''
        ]
    ];
    public $referencias_laborales = [['nombre' => '', 'empresa' => '', 'teléfono' => '']];
    public $referencias_personales = [['nombre' => '', 'lugar_trabajo' => '', 'teléfono' => '']];
    /* variables de consulta */
    public $id_candidato, $dpi, $nit, $igss, $imagen, $nombres, $apellidos, $puesto, $email, $pretension_salarial, $departamento, 
    $municipio, $fecha_nacimiento, $nacionalidad, $estado_civil, $direccion, $departamento_emision, $municipio_emision, $licencia, 
    $tipo_licencia;
    
    #[Layout('layouts.app2')]
    public function render()
    {
        $etnias =  DB::table('etnias')->select('id', 'etnia')->get();
        $grupos_sanguineos = DB::table('grupos_sanguineos')->select('id', 'grupo')->get();
        $this->departamentos = DB::table('departamentos')->select('id', 'nombre')->get();
        $nacionalidades = DB::table('nacionalidades')->select('id', 'nacionalidad')->get();
        $estados_civiles = DB::table('estados_civiles')->select('id', 'estado_civil')->get();
        $tipos_licencias = DB::table('tipos_licencias')->select('id', 'tipo_licencia')->get();
        $tipos_vehiculos = DB::table('tipos_vehiculos')->select('id', 'tipo_vehiculo')->get();
        $tipos_deudas = DB::table('tipos_deudas')->select('id', 'tipo_deuda')->get();
        $tipos_viviendas = DB::table('tipos_viviendas')->select('id', 'tipo_vivienda')->get();
        return view('livewire.formularios.formulario', [
            'etnias' => $etnias,
            'grupos_sanguineos' => $grupos_sanguineos,
            'nacionalidades' => $nacionalidades,
            'estados_civiles' => $estados_civiles,
            'tipos_licencias' => $tipos_licencias,
            'tipos_vehiculos' => $tipos_vehiculos,
            'tipos_deudas' => $tipos_deudas,
            'tipos_viviendas' => $tipos_viviendas
        ]);
    }

    public function mount($id_candidato)
    {
        $this->id_candidato = $id_candidato;
        $this->cargarPuesto($id_candidato);
    }

    public function cargarPuesto($id_candidato){
        $puesto = DB::table('catalogo_puestos')
            ->join('puestos_nominales', 'catalogo_puestos.id', '=', 'puestos_nominales.catalogo_puestos_id')
            ->join('aplicaciones_candidatos', 'puestos_nominales.id', '=', 'aplicaciones_candidatos.puestos_nominales_id')
            ->select('puestos_nominales.id as id_puesto', 'catalogo_puestos.puesto as puesto')
            ->where('aplicaciones_candidatos.candidatos_id', '=', $id_candidato)
            ->first();
        $this->puesto = $puesto->puesto;
    }

    public function getMunicipiosByDepartamento()
    {
        $this->municipio = '';
        if ($this->departamento) {
            $this->municipios = DB::table('municipios')
                ->select('id', 'nombre', 'departamentos_id')
                ->where('departamentos_id', '=', $this->departamento)
                ->get();
        } else {
            $this->municipios = [];
        }
    }

    public function getMunicipiosByDepartamentoEmision()
    {
        $this->municipio_emision = '';
        if ($this->departamento_emision) {
            $this->municipios_emision = DB::table('municipios')
                ->select('id', 'nombre', 'departamentos_id')
                ->where('departamentos_id', '=', $this->departamento_emision)
                ->get();
        } else {
            $this->municipios = [];
        }
    }

    public function add_son()
    {
        $this->hijos[] = '';
    }

    public function remove_son($index)
    {
        if (count($this->hijos) > 1) {
            unset($this->hijos[$index]);
            $this->hijos = array_values($this->hijos);
        }
    }

    public function add_lang()
    {
        $this->idiomas[] = '';
    }

    public function remove_lang($index)
    {
        if (count($this->idiomas) > 1) {
            unset($this->idiomas[$index]);
            $this->idiomas = array_values($this->idiomas);
        }
    }

    public function add_program()
    {
        $this->programas[] = ['nombre' => '', 'valoracion' => ''];
    }

    public function remove_program($index)
    {
        unset($this->programas[$index]);
        $this->programas = array_values($this->programas);
    }
}
