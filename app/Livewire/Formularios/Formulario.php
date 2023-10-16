<?php

namespace App\Livewire\Formularios;

use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;

use Livewire\Component;

class Formulario extends Component
{
    public $imagen, 
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
    #[Layout('layouts.app2')]
    public function render()
    {
        $etnias =  DB::table('etnias')->select('id', 'etnia')->get();
        $grupos_sanguineos = DB::table('grupos_sanguineos')->select('id', 'grupo')->get();
        return view('livewire.formularios.formulario', [
            'etnias' => $etnias,
            'grupos_sanguineos' => $grupos_sanguineos
        ]);
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
