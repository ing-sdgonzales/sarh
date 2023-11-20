<?php

namespace App\Livewire\Empleados;

use Livewire\Component;

class Empleados extends Component
{
    /* Colecciones */
    public $generos, $etnias, $grupos_sanguineos, $dependencias_funcionales, $departamentos, $municipios, $nacionalidades, 
        $tipos_viviendas, $estados_civiles;
    /* Variables de entidad */
    public $id_empleado, $nit, $igss, $imagen, $nombres, $apellidos, $email, $fecha_ingreso, $fecha_nacimiento, $cuenta_banco, 
        $fecha_retiro, $estado, $estado_familiar, $pretension_salarial, $observaciones, $estudia_actualmente, $estudio_actual,
        $cantidad_personas_dependientes, $ingresos_adicionales, $monto_ingreso_total, $posee_deudas, $trabajo_conred, 
        $trabajo_estado, $jubilado_estado, $institucion_jubilacion, $personas_aportan_ingresos, $fuente_ingresos_adicionales,
        $pago_vivienda, $familiar_conred, $conocido_conred, $otro_etnia, $genero, $etnia, $grupo_sanguineo, $depencencia_funcional,
        $municipio, $departamento, $nacionalidad, $tipo_vivienda, $estado_civil, $ubicacion_geografica, $candidato_id;

    /* Modal Crear  y Editar*/
    public $modal = false;
    public function render()
    {
        return view('livewire.empleados.empleados');
    }

    public function crear()
    {
        $this->modal = true;
    }

    public function limpiarModal()
    {
    }

    public function cerrarModal()
    {
        $this->modal = false;
    }
}
