<?php

namespace App\Livewire\Candidatos;

use App\Models\Empleado;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class VerFormulario extends Component
{
    public $departamentos, $municipios, $municipios_emision,
        $hijos = [['nombre' => '']],
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
    public $id_candidato, $id_requisito, $id_puesto, $dpi, $nit, $igss, $imagen, $nombres, $apellidos, $puesto, $email, $pretension_salarial, $departamento,
        $municipio, $fecha_nacimiento, $nacionalidad, $estado_civil, $direccion, $departamento_emision, $municipio_emision, $licencia,
        $tipo_licencia, $tipo_vehiculo, $placa, $telefono_casa, $telefono_movil, $familiar_conred, $nombre_familiar_conred,
        $cargo_familiar_conred, $conocido_conred, $nombre_conocido_conred, $cargo_conocido_conred, $telefono_padre, $nombre_padre,
        $ocupacion_padre, $telefono_madre, $nombre_madre, $ocupacion_madre, $telefono_conviviente, $nombre_conviviente, $ocupacion_conviviente,
        $establecimiento_primaria, $titulo_primaria, $establecimiento_secundaria, $titulo_secundaria, $establecimiento_diversificado,
        $titulo_diversificado, $establecimiento_universitario, $titulo_universitario, $establecimiento_maestria_postgrado,
        $titulo_maestria_postgrado, $establecimiento_otra_especialidad, $titulo_otra_especialidad, $estudia_actualmente, $estudio_actual,
        $horario_estudio_actual, $establecimiento_estudio_actual, $etnia, $otro_etnia, $tipo_vivienda, $pago_vivienda, $cantidad_personas_dependientes,
        $ingresos_adicionales, $fuente_ingresos_adicionales, $personas_aportan_ingresos, $monto_ingreso_total, $posee_deudas, $tipo_deuda,
        $monto_deuda, $trabajo_conred, $trabajo_estado, $jubilado_estado, $institucion_jubilacion, $padecimiento_salud, $tipo_enfermedad, $intervencion_quirurgica,
        $tipo_intervencion, $sufrido_accidente, $tipo_accidente, $alergia_medicamento, $tipo_medicamento, $tipo_sangre, $nombre_contacto_emergencia,
        $telefono_contacto_emergencia, $direccion_contacto_emergencia;

    public function render()
    {
        return view('livewire.candidatos.ver-formulario');
    }

    public function mount($id_candidato, $id_requisito)
    {
        $this->id_candidato = $id_candidato;
        $this->id_requisito = $id_requisito;
        $this->cargarPuesto($id_candidato);

        /* consulta para los campos del candidato (tabla empleado) */
        $candidato = Empleado::where([
            'candidatos_id' => $id_candidato
        ])->select(
            'empleados.nit as nit',
            'empleados.igss as igss',
            'empleados.imagen as imagen',
            'empleados.nombres as nombres',
            'empleados.apellidos as apellidos',
            'empleados.email as email',
            'empleados.fecha_nacimiento as fecha_nacimiento',
            'empleados.direccion as direccion',
            'empleados.pretension_salarial as pretension_salarial',
            'empleados.estudia_actualmente as estudia_actualmente',
            'empleados.estudio_actual as estudio_actual',
            'empleados.cantidad_personas_dependientes as cantidad_personas_dependientes',
            'empleados.ingresos_adicionales as ingresos_adicionales',
            'empleados.monto_ingreso_total as monto_ingreso_total',
            'empleados.posee_deudas as posee deudas'
        )->first();
        $this->nit = $candidato->nit;
        $this->igss = $candidato->igss;
        $this->imagen = $candidato->imagen;
        $this->nombres = $candidato->nombres;
        $this->apellidos = $candidato->apellidos;
        $this->email = $candidato->email;
        $this->fecha_nacimiento = $candidato->fecha_nacimiento;
        $this->direccion = $candidato->direccion;
        $this->pretension_salarial = number_format($candidato->pretension_salarial, 2, '.', ',');
        $this->estudia_actualmente = $this->si_no[$candidato->estudia_actualmente]['res'];

    }

    public function cargarPuesto($id_candidato)
    {
        $puesto = DB::table('catalogo_puestos')
            ->join('puestos_nominales', 'catalogo_puestos.id', '=', 'puestos_nominales.catalogo_puestos_id')
            ->join('aplicaciones_candidatos', 'puestos_nominales.id', '=', 'aplicaciones_candidatos.puestos_nominales_id')
            ->select('puestos_nominales.id as id_puesto', 'catalogo_puestos.puesto as puesto')
            ->where('aplicaciones_candidatos.candidatos_id', '=', $id_candidato)
            ->first();
        $this->puesto = $puesto->puesto;
        $this->id_puesto = $puesto->id_puesto;
    }

}
