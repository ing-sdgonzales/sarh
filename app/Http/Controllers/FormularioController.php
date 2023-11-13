<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\HijoEmpleado;
use App\Models\HistorialLaboral;
use App\Models\Idioma;
use App\Models\PersonaDependiente;
use App\Models\ProgramaComputacion;
use App\Models\ReferenciaLaboral;
use App\Models\ReferenciaPersonal;
use App\Models\RegistroAcademicoEmpleado;
use App\Models\RequisitoCandidato;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Settings;
use PhpOffice\PhpWord\TemplateProcessor;
use Illuminate\Support\Str;


class FormularioController extends Controller
{

    public function generarDoc($id_empleado, $user)
    {
        $niveles_educativos = ['primaria', 'secundaria', 'diversificado', 'universidad', 'maestría', 'otro'];
        $valores = [];

        $empleado = DB::table('empleados')
            ->join('direcciones', 'empleados.id', '=', 'direcciones.empleados_id')
            ->join('municipios as mun_residencia', 'direcciones.municipios_id', '=', 'mun_residencia.id')
            ->join('departamentos as dep_residencia', 'mun_residencia.departamentos_id', '=', 'dep_residencia.id')
            ->join('municipios', 'empleados.municipios_id', '=', 'municipios.id')
            ->join('departamentos', 'municipios.departamentos_id', '=', 'departamentos.id')
            ->join('nacionalidades', 'empleados.nacionalidades_id', '=', 'nacionalidades.id')
            ->join('estados_civiles', 'empleados.estados_civiles_id', '=', 'estados_civiles.id')
            ->join('dpis', 'empleados.id', '=', 'dpis.empleados_id')
            ->join('municipios as mun_emision', 'dpis.municipios_id', '=', 'mun_emision.id')
            ->join('departamentos as dep_emision', 'mun_emision.departamentos_id', '=', 'dep_emision.id')
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
                'empleados.candidatos_id as id_candidato',
                'empleados.nit as nit',
                'empleados.igss as igss',
                'empleados.imagen as imagen',
                'empleados.nombres as nombres',
                'empleados.apellidos as apellidos',
                'empleados.email as email',
                'empleados.fecha_nacimiento as fecha_nacimiento',
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
                'empleados.otro_etnia as otro_etnia',
                'direcciones.id as id_direccion',
                'direcciones.direccion as residencia',
                'mun_residencia.id as id_municipio_residencia',
                'mun_residencia.nombre as municipio_residencia',
                'dep_residencia.id as id_departamento_residencia',
                'dep_residencia.nombre as departamento_residencia',
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

        $candidato = RequisitoCandidato::select(
            'requisitos_candidatos.fecha_carga as fecha_carga',
            'requisitos_candidatos.fecha_revision as fecha_revision',
            'catalogo_puestos.puesto as puesto'
        )
            ->join('puestos_nominales', 'requisitos_candidatos.puestos_nominales_id', '=', 'puestos_nominales.id')
            ->join('catalogo_puestos', 'puestos_nominales.catalogo_puestos_id', '=', 'catalogo_puestos.id')
            ->where('requisitos_candidatos.candidatos_id', $empleado->id_candidato)
            ->first();

        /* plantilla */
        $doc = new TemplateProcessor('templates/formulario.docx');
        Settings::setPdfRendererName(Settings::PDF_RENDERER_DOMPDF);
        Settings::setPdfRendererPath('.');


        /* campos a reemplazar en la plantilla (formulario) */
        $doc->setImageValue('foto', array('path' => 'storage/' . $empleado->imagen, 'width' => 100, 'height' => 125, 'ratio' => false));
        $doc->setValue('fecha_presentacion', $candidato->fecha_carga);
        $doc->setValue('municipio_residencia', $empleado->municipio_residencia);
        $doc->setValue('departamento_residencia', $empleado->departamento_residencia);
        $doc->setValue('nombres', $empleado->nombres);
        $doc->setValue('apellidos', $empleado->apellidos);
        $doc->setValue('puesto', $candidato->puesto);
        $doc->setValue('pretension_salarial', number_format($empleado->pretension_salarial, 2, '.', ','));
        $doc->setValue('municipio', $empleado->municipio);
        $doc->setValue('departamento', $empleado->departamento);
        $doc->setValue('fecha_nacimiento', date('d/m/Y', strtotime($empleado->fecha_nacimiento)));
        $doc->setValue('edad', $empleado->edad);
        $doc->setValue('nacionalidad', $empleado->nacionalidad);
        $doc->setValue('estado_civil', $empleado->estado_civil);
        $doc->setValue('residencia', $empleado->residencia);
        $doc->setValue('dpi', $empleado->dpi);
        $doc->setValue('mun_emision', $empleado->municipio_emision);
        $doc->setValue('dep_emision', $empleado->departamento_emision);
        $doc->setValue('igss', $empleado->igss);
        $doc->setValue('nit', $empleado->nit);
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
        $hijos = HijoEmpleado::where('empleados_id', $id_empleado)->get()->toArray();
        $doc->cloneRowAndSetValues('nombre', $hijos);
        $registros_academicos = RegistroAcademicoEmpleado::select(
            'registros_academicos_empleados.establecimiento as establecimiento',
            'registros_academicos_empleados.titulo as titulo',
            'registros_academicos.nivel as nivel'
        )
            ->join('registros_academicos', 'registros_academicos_empleados.registros_academicos_id', '=', 'registros_academicos.id')
            ->get();
        foreach ($niveles_educativos as $nivel_educativo) {
            $encontrado = false;
            foreach ($registros_academicos as $registro) {
                if (strtolower($registro->nivel) === $nivel_educativo) {
                    $encontrado = true;
                    $valores['e_' . $nivel_educativo] = $registro->establecimiento;
                    $valores['t_' . $nivel_educativo] = $registro->titulo;
                    break;
                }
            }
            if (!$encontrado) {
                $valores['e_' . $nivel_educativo] = '';
                $valores['t_' . $nivel_educativo] = '';
            }
        }
        foreach ($valores as $clave => $valor) {
            $doc->setValue($clave, $valor);
        }
        if ($empleado->estudia_actualmente == 1) {
            $doc->setValue('sea', 'X');
            $doc->setValue('nea', '');
        } else {
            $doc->setValue('sea', '');
            $doc->setValue('nea', 'X');
        }
        $doc->setValue('estudio_actual', $empleado->estudio_actual);
        $doc->setValue('horario_estudio_actual', $empleado->horario_estudio_actual);
        $doc->setValue('establecimiento_estudio_actual', $empleado->establecimiento_estudio_actual);
        if ($empleado->etnia == 'Xinca') {
            $doc->setValue('ge1', 'X');
            $doc->setValue('ge2', '');
            $doc->setValue('ge3', '');
            $doc->setValue('ge4', '');
        } elseif ($empleado->etnia == 'Garífuna') {
            $doc->setValue('ge1', '');
            $doc->setValue('ge2', 'X');
            $doc->setValue('ge3', '');
            $doc->setValue('ge4', '');
        } elseif ($empleado->etnia == 'Maya') {
            $doc->setValue('ge1', '');
            $doc->setValue('ge2', '');
            $doc->setValue('ge3', 'X');
            $doc->setValue('ge4', '');
        } elseif ($empleado->etnia == 'Ladino' || $empleado->etnia == 'Mestizo') {
            $doc->setValue('ge1', '');
            $doc->setValue('ge2', '');
            $doc->setValue('ge3', '');
            $doc->setValue('ge4', 'X');
        }
        $doc->setValue('otro_etnia', $empleado->otro_etnia);
        $idiomas = Idioma::where('empleados_id', $id_empleado)->get()->toArray();
        $doc->cloneRowAndSetValues('idioma', $idiomas);
        $programas = ProgramaComputacion::where('empleados_id', $id_empleado)->get()->toArray();
        foreach ($programas as &$programa) {
            if ($programa['valoracion'] == 1) {
                $programa['val1'] = 'X';
                $programa['val2'] = '';
                $programa['val3'] = '';
                $programa['val4'] = '';
            } elseif ($programa['valoracion'] == 2) {
                $programa['val1'] = '';
                $programa['val2'] = 'X';
                $programa['val3'] = '';
                $programa['val4'] = '';
            } elseif ($programa['valoracion'] == 3) {
                $programa['val1'] = '';
                $programa['val2'] = '';
                $programa['val3'] = 'X';
                $programa['val4'] = '';
            } elseif ($programa['valoracion'] == 4) {
                $programa['val1'] = '';
                $programa['val2'] = '';
                $programa['val3'] = '';
                $programa['val4'] = 'X';
            }
            unset($programa['valoracion']);
        }
        $doc->cloneRowAndSetValues('programa', $programas);
        $historiales_laborales = HistorialLaboral::where('empleados_id', $id_empleado)->orderBy('hasta', 'desc')->get();
        if (count($historiales_laborales) > 0) {
            $doc->setValue('empresa1', $historiales_laborales[0]->empresa);
            $doc->setValue('direccion1', $historiales_laborales[0]->direccion);
            $doc->setValue('telefono1', $historiales_laborales[0]->telefono);
            $doc->setValue('jefe_inmediato1', $historiales_laborales[0]->jefe_inmediato);
            $doc->setValue('cargo1', $historiales_laborales[0]->cargo);
            $doc->setValue('desde1', date('d/m/Y', strtotime($historiales_laborales[0]->desde)));
            $doc->setValue('hasta1', date('d/m/Y', strtotime($historiales_laborales[0]->hasta)));
            $doc->setValue('ultimo_sueldo1', 'Q ' . number_format($historiales_laborales[0]->ultimo_sueldo, 2, '.', ','));
            $doc->setValue('motivo_salida1', $historiales_laborales[0]->motivo_salida);
            if ($historiales_laborales[0]->verificar_informacion == 1) {
                $doc->setValue('shl1vi', 'X');
                $doc->setValue('nhl1vi', '');
            } else {
                $doc->setValue('shl1vi', '');
                $doc->setValue('nhl1vi', 'X');
            }
            $doc->setValue('razon_informacion1', $historiales_laborales[0]->razon_informacion);

            if (count($historiales_laborales) > 1) {
                $doc->setValue('empresa2', $historiales_laborales[1]->empresa);
                $doc->setValue('direccion2', $historiales_laborales[1]->direccion);
                $doc->setValue('telefono2', $historiales_laborales[1]->telefono);
                $doc->setValue('jefe_inmediato2', $historiales_laborales[1]->jefe_inmediato);
                $doc->setValue('cargo2', $historiales_laborales[1]->cargo);
                $doc->setValue('desde2', date('d/m/Y', strtotime($historiales_laborales[1]->desde)));
                $doc->setValue('hasta2', date('d/m/Y', strtotime($historiales_laborales[1]->hasta)));
                $doc->setValue('ultimo_sueldo2', 'Q ' . number_format($historiales_laborales[1]->ultimo_sueldo, 2, '.', ','));
                $doc->setValue('motivo_salida2', $historiales_laborales[1]->motivo_salida);
                if ($historiales_laborales[1]->verificar_informacion == 1) {
                    $doc->setValue('shl2vi', 'X');
                    $doc->setValue('nhl2vi', '');
                } else {
                    $doc->setValue('shl2vi', '');
                    $doc->setValue('nhl2vi', 'X');
                }
                $doc->setValue('razon_informacion2', $historiales_laborales[1]->razon_informacion);
            } else {
                $doc->setValue('empresa2', '');
                $doc->setValue('direccion2', '');
                $doc->setValue('telefono2', '');
                $doc->setValue('jefe_inmediato2', '');
                $doc->setValue('cargo2', '');
                $doc->setValue('desde2', '');
                $doc->setValue('hasta2', '');
                $doc->setValue('ultimo_sueldo2', '');
                $doc->setValue('motivo_salida2', '');
                $doc->setValue('shl2vi', '');
                $doc->setValue('nhl2vi', '');
                $doc->setValue('razon_informacion2', '');
            }

            if (count($historiales_laborales) > 2) {
                $doc->setValue('empresa3', $historiales_laborales[2]->empresa);
                $doc->setValue('direccion3', $historiales_laborales[2]->direccion);
                $doc->setValue('telefono3', $historiales_laborales[2]->telefono);
                $doc->setValue('jefe_inmediato3', $historiales_laborales[2]->jefe_inmediato);
                $doc->setValue('cargo3', $historiales_laborales[2]->cargo);
                $doc->setValue('desde3', date('d/m/Y', strtotime($historiales_laborales[2]->desde)));
                $doc->setValue('hasta3', date('d/m/Y', strtotime($historiales_laborales[2]->hasta)));
                $doc->setValue('ultimo_sueldo3', 'Q ' . number_format($historiales_laborales[2]->ultimo_sueldo, 3, '.', ','));
                $doc->setValue('motivo_salida3', $historiales_laborales[2]->motivo_salida);
                if ($historiales_laborales[2]->verificar_informacion == 1) {
                    $doc->setValue('shl3vi', 'X');
                    $doc->setValue('nhl3vi', '');
                } else {
                    $doc->setValue('shl3vi', '');
                    $doc->setValue('nhl3vi', 'X');
                }
                $doc->setValue('razon_informacion3', $historiales_laborales[2]->razon_informacion);
            } else {
                $doc->setValue('empresa3', '');
                $doc->setValue('direccion3', '');
                $doc->setValue('telefono3', '');
                $doc->setValue('jefe_inmediato3', '');
                $doc->setValue('cargo3', '');
                $doc->setValue('desde3', '');
                $doc->setValue('hasta3', '');
                $doc->setValue('ultimo_sueldo3', '');
                $doc->setValue('motivo_salida3', '');
                $doc->setValue('shl3vi', '');
                $doc->setValue('nhl3vi', '');
                $doc->setValue('razon_informacion3', '');
            }
        } else {
            $doc->setValue('empresa1', '');
            $doc->setValue('direccion1', '');
            $doc->setValue('telefono1', '');
            $doc->setValue('jefe_inmediato1', '');
            $doc->setValue('cargo1', '');
            $doc->setValue('desde1', '');
            $doc->setValue('hasta1', '');
            $doc->setValue('ultimo_sueldo1', '');
            $doc->setValue('motivo_salida1', '');
            $doc->setValue('shl1vi', '');
            $doc->setValue('nhl1vi', '');
            $doc->setValue('razon_informacion1', '');
            $doc->setValue('empresa2', '');
            $doc->setValue('direccion2', '');
            $doc->setValue('telefono2', '');
            $doc->setValue('jefe_inmediato2', '');
            $doc->setValue('cargo2', '');
            $doc->setValue('desde2', '');
            $doc->setValue('hasta2', '');
            $doc->setValue('ultimo_sueldo2', '');
            $doc->setValue('motivo_salida2', '');
            $doc->setValue('shl2vi', '');
            $doc->setValue('nhl2vi', '');
            $doc->setValue('razon_informacion2', '');
            $doc->setValue('empresa3', '');
            $doc->setValue('direccion3', '');
            $doc->setValue('telefono3', '');
            $doc->setValue('jefe_inmediato3', '');
            $doc->setValue('cargo3', '');
            $doc->setValue('desde3', '');
            $doc->setValue('hasta3', '');
            $doc->setValue('ultimo_sueldo3', '');
            $doc->setValue('motivo_salida3', '');
            $doc->setValue('shl3vi', '');
            $doc->setValue('nhl3vi', '');
            $doc->setValue('razon_informacion3', '');
        }
        $referencias_personales = ReferenciaPersonal::select(
            'nombre as rp_nombre',
            'lugar_trabajo as rp_lugar_trabajo',
            'telefono as rp_tel'
        )
            ->where('empleados_id', $id_empleado)
            ->get()
            ->toArray();
        $doc->cloneRowAndSetValues('rp_nombre', $referencias_personales);

        $referencias_laborales = ReferenciaLaboral::select(
            'nombre as rl_nombre',
            'empresa as rl_empresa',
            'telefono as rl_tel'
        )
            ->where('empleados_id', $id_empleado)
            ->get()
            ->toArray();
        $doc->cloneRowAndSetValues('rl_nombre', $referencias_laborales);
        $doc->setValue('tipo_vivienda', $empleado->tipo_vivienda);
        $doc->setValue('pago_vivienda', 'Q ' . number_format($empleado->pago_vivienda, 2, '.', ','));
        $doc->setValue('cant_personas_dependientes', $empleado->cantidad_personas_dependientes);
        $personas_dependientes = PersonaDependiente::select(
            'nombre as pd_nombre',
            'parentesco'
        )
            ->where('empleados_id', $id_empleado)
            ->get()
            ->toArray();
        $doc->cloneRowAndSetValues('pd_nombre', $personas_dependientes);
        if ($empleado->ingresos_adicionales == 1) {
            $doc->setValue('singresos_adicionales', 'X');
            $doc->setValue('ningresos_adicionales', '');
        } else {
            $doc->setValue('singresos_adicionales', '');
            $doc->setValue('ningresos_adicionales', 'X');
        }

        $doc->setValue('fuente_ingresos_adicionales', $empleado->fuente_ingresos_adicionales);
        $doc->setValue('personas_aportan_ingresos', $empleado->personas_aportan_ingresos);
        if ($empleado->monto_ingreso_total > 0) {
            $doc->setValue('monto_ingreso_total', 'Q ' . number_format($empleado->monto_ingreso_total, 2, '.', ','));
        } else {
            $doc->setValue('monto_ingreso_total', '');
        }


        if ($empleado->posee_deudas == 1) {
            $doc->setValue('sposee_deuda', 'X');
            $doc->setValue('nposee_deuda', '');
        } else {
            $doc->setValue('sposee_deuda', '');
            $doc->setValue('nposee_deuda', 'X');
        }
        if ($empleado->posee_deudas == 1) {
            if ($empleado->tipo_deuda == 'Banco') {
                $doc->setValue('deuda_banco', 'X');
                $doc->setValue('deuda_vehiculo', '');
                $doc->setValue('deuda_prestamo', '');
                $doc->setValue('otro_deuda', '');
            } elseif ($empleado->tipo_deuda == 'Vehículo') {
                $doc->setValue('deuda_banco', '');
                $doc->setValue('deuda_vehiculo', 'X');
                $doc->setValue('deuda_prestamo', '');
                $doc->setValue('otro_deuda', '');
            } elseif ($empleado->tipo_deuda == 'Prestamo') {
                $doc->setValue('deuda_banco', '');
                $doc->setValue('deuda_vehiculo', '');
                $doc->setValue('deuda_prestamo', 'X');
                $doc->setValue('otro_deuda', '');
            } elseif ($empleado->tipo_deuda == 'Otro') {
                $doc->setValue('deuda_banco', '');
                $doc->setValue('deuda_vehiculo', '');
                $doc->setValue('deuda_prestamo', '');
                $doc->setValue('otro_deuda', 'X');
            }
            $doc->setValue('monto_deuda', 'Q ' . number_format($empleado->monto_deuda, 2, '.', ','));
        } else {
            $doc->setValue('deuda_banco', '');
            $doc->setValue('deuda_vehiculo', '');
            $doc->setValue('deuda_prestamo', '');
            $doc->setValue('otro_deuda', '');
            $doc->setValue('monto_deuda', '');
        }

        if ($empleado->trabajo_conred == 1) {
            $doc->setValue('strabajo_conred', 'X');
            $doc->setValue('ntrabajo_conred', '');
        } else {
            $doc->setValue('strabajo_conred', '');
            $doc->setValue('ntrabajo_conred', 'X');
        }

        if ($empleado->trabajo_estado == 1) {
            $doc->setValue('strabajo_estado', 'X');
            $doc->setValue('ntrabajo_estado', '');
        } else {
            $doc->setValue('strabajo_estado', '');
            $doc->setValue('ntrabajo_estado', 'X');
        }

        if ($empleado->jubilado_estado == 1) {
            $doc->setValue('sjubilado_estado', 'X');
            $doc->setValue('njubilado_estado', '');
        } else {
            $doc->setValue('sjubilado_estado', '');
            $doc->setValue('njubilado_estado', 'X');
        }
        $doc->setValue('institucion_jubilacion', $empleado->institucion_jubilacion);

        if ($empleado->padecimiento_salud == 1) {
            $doc->setValue('spadecimiento_salud', 'X');
            $doc->setValue('npadecimiento_salud', '');
            $doc->setValue('tipo_enfermedad', $empleado->tipo_enfermedad);
        } else {
            $doc->setValue('spadecimiento_salud', '');
            $doc->setValue('npadecimiento_salud', 'X');
            $doc->setValue('tipo_enfermedad', '');
        }


        if ($empleado->intervencion_quirurgica == 1) {
            $doc->setValue('sintervencion_quirurgica', 'X');
            $doc->setValue('nintervencion_quirurgica', '');
            $doc->setValue('tipo_intervencion', $empleado->tipo_intervencion);
        } else {
            $doc->setValue('sintervencion_quirurgica', '');
            $doc->setValue('nintervencion_quirurgica', 'X');
            $doc->setValue('tipo_intervencion', '___________________');
        }

        if ($empleado->sufrido_accidente == 1) {
            $doc->setValue('ssufrido_accidente', 'X');
            $doc->setValue('nsufrido_accidente', '');
            $doc->setValue('tipo_accidente', $empleado->tipo_accidente);
        } else {
            $doc->setValue('ssufrido_accidente', '');
            $doc->setValue('nsufrido_accidente', 'X');
            $doc->setValue('tipo_accidente', '___________________');
        }


        if ($empleado->alergia_medicamento == 1) {
            $doc->setValue('salergia_medicamento', 'X');
            $doc->setValue('nalergia_medicamento', '');
            $doc->setValue('tipo_medicamento', $empleado->tipo_medicamento);
        } else {
            $doc->setValue('salergia_medicamento', '');
            $doc->setValue('nalergia_medicamento', 'X');
            $doc->setValue('tipo_medicamento', '___________________');
        }

        $doc->setValue('tipo_sangre', $empleado->tipo_sangre);
        $doc->setValue('nombre_contacto_emergencia', $empleado->nombre_contacto_emergencia);
        $doc->setValue('dir_contacto_emergencia', $empleado->direccion_contacto_emergencia);
        $doc->setValue('ce_tel', $empleado->telefono_contacto_emergencia);

        $doc->setValue('user', $user);
        $doc->setValue('fecha_revision', date('d-m-Y H:m:s', strtotime($candidato->fecha_revision)));

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
