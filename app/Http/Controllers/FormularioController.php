<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\HijoEmpleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Settings;
use PhpOffice\PhpWord\TemplateProcessor;
use Illuminate\Support\Str;


class FormularioController extends Controller
{

    public function generarDoc($id_empleado)
    {
        $empleado = DB::table('empleados')
            ->join('municipios', 'empleados.municipios_id', '=', 'municipios.id')
            ->join('departamentos', 'municipios.departamentos_id', '=', 'departamentos.id')
            ->join('nacionalidades', 'empleados.nacionalidades_id', '=', 'nacionalidades.id')
            ->join('estados_civiles', 'empleados.estados_civiles_id', '=', 'estados_civiles.id')
            ->join('dpis', 'empleados.id', '=', 'dpis.empleados_id')
            ->join('municipios as mun_emision', 'dpis.municipios_id', '=', 'mun_emision.id')
            ->join('departamentos as dep_emision', 'municipios.departamentos_id', '=', 'dep_emision.id')
            ->leftjoin('vehiculos', 'empleados.id', '=', 'vehiculos.empleados_id')
            ->join('tipos_vehiculos', 'vehiculos.tipos_vehiculos_id', '=', 'tipos_vehiculos.id')
            ->leftjoin('licencias_conducir', 'empleados.id', '=', 'licencias_conducir.empleados_id')
            ->join('tipos_licencias', 'licencias_conducir.tipos_licencias_id', '=', 'tipos_licencias.id')
            ->join('telefonos_empleados', 'empleados.id', '=', 'telefonos_empleados.empleados_id')
            ->leftjoin('familiares_conred', 'empleados.id', '=', 'familiares_conred.empleados_id')
            ->leftjoin('conocidos_conred', 'empleados.id', '=', 'conocidos_conred.empleados_id')
            ->join('padres_empleados', 'empleados.id', '=', 'padres_empleados.empleados_id')
            ->join('madres_empleados', 'empleados.id', '=', 'madres_empleados.empleados_id')
            ->leftjoin('convivientes', 'empleados.id', '=', 'convivientes.empleados_id')
            ->leftjoin('estudios_actuales_empleados', 'empleados.id', '=', 'estudios_actuales_empleados.empleados_id')
            ->join('etnias', 'empleados.etnias_id', '=', 'etnias.id')
            ->join('tipos_viviendas', 'empleados.tipos_viviendas_id', '=', 'tipos_viviendas.id')
            ->leftjoin('deudas', 'empleados.id', '=', 'deudas.empleados_id')
            ->join('tipos_deudas', 'deudas.tipos_deudas_id', '=', 'tipos_deudas.id')
            ->join('historias_clinicas', 'empleados.id', '=', 'historias_clinicas.empleados_id')
            ->join('grupos_sanguineos', 'empleados.grupos_sanguineos_id', '=', 'grupos_sanguineos.id')
            ->join('contactos_emergencias', 'empleados.id', '=', 'contactos_emergencias.empleados_id')
            ->select(
                'empleados.id as id_empleado',
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
                'empleados.cantidad_personas_dependientes as cantidad_personas_dependientes',
                'empleados.ingresos_adicionales as ingresos_adicionales',
                'empleados.monto_ingreso_total as monto_ingreso_total',
                'empleados.posee_deudas as posee_deudas',
                'empleados.trabajo_conred as trabajo_conred',
                'empleados.trabajo_estado as trabajo_estado',
                'empleados.jubilado_estado as jubilado_estado',
                'empleados.institucion_jubilacion as institucion_jubilacion',
                'empleados.personas_aportan_ingresos as personas_aportan_ingresos',
                'empleados.fuente_ingresos_adicionales as fuente_ingresos_adicionales',
                'empleados.pago_vivienda as pago_vivienda',
                'empleados.familiar_conred as familiar_conred',
                'empleados.conocido_conred as conocido_conred',
                'municipios.id as id_municipio',
                'municipios.nombre as municipio',
                'departamentos.id as id_departamento',
                'departamentos.nombre as departamento',
                'nacionalidades.id as id_nacionalidad',
                'nacionalidades.nacionalidad as nacionalidad',
                'estados_civiles.id as id_estado_civil',
                'estados_civiles.estado_civil as estado_civil',
                'dpis.dpi as dpi',
                'municipios.nombre as municipio_emision',
                'departamentos.nombre as departamento_emision',
                'licencias_conducir.licencia as licencia',
                'tipos_licencias.id as id_tipo_licencia',
                'tipos_licencias.tipo_licencia as tipo_licencia',
                'tipos_vehiculos.id as id_tipo_vehiculo',
                'tipos_vehiculos.tipo_vehiculo as tipo_vehiculo',
                'vehiculos.placa as placa',
                'telefonos_empleados.id as id_telefono_empleado',
                'telefonos_empleados.telefono_casa as telefono_casa',
                'telefonos_empleados.telefono as telefono',
                'familiares_conred.id as id_familiar_conred',
                'familiares_conred.nombre as nombre_familiar_conred',
                'familiares_conred.cargo as cargo_familiar_conred',
                'conocidos_conred.id as id_conocido_conred',
                'conocidos_conred.nombre as nombre_conocido_conred',
                'conocidos_conred.cargo as cargo_conocido_conred',
                'padres_empleados.id as id_padre',
                'padres_empleados.telefono as telefono_padre',
                'padres_empleados.nombre as nombre_padre',
                'padres_empleados.ocupacion as ocupacion_padre',
                'madres_empleados.id as id_madre',
                'madres_empleados.telefono as telefono_madre',
                'madres_empleados.nombre as nombre_madre',
                'madres_empleados.ocupacion as ocupacion_madre',
                'convivientes.id as id_conviviente',
                'convivientes.telefono as telefono_conviviente',
                'convivientes.nombre as nombre_conviviente',
                'convivientes.ocupacion as ocupacion_conviviente',
                'estudios_actuales_empleados.id as id_estudio_actual',
                'estudios_actuales_empleados.carrera as estudio_actual',
                'estudios_actuales_empleados.establecimiento as establecimiento_estudio_actual',
                'estudios_actuales_empleados.horario as horario_estudio_actual',
                'etnias.id as id_etnia',
                'etnias.etnia as etnia',
                'tipos_viviendas.id as id_tipo_vivienda',
                'tipos_viviendas.tipo_vivienda as tipo_vivienda',
                'deudas.id as id_deuda',
                'deudas.monto as monto_deuda',
                'tipos_deudas.id as id_tipo_deuda',
                'tipos_deudas.tipo_deuda as tipo_deuda',
                'historias_clinicas.id as id_historia_clinica',
                'historias_clinicas.padecimiento_salud as padecimiento_salud',
                'historias_clinicas.tipo_enfermedad as tipo_enfermedad',
                'historias_clinicas.intervencion_quirurgica as intervencion_quirurgica',
                'historias_clinicas.tipo_intervencion as tipo_intervencion',
                'historias_clinicas.sufrido_accidente as sufrido_accidente',
                'historias_clinicas.tipo_accidente as tipo_accidente',
                'historias_clinicas.alergia_medicamento as alergia_medicamento',
                'historias_clinicas.tipo_medicamento as tipo_medicamento',
                'grupos_sanguineos.id as id_grupo_sanguineo',
                'grupos_sanguineos.grupo as tipo_sangre',
                'contactos_emergencias.id as id_contacto_emergencia',
                'contactos_emergencias.nombre as nombre_contacto_emergencia',
                'contactos_emergencias.telefono as telefono_contacto_emergencia',
                'contactos_emergencias.direccion as direccion_contacto_emergencia'

            )
            ->selectRaw('TIMESTAMPDIFF(YEAR, empleados.fecha_nacimiento, CURDATE()) as edad')
            ->where('empleados.id', '=', $id_empleado)
            ->first();
        /* plantilla */
        $doc = new TemplateProcessor('templates/formulario.docx');
        Settings::setPdfRendererName(Settings::PDF_RENDERER_DOMPDF);
        Settings::setPdfRendererPath('.');


        /* campos a reemplazar en la plantilla (formulario) */
        $doc->setImageValue('foto', array('path' => 'storage/' . $empleado->imagen, 'width' => '3.08cm', 'height' => '3.67cm', 'ratio' => false));
        $doc->setValue('nombres', $empleado->nombres);
        $doc->setValue('apellidos', $empleado->apellidos);
        $doc->setValue('pretension_salarial', number_format($empleado->pretension_salarial, 2, '.', ','));
        $doc->setValue('municipio', $empleado->municipio);
        $doc->setValue('departamento', $empleado->departamento);
        $doc->setValue('fecha_nacimiento', date('d/m/Y', strtotime($empleado->fecha_nacimiento)));
        $doc->setValue('edad', $empleado->edad);
        $doc->setValue('nacionalidad', $empleado->nacionalidad);
        $doc->setValue('estado_civil', $empleado->estado_civil);
        $doc->setValue('direccion', $empleado->direccion);
        $doc->setValue('dpi', $empleado->dpi);
        $doc->setValue('mun_emision', $empleado->municipio_emision);
        $doc->setValue('dep_emision', $empleado->departamento_emision);
        $doc->setValue('igss', $empleado->igss);
        $doc->setValue('licencia', $empleado->licencia);
        $doc->setValue('t_l', $empleado->tipo_licencia);
        $doc->setValue('tipo_vehiculo', $empleado->tipo_vehiculo);
        $doc->setValue('placa', $empleado->placa);
        $doc->setValue('telefono_casa', $empleado->telefono_casa);
        $doc->setValue('telefono_movil', $empleado->telefono);
        $doc->setValue('email', $empleado->email);
        if ($empleado->familiar_conred == 1) {
            $doc->setValue('sfc', 'X');
            $doc->setValue('nfc', '');
        } else {
            $doc->setValue('sfc', '');
            $doc->setValue('nfc', 'X');
        }
        $doc->setValue('nombre_fc', $empleado->nombre_familiar_conred);
        $doc->setValue('cargo_fc', $empleado->cargo_familiar_conred);
        if ($empleado->conocido_conred == 1) {
            $doc->setValue('scc', 'X');
            $doc->setValue('ncc', '');
        } else {
            $doc->setValue('scc', '');
            $doc->setValue('ncc', 'X');
        }
        $doc->setValue('nombre_cc', $empleado->nombre_conocido_conred);
        $doc->setValue('cargo_cc', $empleado->cargo_conocido_conred);
        $doc->setValue('telefono_padre', $empleado->telefono_padre);
        $doc->setValue('nombre_padre', $empleado->nombre_padre);
        $doc->setValue('ocupacion_padre', $empleado->ocupacion_padre);
        $doc->setValue('telefono_madre', $empleado->telefono_madre);
        $doc->setValue('nombre_madre', $empleado->nombre_madre);
        $doc->setValue('ocupacion_madre', $empleado->ocupacion_madre);
        $doc->setValue('telefono_conviviente', $empleado->telefono_conviviente);
        $doc->setValue('nombre_conviviente', $empleado->nombre_conviviente);
        $doc->setValue('ocupacion_conviviente', $empleado->ocupacion_conviviente);
        $doc->setValue('hijos', '');
        $hijos = HijoEmpleado::where('empleados_id', $id_empleado)->get();
        

        $archivo = Str::random(40) . '.docx';
        $path = 'templates/procesed/' . $archivo;
        $doc->saveAs($path);
        $contents = file_get_contents($path);

        /* $phpWord = IOFactory::load('templates/procesed/formulario_' . $id_empleado . '.docx', 'Word2007');
        $phpWord->save('templates/procesed/formulario_' . $id_empleado . '.pdf', 'PDF'); */
        $ubicacion = 'requisitos/' . $archivo;
        Storage::disk('public')->put($ubicacion, $contents);

        /* unlink($path); */

        return $ubicacion;
    }
}
