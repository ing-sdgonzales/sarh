<?php

namespace App\Livewire\Conred\Formulario;

use Livewire\Component;

class DatosPersonales extends Component
{
    public $imagen, $imagen_actual, $dpi, $nit, $igss, $nombre, $email, $fecha_nacimiento, $estado_civil,
        $direccion_domicilio, $telefono, $departamento, $municipio;
    public function render()
    {
        return view('livewire.conred.formulario.datos-personales');
    }
}
