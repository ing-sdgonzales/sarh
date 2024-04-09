<?php

namespace App\Http\Controllers;

use App\Models\PirDireccion;
use App\Models\PirEmpleado;
use App\Models\PirSeccion;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class EstadoFuerzaController extends Controller
{
    public function generarFormularioPIR($id_direccion, $region)
    {
        if (!empty($region)) {
            $personal = PirEmpleado::select(
                'pir_empleados.nombre',
                'pir_empleados.observacion',
                'pir_empleados.pir_reporte_id',
                'pir_reportes.reporte as reporte',
                'pir_empleados.pir_grupo_id',
                'pir_grupos.grupo as grupo',
                'pir_direcciones.direccion as direccion'
            )
                ->join('pir_puestos', 'pir_empleados.id', '=', 'pir_puestos.pir_empleado_id')
                ->join('catalogo_puestos', 'pir_puestos.catalogo_puesto_id', '=', 'catalogo_puestos.id')
                ->join('renglones', 'catalogo_puestos.renglones_id', '=', 'renglones.id')
                ->join('pir_reportes', 'pir_empleados.pir_reporte_id', '=', 'pir_reportes.id')
                ->join('pir_grupos', 'pir_empleados.pir_grupo_id', '=', 'pir_grupos.id')
                ->join('pir_direcciones', 'pir_empleados.pir_direccion_id', '=', 'pir_direcciones.id')
                ->join('departamentos', 'pir_empleados.departamento_id', '=', 'departamentos.id')
                ->join('regiones', 'pir_empleados.region_id', '=', 'regiones.id')
                ->where('regiones.region', $region)
                ->whereIn('renglones.renglon', ['011', '021', '022', '031'])
                ->where('pir_empleados.activo', 1)
                ->orderBy('pir_empleados.nombre')
                ->get();

            $contratista = PirEmpleado::select(
                'pir_empleados.nombre',
                'pir_empleados.observacion',
                'pir_empleados.pir_reporte_id',
                'pir_reportes.reporte as reporte',
                'pir_empleados.pir_grupo_id',
                'pir_grupos.grupo as grupo',
                'pir_direcciones.direccion as direccion'
            )
                ->join('pir_puestos', 'pir_empleados.id', '=', 'pir_puestos.pir_empleado_id')
                ->join('catalogo_puestos', 'pir_puestos.catalogo_puesto_id', '=', 'catalogo_puestos.id')
                ->join('renglones', 'catalogo_puestos.renglones_id', '=', 'renglones.id')
                ->join('pir_reportes', 'pir_empleados.pir_reporte_id', '=', 'pir_reportes.id')
                ->join('pir_grupos', 'pir_empleados.pir_grupo_id', '=', 'pir_grupos.id')
                ->join('pir_direcciones', 'pir_empleados.pir_direccion_id', '=', 'pir_direcciones.id')
                ->join('departamentos', 'pir_empleados.departamento_id', '=', 'departamentos.id')
                ->join('regiones', 'pir_empleados.region_id', '=', 'regiones.id')
                ->where('renglones.renglon', '029')
                ->where('pir_empleados.activo', 1)
                ->where('regiones.region', $region)
                ->orderBy('pir_empleados.nombre')
                ->get();

            $fecha = date('d/m/Y');
            $hora = date('H:i:s');
            $fecha_hora = date('Y_m_d H_i_s');

            /* PLANTILLA */
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('templates/pir001_regionales.xlsx');
            $doc = $spreadsheet->getActiveSheet();
            $doc->getCell('B3')->setValue('INFORME DE ESTADO DE FUERZA - ' . $region);
            $doc->getCell('C6')->setValue($fecha);
            $doc->getCell('G6')->setValue($hora);
            $fila = 31 + ((count($personal) + count($contratista)) - 4);

            $fila_inicial_personal = 19;
            $fila_inicial_contratistas = 25;

            if (count($personal) > 2) {
                $doc->insertNewRowBefore($fila_inicial_personal + 1, count($personal) - 2);
                $fila_inicial_contratistas += count($personal) - 2;
            } elseif (count($personal) == 1) {
                $doc->removeRow($fila_inicial_personal);
            } elseif (count($personal) == 0) {
                $doc->removeRow($fila_inicial_personal, 2);
            }

            if (count($contratista) > 2) {
                $doc->insertNewRowBefore($fila_inicial_contratistas + 1, count($contratista) - 2);
            } elseif (count($contratista) == 1) {
                $doc->removeRow($fila_inicial_contratistas);
            } elseif (count($contratista) == 0) {
                $doc->removeRow($fila_inicial_contratistas, 2);
            }

            foreach (range($fila_inicial_personal, count($personal) - 2) as $row) {
                $doc->getRowDimension($row)->setRowHeight(-1);
            }

            foreach (range($fila_inicial_contratistas, count($contratista) - 2) as $row) {
                $doc->getRowDimension($row)->setRowHeight(-1);
            }

            foreach ($personal as $indice => $emp) {
                $fila_actual = $fila_inicial_personal + $indice;
                $doc->getCell('A' . $fila_actual)->setValue($indice + 1);
                $doc->getCell('B' . $fila_actual)->setValue($emp->nombre);
                $doc->getCell('C' . $fila_actual)->setValue($emp->direccion);
                switch ($emp->reporte) {
                    case 'Presente en sedes':
                        $doc->getCell('E' . $fila_actual)->setValue('X');
                        break;
                    case 'Comisión':
                        $doc->getCell('F' . $fila_actual)->setValue('X');
                        break;
                    case 'Capacitación en el extranjero':
                        $doc->getCell('G' . $fila_actual)->setValue('X');
                        break;
                    default:
                        $doc->getCell('H' . $fila_actual)->setValue('X');
                        break;
                }
                $doc->getCell('I' . $fila_actual)->setValue($emp->grupo);
                $doc->getCell('J' . $fila_actual)->setValue($emp->observacion);
            }

            foreach ($contratista as $indice => $emp) {
                $fila_actual = $fila_inicial_contratistas + $indice;
                $doc->getCell('A' . $fila_actual)->setValue($indice + 1);
                $doc->getCell('B' . $fila_actual)->setValue($emp->nombre);
                $doc->getCell('C' . $fila_actual)->setValue($emp->direccion);
                switch ($emp->reporte) {
                    case 'Presente en sedes':
                        $doc->getCell('E' . $fila_actual)->setValue('X');
                        break;
                    case 'Comisión':
                        $doc->getCell('F' . $fila_actual)->setValue('X');
                        break;
                    case 'Permiso autorizado' || 'Capacitación en el extranjero':
                        $doc->getCell('G' . $fila_actual)->setValue('X');
                        break;
                    default:
                        $doc->getCell('H' . $fila_actual)->setValue('X');
                        break;
                }
                $doc->getCell('I' . $fila_actual)->setValue($emp->grupo);
                $doc->getCell('J' . $fila_actual)->setValue($emp->observacion);
            }
            $doc->getCell('C' . $fila)->setValue($region);
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');

            if (!Storage::exists('templates/procesed/')) {
                Storage::makeDirectory('templates/procesed/');
            }

            $writer->save('templates/procesed/' . $fecha_hora . '_PIR.xlsx');

            // Descargar el archivo
            return 'templates/procesed/' . $fecha_hora . '_PIR.xlsx';
        } else {

            $direccion = PirDireccion::findOrFail($id_direccion);
            $seccion = PirSeccion::findOrFail($direccion->pir_seccion_id);

            $personal = PirEmpleado::select(
                'pir_empleados.nombre',
                'pir_empleados.observacion',
                'pir_empleados.pir_reporte_id',
                'pir_reportes.reporte as reporte',
                'pir_empleados.pir_grupo_id',
                'pir_grupos.grupo as grupo'
            )
                ->join('pir_puestos', 'pir_empleados.id', '=', 'pir_puestos.pir_empleado_id')
                ->join('catalogo_puestos', 'pir_puestos.catalogo_puesto_id', '=', 'catalogo_puestos.id')
                ->join('renglones', 'catalogo_puestos.renglones_id', '=', 'renglones.id')
                ->join('pir_reportes', 'pir_empleados.pir_reporte_id', '=', 'pir_reportes.id')
                ->join('pir_grupos', 'pir_empleados.pir_grupo_id', '=', 'pir_grupos.id')
                ->where('pir_direccion_id', $id_direccion)
                ->where('pir_empleados.activo', 1)
                ->whereIn('renglones.renglon', ['011', '021', '022', '031'])
                ->orderBy('pir_empleados.id', 'asc')
                ->get();

            $contratista = PirEmpleado::select(
                'pir_empleados.nombre',
                'pir_empleados.observacion',
                'pir_empleados.pir_reporte_id',
                'pir_reportes.reporte as reporte',
                'pir_empleados.pir_grupo_id',
                'pir_grupos.grupo as grupo'
            )
                ->join('pir_puestos', 'pir_empleados.id', '=', 'pir_puestos.pir_empleado_id')
                ->join('catalogo_puestos', 'pir_puestos.catalogo_puesto_id', '=', 'catalogo_puestos.id')
                ->join('renglones', 'catalogo_puestos.renglones_id', '=', 'renglones.id')
                ->join('pir_reportes', 'pir_empleados.pir_reporte_id', '=', 'pir_reportes.id')
                ->join('pir_grupos', 'pir_empleados.pir_grupo_id', '=', 'pir_grupos.id')
                ->where('pir_direccion_id', $id_direccion)
                ->where('pir_empleados.activo', 1)
                ->where('renglones.renglon', '029')
                ->orderBy('pir_empleados.id', 'asc')
                ->get();

            $fecha = date('d/m/Y');
            $hora = date('H:i:s');
            $fecha_hora = date('Y_m_d H_i_s');

            /* PLANTILLA */
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('templates/pir001.xlsx');
            $doc = $spreadsheet->getActiveSheet();
            $doc->getCell('C6')->setValue($fecha);
            $doc->getCell('G6')->setValue($hora);
            $doc->getCell('C19')->setValue($direccion->direccion);
            $doc->getCell('D19')->setValue($seccion->seccion);
            $fila = 31 + ((count($personal) + count($contratista)) - 4);

            switch ($seccion->seccion) {
                case 'Comando':
                    $doc->getCell('B9')->setValue('X');
                    break;
                case 'Información':
                    $doc->getCell('C9')->setValue('X');
                    break;
                case 'Enlace':
                    $doc->getCell('D9')->setValue('X');
                    break;
                case 'Seguridad':
                    $doc->getCell('E9')->setValue('X');
                    break;
                case 'Jurídico':
                    $doc->getCell('F9')->setValue('X');
                    break;
                case 'Protocolo':
                    $doc->getCell('G9')->setValue('X');
                    break;
                case 'Inspectoría':
                    $doc->getCell('H9')->setValue('X');
                    break;
                case 'Auditoría':
                    $doc->getCell('I9')->setValue('X');
                    break;
                case 'Operaciones Estratégicas':
                    $doc->getCell('C12')->setValue('X');
                    break;
                case 'Operaciones Tácticas':
                    $doc->getCell('D12')->setValue('X');
                    break;
                case 'Logística':
                    $doc->getCell('E12')->setValue('X');
                    break;
                case 'Planificación':
                    $doc->getCell('F12')->setValue('X');
                    break;
                case 'Administración y Finanzas':
                    $doc->getCell('G12')->setValue('X');
                    break;
            }

            $fila_inicial_personal = 19;
            $fila_inicial_contratistas = 25;

            if (count($personal) > 2) {
                $doc->insertNewRowBefore($fila_inicial_personal + 1, count($personal) - 2);
                $fila_inicial_contratistas += count($personal) - 2;
            } elseif (count($personal) == 1) {
                $doc->removeRow($fila_inicial_personal);
            }

            if (count($contratista) > 2) {
                $doc->insertNewRowBefore($fila_inicial_contratistas + 1, count($contratista) - 2);
            } elseif (count($contratista) == 1) {
                $doc->removeRow($fila_inicial_contratistas);
            }

            foreach (range($fila_inicial_personal, count($personal) - 2) as $row) {
                $doc->getRowDimension($row)->setRowHeight(-1);
            }

            foreach (range($fila_inicial_contratistas, count($contratista) - 2) as $row) {
                $doc->getRowDimension($row)->setRowHeight(-1);
            }

            foreach ($personal as $indice => $emp) {
                $fila_actual = $fila_inicial_personal + $indice;
                $doc->getCell('A' . $fila_actual)->setValue($indice + 1);
                $doc->getCell('B' . $fila_actual)->setValue($emp->nombre);
                switch ($emp->reporte) {
                    case 'Presente en sedes':
                        $doc->getCell('E' . $fila_actual)->setValue('X');
                        break;
                    case 'Comisión':
                        $doc->getCell('F' . $fila_actual)->setValue('X');
                        break;
                    case 'Capacitación en el extranjero':
                        $doc->getCell('G' . $fila_actual)->setValue('X');
                        break;
                    default:
                        $doc->getCell('H' . $fila_actual)->setValue('X');
                        break;
                }
                $doc->getCell('I' . $fila_actual)->setValue($emp->grupo);
                $doc->getCell('J' . $fila_actual)->setValue($emp->observacion);
            }

            foreach ($contratista as $indice => $emp) {
                $fila_actual = $fila_inicial_contratistas + $indice;
                $doc->getCell('A' . $fila_actual)->setValue($indice + 1);
                $doc->getCell('B' . $fila_actual)->setValue($emp->nombre);
                switch ($emp->reporte) {
                    case 'Presente en sedes':
                        $doc->getCell('E' . $fila_actual)->setValue('X');
                        break;
                    case 'Comisión':
                        $doc->getCell('F' . $fila_actual)->setValue('X');
                        break;
                    case 'Permiso autorizado' || 'Capacitación en el extranjero':
                        $doc->getCell('G' . $fila_actual)->setValue('X');
                        break;
                    default:
                        $doc->getCell('H' . $fila_actual)->setValue('X');
                        break;
                }
                $doc->getCell('I' . $fila_actual)->setValue($emp->grupo);
                $doc->getCell('J' . $fila_actual)->setValue($emp->observacion);
            }
            $doc->getCell('C' . (25 + count($personal) - 2))->setValue($direccion->direccion);
            $doc->getCell('D' . (25 + count($personal) - 2))->setValue($seccion->seccion);
            $doc->getCell('C' . $fila)->setValue($direccion->direccion);
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');

            if (!Storage::exists('templates/procesed/')) {
                Storage::makeDirectory('templates/procesed/');
            }

            $writer->save('templates/procesed/' . $fecha_hora . '_PIR.xlsx');

            // Descargar el archivo
            return 'templates/procesed/' . $fecha_hora . '_PIR.xlsx';
            /* return response()->download('templates/procesed/pir_' . $fecha_hora . '.xlsx')->deleteFileAfterSend(true); */
        }
    }

    public function generateDisponibilidadReport($id_direccion, $region)
    {

        $personal = PirEmpleado::select(
            'pir_empleados.nombre',
            'pir_empleados.observacion',
            'pir_empleados.pir_reporte_id',
            'pir_reportes.reporte as reporte',
            'pir_empleados.pir_grupo_id',
            'pir_grupos.grupo as grupo',
            'pir_direcciones.direccion as direccion',
            'regiones.region as region',
            'departamentos.nombre as departamento',
            'catalogo_puestos.puesto as puesto',
            'renglones.renglon as renglon'
        )
            ->join('pir_puestos', 'pir_empleados.id', '=', 'pir_puestos.pir_empleado_id')
            ->join('catalogo_puestos', 'pir_puestos.catalogo_puesto_id', '=', 'catalogo_puestos.id')
            ->join('renglones', 'catalogo_puestos.renglones_id', '=', 'renglones.id')
            ->join('pir_reportes', 'pir_empleados.pir_reporte_id', '=', 'pir_reportes.id')
            ->join('pir_grupos', 'pir_empleados.pir_grupo_id', '=', 'pir_grupos.id')
            ->join('pir_direcciones', 'pir_empleados.pir_direccion_id', '=', 'pir_direcciones.id')
            ->join('departamentos', 'pir_empleados.departamento_id', '=', 'departamentos.id')
            ->join('regiones', 'pir_empleados.region_id', '=', 'regiones.id');

        $contratista = PirEmpleado::select(
            'pir_empleados.nombre',
            'pir_empleados.observacion',
            'pir_empleados.pir_reporte_id',
            'pir_reportes.reporte as reporte',
            'pir_empleados.pir_grupo_id',
            'pir_grupos.grupo as grupo',
            'catalogo_puestos.puesto as puesto',
            'regiones.region as region',
            'departamentos.nombre as departamento',
            'pir_direcciones.direccion as direccion',
            'renglones.renglon as renglon'
        )
            ->join('pir_puestos', 'pir_empleados.id', '=', 'pir_puestos.pir_empleado_id')
            ->join('catalogo_puestos', 'pir_puestos.catalogo_puesto_id', '=', 'catalogo_puestos.id')
            ->join('renglones', 'catalogo_puestos.renglones_id', '=', 'renglones.id')
            ->join('pir_reportes', 'pir_empleados.pir_reporte_id', '=', 'pir_reportes.id')
            ->join('pir_grupos', 'pir_empleados.pir_grupo_id', '=', 'pir_grupos.id')
            ->join('pir_direcciones', 'pir_empleados.pir_direccion_id', '=', 'pir_direcciones.id')
            ->join('departamentos', 'pir_empleados.departamento_id', '=', 'departamentos.id')
            ->join('regiones', 'pir_empleados.region_id', '=', 'regiones.id');

        if (!empty($region)) {
            $direccion = PirDireccion::where('direccion', $region)->first();
            $personal = $personal->where('region', $region);
            $contratista = $contratista->where('region', $region);
        } else {
            $direccion = PirDireccion::findOrFail($id_direccion);
            $personal = $personal->where('pir_direccion_id', $id_direccion);
            $contratista = $contratista->where('pir_direccion_id', $id_direccion);
        }

        $personal = $personal->whereIn('renglones.renglon', ['011', '021', '022', '031'])->where('pir_empleados.activo', 1)->get();
        $contratista = $contratista->where('renglones.renglon', '029')->where('pir_empleados.activo', 1)->orderBy('pir_empleados.id', 'asc')->get();

        $fecha = date('d/m/Y');
        $hora = date('H:i:s');
        $fecha_hora = date('Y_m_d H_i_s');

        /* PLANTILLA */
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('templates/disponibilidad.xlsx');
        $formatoPersonal = $spreadsheet->setActiveSheetIndexByName('Personal');
        $formatoContratista = $spreadsheet->setActiveSheetIndexByName('Contratistas');

        $formatoPersonal->getCell('A4')->setValue($direccion->direccion);
        $formatoPersonal->getCell('B6')->setValue($fecha);
        $formatoPersonal->getCell('E6')->setValue($hora);

        $formatoContratista->getCell('A4')->setValue($direccion->direccion);
        $formatoContratista->getCell('B7')->setValue($fecha);
        $formatoContratista->getCell('E7')->setValue($hora);

        $fila_inicial_personal = 8;
        $fila_inicial_contratistas = 9;

        if (count($personal) > 2) {
            $formatoPersonal->insertNewRowBefore($fila_inicial_personal + 1, count($personal) - 2);
        } elseif (count($personal) == 1) {
            $formatoPersonal->removeRow($fila_inicial_personal);
        }

        if (count($contratista) > 2) {
            $formatoContratista->insertNewRowBefore($fila_inicial_contratistas + 1, count($contratista) - 2);
        } elseif (count($contratista) == 1) {
            $formatoContratista->removeRow($fila_inicial_contratistas);
        }

        foreach ($personal as $indice => $emp) {
            $fila_actual = $fila_inicial_personal + $indice;
            $formatoPersonal->getCell('A' . $fila_actual)->setValue($indice + 1);
            $formatoPersonal->getCell('B' . $fila_actual)->setValue($emp->nombre);
            $formatoPersonal->getCell('C' . $fila_actual)->setValue($emp->renglon);
            $formatoPersonal->getCell('D' . $fila_actual)->setValue($emp->puesto);
            $formatoPersonal->getCell('E' . $fila_actual)->setValue($emp->direccion);
            $cadena = explode(' ', $emp->region);
            $formatoPersonal->getCell('F' . $fila_actual)->setValue($cadena[1]);
            $formatoPersonal->getCell('G' . $fila_actual)->setValue($emp->departamento);
            $formatoPersonal->getCell('H' . $fila_actual)->setValue($emp->pir_reporte_id);
            $formatoPersonal->getCell('I' . $fila_actual)->setValue($emp->observacion);
        }

        foreach ($contratista as $indice => $emp) {
            $fila_actual = $fila_inicial_contratistas + $indice;
            $formatoContratista->getCell('A' . $fila_actual)->setValue($indice + 1);
            $formatoContratista->getCell('B' . $fila_actual)->setValue($emp->nombre);
            $formatoContratista->getCell('C' . $fila_actual)->setValue($emp->renglon);
            $formatoContratista->getCell('D' . $fila_actual)->setValue($emp->puesto);
            $cadena = explode(' ', $emp->region);
            $formatoContratista->getCell('E' . $fila_actual)->setValue($emp->direccion);
            $formatoContratista->getCell('F' . $fila_actual)->setValue($cadena[1]);
            $formatoContratista->getCell('G' . $fila_actual)->setValue($emp->departamento);
            switch ($emp->reporte) {
                case 'Presente en sedes':
                    $formatoContratista->getCell('H' . $fila_actual)->setValue(1);
                    break;
                case 'Suspendidos por el IGSS':
                case 'Suspendidos por la Clínica Médica':
                    $formatoContratista->getCell('H' . $fila_actual)->setValue(2);
                    break;
                case 'Comisión':
                    $formatoContratista->getCell('H' . $fila_actual)->setValue(3);
                    break;
                case 'Capacitación en el extranjero':
                    $formatoContratista->getCell('H' . $fila_actual)->setValue(4);
                    break;
                default:
                    $formatoContratista->getCell('H' . $fila_actual)->setValue(5);
                    break;
            }
            $formatoContratista->getCell('I' . $fila_actual)->setValue($emp->observacion);
        }

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');

        if (!Storage::exists('templates/procesed/')) {
            Storage::makeDirectory('templates/procesed/');
        }

        $writer->save('templates/procesed/' . $fecha_hora . '_DISPONIBILIDAD.xlsx');

        // Descargar el archivo
        return 'templates/procesed/' . $fecha_hora . '_DISPONIBILIDAD.xlsx';
    }

    public function generarReporteDiario()
    {
        $dia_actual = date('Y-m-d');
        $fecha = Carbon::now()->translatedFormat('l, d \\de F \\de Y');
        $fecha_hora = date('Y_m_d H_i_s');

        $orden_direcciones = [1, 13, 9, 8, 12, 15, 14, 11, 2, 6, 4, 5, 7, 10, 22, 3, 16, 18, 17, 20, 19, 21];

        $direcciones = PirDireccion::select(
            'pir_direcciones.id as id_direccion',
            'pir_direcciones.direccion as direccion',
            'pir_direcciones.hora_actualizacion as actualizacion'
        )
            ->selectRaw('COUNT(CASE WHEN pir_reportes.reporte = "Presente en sedes" THEN 1 ELSE NULL END) AS presente_sedes')
            ->selectRaw('COUNT(CASE WHEN pir_reportes.reporte = "Suspendidos por el IGSS" THEN 1 ELSE NULL END) AS suspendidos_igss')
            ->selectRaw('COUNT(CASE WHEN pir_reportes.reporte = "Suspendidos por la Clínica Médica" THEN 1 ELSE NULL END) AS suspendidos_clinica')
            ->selectRaw('COUNT(CASE WHEN pir_reportes.reporte = "Licencia con goce de salario" THEN 1 ELSE NULL END) AS licencia')
            ->selectRaw('COUNT(CASE WHEN pir_reportes.reporte = "Permiso autorizado" THEN 1 ELSE NULL END) AS permiso')
            ->selectRaw('COUNT(CASE WHEN pir_reportes.reporte = "Comisión" THEN 1 ELSE NULL END) AS comision')
            ->selectRaw('COUNT(CASE WHEN pir_reportes.reporte = "Descanso por turno" THEN 1 ELSE NULL END) AS descanso')
            ->selectRaw('COUNT(CASE WHEN pir_reportes.reporte = "Capacitación en el extranjero" THEN 1 ELSE NULL END) AS capacitacion')
            ->selectRaw('COUNT(CASE WHEN pir_reportes.reporte = "Ausente (Justificar)" THEN 1 ELSE NULL END) AS ausente')
            ->selectRaw('COUNT(CASE WHEN pir_reportes.reporte = "Vacaciones" THEN 1 ELSE NULL END) AS vacaciones')
            ->leftJoin('pir_empleados', function ($join) {
                $join->on('pir_direcciones.id', '=', 'pir_empleados.pir_direccion_id')
                    ->leftJoin('regiones', 'pir_empleados.region_id', '=', 'regiones.id')
                    ->leftJoin('pir_reportes', 'pir_empleados.pir_reporte_id', '=', 'pir_reportes.id')
                    ->where('regiones.region', 'Región I')
                    ->where('pir_empleados.activo', 1);
            })
            ->whereIn('pir_direcciones.id', $orden_direcciones)
            ->groupBy('pir_direcciones.direccion')
            ->orderByRaw('FIELD(pir_direcciones.id,' . implode(',', $orden_direcciones) . ')')
            ->get();

        $regionales = PirDireccion::select(
            'regiones.region as region',
            'regiones.nombre as nombre',
            'pir_direcciones.hora_actualizacion as actualizacion'
        )
            ->rightJoin('pir_empleados', 'pir_direcciones.id', '=', 'pir_empleados.pir_direccion_id')
            ->rightJoin('regiones', 'pir_empleados.region_id', '=', 'regiones.id')
            ->leftjoin('pir_reportes', 'pir_empleados.pir_reporte_id', '=', 'pir_reportes.id')
            ->selectRaw('COUNT(CASE WHEN pir_reportes.reporte = "Presente en sedes" THEN 1 ELSE NULL END) AS presente_sedes')
            ->selectRaw('COUNT(CASE WHEN pir_reportes.reporte = "Suspendidos por el IGSS" THEN 1 ELSE NULL END) AS suspendidos_igss')
            ->selectRaw('COUNT(CASE WHEN pir_reportes.reporte = "Suspendidos por la Clínica Médica" THEN 1 ELSE NULL END) AS suspendidos_clinica')
            ->selectRaw('COUNT(CASE WHEN pir_reportes.reporte = "Licencia con goce de salario" THEN 1 ELSE NULL END) AS licencia')
            ->selectRaw('COUNT(CASE WHEN pir_reportes.reporte = "Permiso autorizado" THEN 1 ELSE NULL END) AS permiso')
            ->selectRaw('COUNT(CASE WHEN pir_reportes.reporte = "Comisión" THEN 1 ELSE NULL END) AS comision')
            ->selectRaw('COUNT(CASE WHEN pir_reportes.reporte = "Descanso por turno" THEN 1 ELSE NULL END) AS descanso')
            ->selectRaw('COUNT(CASE WHEN pir_reportes.reporte = "Capacitación en el extranjero" THEN 1 ELSE NULL END) AS capacitacion')
            ->selectRaw('COUNT(CASE WHEN pir_reportes.reporte = "Ausente (Justificar)" THEN 1 ELSE NULL END) AS ausente')
            ->selectRaw('COUNT(CASE WHEN pir_reportes.reporte = "Vacaciones" THEN 1 ELSE NULL END) AS vacaciones')
            ->groupBy('regiones.region')
            ->where('pir_empleados.activo', 1)
            ->orderBy('regiones.id', 'asc')
            ->get();

        /* PLANTILLA */
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('templates/reporte.xlsx');
        $doc = $spreadsheet->getActiveSheet();

        foreach (range(3, 24) as $row) {
            $doc->getRowDimension($row)->setRowHeight(-1);
        }

        $doc->getCell('Z1')->setValue($fecha);

        $fila_inicial = 3;
        $fila_inicial_regionales = 25;

        foreach ($direcciones as $indice => $dir) {
            $observacion = '';
            $fila_actual = $fila_inicial + $indice;
            $doc->getCell('A' . $fila_actual)->setValue($indice + 1);
            $doc->getCell('B' . $fila_actual)->setValue($dir->direccion);
            $doc->getCell('M' . $fila_actual)->setValue($dir->presente_sedes);
            $doc->getCell('N' . $fila_actual)->setValue($dir->suspendidos_igss);
            if ($dir->suspendidos_igss > 0) {
                $empleados = $this->getEmpleados($dir->id_direccion, 2);
                $observacion .= "2. Suspendidos por el IGSS\n";
                foreach ($empleados as $emp) {
                    $observacion .= "{$emp->nombre} {$emp->renglon} / {$emp->observacion}\n";
                }
            }
            $doc->getCell('O' . $fila_actual)->setValue($dir->suspendidos_clinica);
            if ($dir->suspendidos_clinica > 0) {
                $empleados = $this->getEmpleados($dir->id_direccion, 3);
                $observacion .= "3. Suspendidos por la Clínica Médica\n";
                foreach ($empleados as $emp) {
                    $observacion .= "{$emp->nombre} {$emp->renglon} / {$emp->observacion}\n";
                }
            }
            $doc->getCell('P' . $fila_actual)->setValue($dir->licencia);
            if ($dir->licencia > 0) {
                $empleados = $this->getEmpleados($dir->id_direccion, 4);
                $observacion .= "4. Licencia con goce de salario\n";
                foreach ($empleados as $emp) {
                    $observacion .= "{$emp->nombre} {$emp->renglon} / {$emp->observacion}\n";
                }
            }
            $doc->getCell('Q' . $fila_actual)->setValue($dir->permiso);
            if ($dir->permiso > 0) {
                $empleados = $this->getEmpleados($dir->id_direccion, 5);
                $observacion .= "5. Permiso autorizado\n";
                foreach ($empleados as $emp) {
                    $observacion .= "{$emp->nombre} {$emp->renglon} / {$emp->observacion}\n";
                }
            }
            $doc->getCell('R' . $fila_actual)->setValue($dir->comision);
            $doc->getCell('S' . $fila_actual)->setValue($dir->descanso);
            $doc->getCell('T' . $fila_actual)->setValue($dir->capacitacion);
            $doc->getCell('U' . $fila_actual)->setValue($dir->ausente);
            if ($dir->ausente > 0) {
                $empleados = $this->getEmpleados($dir->id_direccion, 9);
                $observacion .= "9. Ausente (justificar)\n";
                foreach ($empleados as $emp) {
                    $observacion .= "- {$emp->nombre} {$emp->renglon} / {$emp->observacion}\n";
                }
            }
            $doc->getCell('W' . $fila_actual)->setValue($dir->vacaciones);
            if ($dir->actualizacion >= $dia_actual . ' 07:45:00' && $dir->actualizacion <= $dia_actual . ' 09:45:00') {
                $doc->getCell('Z' . $fila_actual)->setValue($observacion);
            } else {
                $doc->getStyle('Z' . $fila_actual)->applyFromArray([
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'FF0000'],
                    ],
                    'font' => [
                        'color' => ['rgb' => 'FFFFFF'],
                    ],
                ]);
                $doc->getCell('Z' . $fila_actual)->setValue('NO PRESENTÓ INFORME');
            }
        }

        foreach ($regionales as $indice => $region) {
            $observacion = '';
            $fila_actual = $fila_inicial_regionales + $indice;

            $doc->getCell('A' . $fila_actual)->setValue($indice + 1);
            $doc->getCell('B' . $fila_actual)->setValue($region->region . ' - ' . $region->nombre);
            $doc->getCell('M' . $fila_actual)->setValue($region->presente_sedes);
            $doc->getCell('N' . $fila_actual)->setValue($region->suspendidos_igss);
            if ($region->suspendidos_igss > 0) {
                $empleados = $this->getEmpleados($region->id_direccion, 2);
                $observacion .= "2. Suspendidos por el IGSS\n";
                foreach ($empleados as $emp) {
                    $observacion .= "{$emp->nombre} {$emp->renglon} / {$emp->observacion}\n";
                }
            }
            $doc->getCell('O' . $fila_actual)->setValue($region->suspendidos_clinica);
            if ($region->suspendidos_clinica > 0) {
                $empleados = $this->getEmpleados($region->id_direccion, 3);
                $observacion .= "3. Suspendidos por la Clínica Médica\n";
                foreach ($empleados as $emp) {
                    $observacion .= "{$emp->nombre} {$emp->renglon} / {$emp->observacion}\n";
                }
            }
            $doc->getCell('P' . $fila_actual)->setValue($region->licencia);
            if ($region->licencia > 0) {
                $empleados = $this->getEmpleados($region->id_direccion, 4);
                $observacion .= "4. Licencia con goce de salario\n";
                foreach ($empleados as $emp) {
                    $observacion .= "{$emp->nombre} {$emp->renglon} / {$emp->observacion}\n";
                }
            }
            $doc->getCell('Q' . $fila_actual)->setValue($region->permiso);
            if ($region->permiso > 0) {
                $empleados = $this->getEmpleados($region->id_direccion, 5);
                $observacion .= "5. Permiso autorizado\n";
                foreach ($empleados as $emp) {
                    $observacion .= "{$emp->nombre} {$emp->renglon} / {$emp->observacion}\n";
                }
            }
            $doc->getCell('R' . $fila_actual)->setValue($region->comision);
            $doc->getCell('S' . $fila_actual)->setValue($region->descanso);
            $doc->getCell('T' . $fila_actual)->setValue($region->capacitacion);
            $doc->getCell('U' . $fila_actual)->setValue($region->ausente);
            if ($region->ausente > 0) {
                $empleados = $this->getEmpleados($region->id_direccion, 9);
                $observacion .= "9. Ausente (justificar)\n";
                foreach ($empleados as $emp) {
                    $observacion .= "- {$emp->nombre} {$emp->renglon} / {$emp->observacion}\n";
                }
            }
            $doc->getCell('W' . $fila_actual)->setValue($region->vacaciones);
            if ($region->actualizacion >= $dia_actual . ' 07:45:00' && $region->actualizacion <= $dia_actual . ' 09:45:00') {
                $doc->getCell('Z' . $fila_actual)->setValue($observacion);
            } else {
                $doc->getStyle('Z' . $fila_actual)->applyFromArray([
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'FF0000'],
                    ],
                    'font' => [
                        'color' => ['rgb' => 'FFFFFF'],
                    ],
                ]);
                $doc->getCell('Z' . $fila_actual)->setValue('NO PRESENTÓ INFORME');
            }
        }

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');

        if (!Storage::exists('templates/procesed/')) {
            Storage::makeDirectory('templates/procesed/');
        }

        $writer->save('templates/procesed/' . $fecha_hora . '_REPORTE_DIARIO.xlsx');

        // Descargar el archivo
        return 'templates/procesed/' . $fecha_hora . '_REPORTE_DIARIO.xlsx';
    }

    public function generarReporteAusencias()
    {
        $fecha = date('d/m/Y');
        $hora = date('H:i:s');
        $fecha_hora = date('Y_m_d H_i_s');

        /* PLANTILLA */
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('templates/ausencias.xlsx');
        $ausente = $spreadsheet->setActiveSheetIndexByName('Ausencias');
        $comision = $spreadsheet->setActiveSheetIndexByName('Comisión');
        $capacitacion = $spreadsheet->setActiveSheetIndexByName('Capacitación');

        $ausente->setCellValue('B6', $fecha);
        $ausente->setCellValue('E6', $hora);

        $comision->setCellValue('B6', $fecha);
        $comision->setCellValue('E6', $hora);

        $capacitacion->setCellValue('B6', $fecha);
        $capacitacion->setCellValue('E6', $hora);

        $fila_inicial = 8;

        $ausentes = PirEmpleado::select(
            'pir_empleados.nombre',
            'pir_empleados.observacion',
            'pir_empleados.pir_reporte_id',
            'pir_reportes.reporte as reporte',
            'pir_empleados.pir_grupo_id',
            'pir_grupos.grupo as grupo',
            'catalogo_puestos.puesto as puesto',
            'renglones.renglon as renglon',
            'pir_direcciones.direccion as direccion'
        )
            ->join('pir_puestos', 'pir_empleados.id', '=', 'pir_puestos.pir_empleado_id')
            ->join('catalogo_puestos', 'pir_puestos.catalogo_puesto_id', '=', 'catalogo_puestos.id')
            ->join('renglones', 'catalogo_puestos.renglones_id', '=', 'renglones.id')
            ->join('pir_reportes', 'pir_empleados.pir_reporte_id', '=', 'pir_reportes.id')
            ->join('pir_grupos', 'pir_empleados.pir_grupo_id', '=', 'pir_grupos.id')
            ->join('pir_direcciones', 'pir_empleados.pir_direccion_id', '=', 'pir_direcciones.id')
            ->whereIn('pir_reportes.id', [2, 3, 4, 5, 7, 9, 10])
            ->where('pir_empleados.activo', 1)
            ->get();

        $comisiones = PirEmpleado::select(
            'pir_empleados.nombre',
            'pir_empleados.observacion',
            'pir_empleados.pir_reporte_id',
            'pir_reportes.reporte as reporte',
            'pir_empleados.pir_grupo_id',
            'pir_grupos.grupo as grupo',
            'catalogo_puestos.puesto as puesto',
            'renglones.renglon as renglon',
            'pir_direcciones.direccion as direccion'
        )
            ->join('pir_puestos', 'pir_empleados.id', '=', 'pir_puestos.pir_empleado_id')
            ->join('catalogo_puestos', 'pir_puestos.catalogo_puesto_id', '=', 'catalogo_puestos.id')
            ->join('renglones', 'catalogo_puestos.renglones_id', '=', 'renglones.id')
            ->join('pir_reportes', 'pir_empleados.pir_reporte_id', '=', 'pir_reportes.id')
            ->join('pir_grupos', 'pir_empleados.pir_grupo_id', '=', 'pir_grupos.id')
            ->join('pir_direcciones', 'pir_empleados.pir_direccion_id', '=', 'pir_direcciones.id')
            ->where('reporte', 'Comisión')
            ->wheree('pir_empleados.activo', 1)
            ->get();

        $capacitaciones = PirEmpleado::select(
            'pir_empleados.nombre',
            'pir_empleados.observacion',
            'pir_empleados.pir_reporte_id',
            'pir_reportes.reporte as reporte',
            'pir_empleados.pir_grupo_id',
            'pir_grupos.grupo as grupo',
            'catalogo_puestos.puesto as puesto',
            'renglones.renglon as renglon',
            'pir_direcciones.direccion as direccion'
        )
            ->join('pir_puestos', 'pir_empleados.id', '=', 'pir_puestos.pir_empleado_id')
            ->join('catalogo_puestos', 'pir_puestos.catalogo_puesto_id', '=', 'catalogo_puestos.id')
            ->join('renglones', 'catalogo_puestos.renglones_id', '=', 'renglones.id')
            ->join('pir_reportes', 'pir_empleados.pir_reporte_id', '=', 'pir_reportes.id')
            ->join('pir_grupos', 'pir_empleados.pir_grupo_id', '=', 'pir_grupos.id')
            ->join('pir_direcciones', 'pir_empleados.pir_direccion_id', '=', 'pir_direcciones.id')
            ->where('reporte', 'Capacitación en el extranjero')
            ->where('pir_empleados.activo', 1)
            ->get();

        if (count($ausentes) > 2) {
            $ausente->insertNewRowBefore($fila_inicial + 1, count($ausentes) - 2);
        } elseif (count($ausentes) == 1) {
            $ausente->removeRow($fila_inicial);
        } elseif (count($comisiones) <= 0) {
            $ausente->removeRow($fila_inicial, 2);
        }

        if (count($comisiones) > 2) {
            $comision->insertNewRowBefore($fila_inicial + 1, count($comisiones) - 2);
        } elseif (count($comisiones) == 1) {
            $comision->removeRow($fila_inicial);
        } elseif (count($comisiones) <= 0) {
            $comision->removeRow($fila_inicial, 2);
        }

        if (count($capacitaciones) > 2) {
            $capacitacion->insertNewRowBefore($fila_inicial + 1, count($capacitaciones) - 2);
        } elseif (count($capacitaciones) == 1) {
            $capacitacion->removeRow($fila_inicial);
        } elseif (count($comisiones) <= 0) {
            $capacitacion->removeRow($fila_inicial, 2);
        }

        foreach ($ausentes as $indice => $emp) {
            $fila_actual = $fila_inicial + $indice;
            $ausente->getCell('A' . $fila_actual)->setValue($indice + 1);
            $ausente->getCell('B' . $fila_actual)->setValue($emp->nombre);
            $ausente->getCell('C' . $fila_actual)->setValue($emp->renglon);
            $ausente->getCell('D' . $fila_actual)->setValue($emp->puesto);
            $ausente->getCell('E' . $fila_actual)->setValue($emp->direccion);
            $ausente->getCell('F' . $fila_actual)->setValue('I');
            $ausente->getCell('G' . $fila_actual)->setValue('Guatemala/Guatemala');
            $ausente->getCell('H' . $fila_actual)->setValue($emp->pir_reporte_id);
            $ausente->getCell('I' . $fila_actual)->setValue($emp->observacion);
        }

        foreach ($comisiones as $indice => $emp) {
            $fila_actual = $fila_inicial + $indice;
            $comision->getCell('A' . $fila_actual)->setValue($indice + 1);
            $comision->getCell('B' . $fila_actual)->setValue($emp->nombre);
            $comision->getCell('C' . $fila_actual)->setValue($emp->renglon);
            $comision->getCell('D' . $fila_actual)->setValue($emp->puesto);
            $comision->getCell('E' . $fila_actual)->setValue($emp->direccion);
            $comision->getCell('F' . $fila_actual)->setValue('I');
            $comision->getCell('G' . $fila_actual)->setValue('Guatemala/Guatemala');
            $comision->getCell('H' . $fila_actual)->setValue($emp->pir_reporte_id);
            $comision->getCell('I' . $fila_actual)->setValue($emp->observacion);
        }

        foreach ($capacitaciones as $indice => $emp) {
            $fila_actual = $fila_inicial + $indice;
            $capacitacion->getCell('A' . $fila_actual)->setValue($indice + 1);
            $capacitacion->getCell('B' . $fila_actual)->setValue($emp->nombre);
            $capacitacion->getCell('C' . $fila_actual)->setValue($emp->renglon);
            $capacitacion->getCell('D' . $fila_actual)->setValue($emp->puesto);
            $capacitacion->getCell('E' . $fila_actual)->setValue($emp->direccion);
            $capacitacion->getCell('F' . $fila_actual)->setValue('I');
            $capacitacion->getCell('G' . $fila_actual)->setValue('Guatemala/Guatemala');
            $capacitacion->getCell('H' . $fila_actual)->setValue($emp->pir_reporte_id);
            $capacitacion->getCell('I' . $fila_actual)->setValue($emp->observacion);
        }

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');

        if (!Storage::exists('templates/procesed/')) {
            Storage::makeDirectory('templates/procesed/');
        }

        $writer->save('templates/procesed/' . $fecha_hora . 'CONTROL_AUSENCIAS.xlsx');

        // Descargar el archivo
        return 'templates/procesed/' . $fecha_hora . '_CONTROL_AUSENCIAS.xlsx';
    }

    public function consolidarPIR()
    {
        $fecha = Carbon::now()->translatedFormat('l, d \\de F \\de Y');
        $hora = date('H:i');
        $fecha_hora = date('Y_m_d H_i_s');

        $orden_direcciones = [1, 3, 2, 8, 22, 12, 6, 13, 9, 14, 17, 19, 20, 21, 7, 11, 16, 18, 15, 5, 4, 10];

        $direcciones_personal = PirDireccion::select(
            'pir_direcciones.id as id_direccion',
            'pir_direcciones.direccion as direccion'
        )
            ->selectRaw('COUNT(CASE WHEN pir_reportes.reporte = "Presente en sedes" THEN 1 ELSE NULL END) AS presente')
            ->selectRaw('COUNT(CASE WHEN pir_reportes.reporte = "Comisión" THEN 1 ELSE NULL END) AS comision')
            ->selectRaw('COUNT(CASE WHEN pir_reportes.reporte = "Capacitación en el extranjero" THEN 1 ELSE NULL END) AS asignacion_especial')
            ->selectRaw('COUNT(CASE WHEN pir_reportes.reporte NOT IN ("Capacitación en el extranjero", "Presente en sedes", "Comisión") THEN 1 ELSE NULL END) AS ausente')
            ->leftJoin('pir_empleados', function ($join) {
                $join->on('pir_direcciones.id', '=', 'pir_empleados.pir_direccion_id')
                    ->leftJoin('pir_reportes', 'pir_empleados.pir_reporte_id', '=', 'pir_reportes.id')
                    ->leftJoin('pir_puestos', 'pir_empleados.id', '=', 'pir_puestos.pir_empleado_id')
                    ->leftJoin('catalogo_puestos', 'pir_puestos.catalogo_puesto_id', '=', 'catalogo_puestos.id')
                    ->leftJoin('renglones', 'catalogo_puestos.renglones_id', '=', 'renglones.id')
                    ->whereIn('renglones.renglon', ['011', '021', '022', '031'])
                    ->where('pir_empleados.activo', 1);
            })
            ->whereIn('pir_direcciones.id', $orden_direcciones)
            ->groupBy('pir_direcciones.id', 'pir_direcciones.direccion')
            ->orderByRaw('FIELD(pir_direcciones.id,' . implode(',', $orden_direcciones) . ')')
            ->get();

        $direcciones_contratistas = PirDireccion::select(
            'pir_direcciones.id as id_direccion',
            'pir_direcciones.direccion as direccion'
        )
            ->selectRaw('COUNT(CASE WHEN pir_reportes.reporte = "Presente en sedes" THEN 1 ELSE NULL END) AS presente')
            ->selectRaw('COUNT(CASE WHEN pir_reportes.reporte = "Comisión" THEN 1 ELSE NULL END) AS comision')
            ->selectRaw('COUNT(CASE WHEN pir_reportes.reporte = "Capacitación en el extranjero" THEN 1 ELSE NULL END) AS asignacion_especial')
            ->selectRaw('COUNT(CASE WHEN pir_reportes.reporte NOT IN ("Capacitación en el extranjero", "Presente en sedes", "Comisión") THEN 1 ELSE NULL END) AS ausente')
            ->leftJoin('pir_empleados', function ($join) {
                $join->on('pir_direcciones.id', '=', 'pir_empleados.pir_direccion_id')
                    ->leftJoin('pir_reportes', 'pir_empleados.pir_reporte_id', '=', 'pir_reportes.id')
                    ->leftJoin('pir_puestos', 'pir_empleados.id', '=', 'pir_puestos.pir_empleado_id')
                    ->leftJoin('catalogo_puestos', 'pir_puestos.catalogo_puesto_id', '=', 'catalogo_puestos.id')
                    ->leftJoin('renglones', 'catalogo_puestos.renglones_id', '=', 'renglones.id')
                    ->where('renglones.renglon', '029')
                    ->where('pir_empleados.activo', 1);
            })
            ->whereIn('pir_direcciones.id', $orden_direcciones)
            ->groupBy('pir_direcciones.id', 'pir_direcciones.direccion')
            ->orderByRaw('FIELD(pir_direcciones.id,' . implode(',', $orden_direcciones) . ')')
            ->get();

        /* PLANTILLA */
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('templates/PIRConsolidado.xlsx');
        $formatoPersonal = $spreadsheet->setActiveSheetIndexByName('Personal');
        $formatoContratista = $spreadsheet->setActiveSheetIndexByName('Contratistas');

        $formatoPersonal->getCell('B11')->setValue('Fecha: ' . $fecha);
        $formatoPersonal->getCell('I11')->setValue($hora . ' horas');

        $formatoContratista->getCell('B11')->setValue('Fecha: ' . $fecha);
        $formatoContratista->getCell('I11')->setValue($hora . ' horas');

        /* Personal */

        $formatoPersonal->setCellValue('D16', $direcciones_personal[0]->presente);
        $formatoPersonal->setCellValue('E16', $direcciones_personal[0]->comision);
        $formatoPersonal->setCellValue('F16', $direcciones_personal[0]->asignacion_especial);
        $formatoPersonal->setCellValue('G16', $direcciones_personal[0]->ausente);

        $formatoPersonal->setCellValue('D17', $direcciones_personal[1]->presente);
        $formatoPersonal->setCellValue('E17', $direcciones_personal[1]->comision);
        $formatoPersonal->setCellValue('F17', $direcciones_personal[1]->asignacion_especial);
        $formatoPersonal->setCellValue('G17', $direcciones_personal[1]->ausente);

        $formatoPersonal->setCellValue('D18', $direcciones_personal[2]->presente);
        $formatoPersonal->setCellValue('E18', $direcciones_personal[2]->comision);
        $formatoPersonal->setCellValue('F18', $direcciones_personal[2]->asignacion_especial);
        $formatoPersonal->setCellValue('G18', $direcciones_personal[2]->ausente);

        $formatoPersonal->setCellValue('D21', $direcciones_personal[3]->presente);
        $formatoPersonal->setCellValue('E21', $direcciones_personal[3]->comision);
        $formatoPersonal->setCellValue('F21', $direcciones_personal[3]->asignacion_especial);
        $formatoPersonal->setCellValue('G21', $direcciones_personal[3]->ausente);

        $formatoPersonal->setCellValue('D23', $direcciones_personal[4]->presente);
        $formatoPersonal->setCellValue('E23', $direcciones_personal[4]->comision);
        $formatoPersonal->setCellValue('F23', $direcciones_personal[4]->asignacion_especial);
        $formatoPersonal->setCellValue('G23', $direcciones_personal[4]->ausente);

        $formatoPersonal->setCellValue('D24', $direcciones_personal[5]->presente);
        $formatoPersonal->setCellValue('E24', $direcciones_personal[5]->comision);
        $formatoPersonal->setCellValue('F24', $direcciones_personal[5]->asignacion_especial);
        $formatoPersonal->setCellValue('G24', $direcciones_personal[5]->ausente);

        $formatoPersonal->setCellValue('D26', $direcciones_personal[6]->presente);
        $formatoPersonal->setCellValue('E26', $direcciones_personal[6]->comision);
        $formatoPersonal->setCellValue('F26', $direcciones_personal[6]->asignacion_especial);
        $formatoPersonal->setCellValue('G26', $direcciones_personal[6]->ausente);

        $formatoPersonal->setCellValue('D27', $direcciones_personal[7]->presente);
        $formatoPersonal->setCellValue('E27', $direcciones_personal[7]->comision);
        $formatoPersonal->setCellValue('F27', $direcciones_personal[7]->asignacion_especial);
        $formatoPersonal->setCellValue('G27', $direcciones_personal[7]->ausente);

        $formatoPersonal->setCellValue('D29', $direcciones_personal[8]->presente);
        $formatoPersonal->setCellValue('E29', $direcciones_personal[8]->comision);
        $formatoPersonal->setCellValue('F29', $direcciones_personal[8]->asignacion_especial);
        $formatoPersonal->setCellValue('G29', $direcciones_personal[8]->ausente);

        $formatoPersonal->setCellValue('D31', $direcciones_personal[9]->presente);
        $formatoPersonal->setCellValue('E31', $direcciones_personal[9]->comision);
        $formatoPersonal->setCellValue('F31', $direcciones_personal[9]->asignacion_especial);
        $formatoPersonal->setCellValue('G31', $direcciones_personal[9]->ausente);

        $formatoPersonal->setCellValue('D33', $direcciones_personal[10]->presente + $direcciones_personal[11]->presente + $direcciones_personal[12]->presente);
        $formatoPersonal->setCellValue('E33', $direcciones_personal[10]->comision + $direcciones_personal[11]->comision + $direcciones_personal[12]->comision);
        $formatoPersonal->setCellValue('F33', $direcciones_personal[10]->asignacion_especial + $direcciones_personal[11]->asignacion_especial + $direcciones_personal[12]->asignacion_especial);
        $formatoPersonal->setCellValue('G33', $direcciones_personal[10]->ausente + $direcciones_personal[11]->ausente + $direcciones_personal[12]->ausente);

        $formatoPersonal->setCellValue('D35', $direcciones_personal[13]->presente);
        $formatoPersonal->setCellValue('E35', $direcciones_personal[13]->comision);
        $formatoPersonal->setCellValue('F35', $direcciones_personal[13]->asignacion_especial);
        $formatoPersonal->setCellValue('G35', $direcciones_personal[13]->ausente);

        $formatoPersonal->setCellValue('D37', $direcciones_personal[14]->presente);
        $formatoPersonal->setCellValue('E37', $direcciones_personal[14]->comision);
        $formatoPersonal->setCellValue('F37', $direcciones_personal[14]->asignacion_especial);
        $formatoPersonal->setCellValue('G37', $direcciones_personal[14]->ausente);

        $formatoPersonal->setCellValue('D39', $direcciones_personal[15]->presente);
        $formatoPersonal->setCellValue('E39', $direcciones_personal[15]->comision);
        $formatoPersonal->setCellValue('F39', $direcciones_personal[15]->asignacion_especial);
        $formatoPersonal->setCellValue('G39', $direcciones_personal[15]->ausente);

        $formatoPersonal->setCellValue('D40', $direcciones_personal[16]->presente);
        $formatoPersonal->setCellValue('E40', $direcciones_personal[16]->comision);
        $formatoPersonal->setCellValue('F40', $direcciones_personal[16]->asignacion_especial);
        $formatoPersonal->setCellValue('G40', $direcciones_personal[16]->ausente);

        $formatoPersonal->setCellValue('D41', $direcciones_personal[17]->presente);
        $formatoPersonal->setCellValue('E41', $direcciones_personal[17]->comision);
        $formatoPersonal->setCellValue('F41', $direcciones_personal[17]->asignacion_especial);
        $formatoPersonal->setCellValue('G41', $direcciones_personal[17]->ausente);

        $formatoPersonal->setCellValue('D42', $direcciones_personal[18]->presente);
        $formatoPersonal->setCellValue('E42', $direcciones_personal[18]->comision);
        $formatoPersonal->setCellValue('F42', $direcciones_personal[18]->asignacion_especial);
        $formatoPersonal->setCellValue('G42', $direcciones_personal[18]->ausente);

        $formatoPersonal->setCellValue('D44', $direcciones_personal[19]->presente);
        $formatoPersonal->setCellValue('E44', $direcciones_personal[19]->comision);
        $formatoPersonal->setCellValue('F44', $direcciones_personal[19]->asignacion_especial);
        $formatoPersonal->setCellValue('G44', $direcciones_personal[19]->ausente);

        $formatoPersonal->setCellValue('D45', $direcciones_personal[20]->presente);
        $formatoPersonal->setCellValue('E45', $direcciones_personal[20]->comision);
        $formatoPersonal->setCellValue('F45', $direcciones_personal[20]->asignacion_especial);
        $formatoPersonal->setCellValue('G45', $direcciones_personal[20]->ausente);

        $formatoPersonal->setCellValue('D46', $direcciones_personal[21]->presente);
        $formatoPersonal->setCellValue('E46', $direcciones_personal[21]->comision);
        $formatoPersonal->setCellValue('F46', $direcciones_personal[21]->asignacion_especial);
        $formatoPersonal->setCellValue('G46', $direcciones_personal[21]->ausente);

        /* Contratistas */

        $formatoContratista->setCellValue('D16', $direcciones_contratistas[0]->presente);
        $formatoContratista->setCellValue('E16', $direcciones_contratistas[0]->comision);
        $formatoContratista->setCellValue('F16', $direcciones_contratistas[0]->asignacion_especial);
        $formatoContratista->setCellValue('G16', $direcciones_contratistas[0]->ausente);

        $formatoContratista->setCellValue('D17', $direcciones_contratistas[1]->presente);
        $formatoContratista->setCellValue('E17', $direcciones_contratistas[1]->comision);
        $formatoContratista->setCellValue('F17', $direcciones_contratistas[1]->asignacion_especial);
        $formatoContratista->setCellValue('G17', $direcciones_contratistas[1]->ausente);

        $formatoContratista->setCellValue('D18', $direcciones_contratistas[2]->presente);
        $formatoContratista->setCellValue('E18', $direcciones_contratistas[2]->comision);
        $formatoContratista->setCellValue('F18', $direcciones_contratistas[2]->asignacion_especial);
        $formatoContratista->setCellValue('G18', $direcciones_contratistas[2]->ausente);

        $formatoContratista->setCellValue('D21', $direcciones_contratistas[3]->presente);
        $formatoContratista->setCellValue('E21', $direcciones_contratistas[3]->comision);
        $formatoContratista->setCellValue('F21', $direcciones_contratistas[3]->asignacion_especial);
        $formatoContratista->setCellValue('G21', $direcciones_contratistas[3]->ausente);

        $formatoContratista->setCellValue('D23', $direcciones_contratistas[4]->presente);
        $formatoContratista->setCellValue('E23', $direcciones_contratistas[4]->comision);
        $formatoContratista->setCellValue('F23', $direcciones_contratistas[4]->asignacion_especial);
        $formatoContratista->setCellValue('G23', $direcciones_contratistas[4]->ausente);

        $formatoContratista->setCellValue('D24', $direcciones_contratistas[5]->presente);
        $formatoContratista->setCellValue('E24', $direcciones_contratistas[5]->comision);
        $formatoContratista->setCellValue('F24', $direcciones_contratistas[5]->asignacion_especial);
        $formatoContratista->setCellValue('G24', $direcciones_contratistas[5]->ausente);

        $formatoContratista->setCellValue('D26', $direcciones_contratistas[6]->presente);
        $formatoContratista->setCellValue('E26', $direcciones_contratistas[6]->comision);
        $formatoContratista->setCellValue('F26', $direcciones_contratistas[6]->asignacion_especial);
        $formatoContratista->setCellValue('G26', $direcciones_contratistas[6]->ausente);

        $formatoContratista->setCellValue('D27', $direcciones_contratistas[7]->presente);
        $formatoContratista->setCellValue('E27', $direcciones_contratistas[7]->comision);
        $formatoContratista->setCellValue('F27', $direcciones_contratistas[7]->asignacion_especial);
        $formatoContratista->setCellValue('G27', $direcciones_contratistas[7]->ausente);

        $formatoContratista->setCellValue('D29', $direcciones_contratistas[8]->presente);
        $formatoContratista->setCellValue('E29', $direcciones_contratistas[8]->comision);
        $formatoContratista->setCellValue('F29', $direcciones_contratistas[8]->asignacion_especial);
        $formatoContratista->setCellValue('G29', $direcciones_contratistas[8]->ausente);

        $formatoContratista->setCellValue('D31', $direcciones_contratistas[9]->presente);
        $formatoContratista->setCellValue('E31', $direcciones_contratistas[9]->comision);
        $formatoContratista->setCellValue('F31', $direcciones_contratistas[9]->asignacion_especial);
        $formatoContratista->setCellValue('G31', $direcciones_contratistas[9]->ausente);

        $formatoContratista->setCellValue('D33', $direcciones_contratistas[10]->presente + $direcciones_contratistas[11]->presente + $direcciones_contratistas[12]->presente);
        $formatoContratista->setCellValue('E33', $direcciones_contratistas[10]->comision + $direcciones_contratistas[11]->comision + $direcciones_contratistas[12]->comision);
        $formatoContratista->setCellValue('F33', $direcciones_contratistas[10]->asignacion_especial + $direcciones_contratistas[11]->asignacion_especial + $direcciones_contratistas[12]->asignacion_especial);
        $formatoContratista->setCellValue('G33', $direcciones_contratistas[10]->ausente + $direcciones_contratistas[11]->ausente + $direcciones_contratistas[12]->ausente);

        $formatoContratista->setCellValue('D35', $direcciones_contratistas[13]->presente);
        $formatoContratista->setCellValue('E35', $direcciones_contratistas[13]->comision);
        $formatoContratista->setCellValue('F35', $direcciones_contratistas[13]->asignacion_especial);
        $formatoContratista->setCellValue('G35', $direcciones_contratistas[13]->ausente);

        $formatoContratista->setCellValue('D37', $direcciones_contratistas[14]->presente);
        $formatoContratista->setCellValue('E37', $direcciones_contratistas[14]->comision);
        $formatoContratista->setCellValue('F37', $direcciones_contratistas[14]->asignacion_especial);
        $formatoContratista->setCellValue('G37', $direcciones_contratistas[14]->ausente);

        $formatoContratista->setCellValue('D39', $direcciones_contratistas[15]->presente);
        $formatoContratista->setCellValue('E39', $direcciones_contratistas[15]->comision);
        $formatoContratista->setCellValue('F39', $direcciones_contratistas[15]->asignacion_especial);
        $formatoContratista->setCellValue('G39', $direcciones_contratistas[15]->ausente);

        $formatoContratista->setCellValue('D40', $direcciones_contratistas[16]->presente);
        $formatoContratista->setCellValue('E40', $direcciones_contratistas[16]->comision);
        $formatoContratista->setCellValue('F40', $direcciones_contratistas[16]->asignacion_especial);
        $formatoContratista->setCellValue('G40', $direcciones_contratistas[16]->ausente);

        $formatoContratista->setCellValue('D41', $direcciones_contratistas[17]->presente);
        $formatoContratista->setCellValue('E41', $direcciones_contratistas[17]->comision);
        $formatoContratista->setCellValue('F41', $direcciones_contratistas[17]->asignacion_especial);
        $formatoContratista->setCellValue('G41', $direcciones_contratistas[17]->ausente);

        $formatoContratista->setCellValue('D42', $direcciones_contratistas[18]->presente);
        $formatoContratista->setCellValue('E42', $direcciones_contratistas[18]->comision);
        $formatoContratista->setCellValue('F42', $direcciones_contratistas[18]->asignacion_especial);
        $formatoContratista->setCellValue('G42', $direcciones_contratistas[18]->ausente);

        $formatoContratista->setCellValue('D44', $direcciones_contratistas[19]->presente);
        $formatoContratista->setCellValue('E44', $direcciones_contratistas[19]->comision);
        $formatoContratista->setCellValue('F44', $direcciones_contratistas[19]->asignacion_especial);
        $formatoContratista->setCellValue('G44', $direcciones_contratistas[19]->ausente);

        $formatoContratista->setCellValue('D45', $direcciones_contratistas[20]->presente);
        $formatoContratista->setCellValue('E45', $direcciones_contratistas[20]->comision);
        $formatoContratista->setCellValue('F45', $direcciones_contratistas[20]->asignacion_especial);
        $formatoContratista->setCellValue('G45', $direcciones_contratistas[20]->ausente);

        $formatoContratista->setCellValue('D46', $direcciones_contratistas[21]->presente);
        $formatoContratista->setCellValue('E46', $direcciones_contratistas[21]->comision);
        $formatoContratista->setCellValue('F46', $direcciones_contratistas[21]->asignacion_especial);
        $formatoContratista->setCellValue('G46', $direcciones_contratistas[21]->ausente);

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');

        if (!Storage::exists('templates/procesed/')) {
            Storage::makeDirectory('templates/procesed/');
        }

        $writer->save('templates/procesed/' . $fecha_hora . '_PIR_CONSOLIDADO.xlsx');

        // Descargar el archivo
        return 'templates/procesed/' . $fecha_hora . '_PIR_CONSOLIDADO.xlsx';
    }

    private function getEmpleados($id_direccion, $id_reporte)
    {
        $empleados = PirEmpleado::select(
            'pir_empleados.nombre as nombre',
            'pir_empleados.observacion as observacion',
            'renglones.renglon as renglon'
        )
            ->leftJoin('pir_puestos', 'pir_empleados.id', '=', 'pir_puestos.pir_empleado_id')
            ->leftJoin('catalogo_puestos', 'pir_puestos.catalogo_puesto_id', '=', 'catalogo_puestos.id')
            ->leftJoin('renglones', 'catalogo_puestos.renglones_id', '=', 'renglones.id')
            ->join('pir_reportes', 'pir_empleados.pir_reporte_id', '=', 'pir_reportes.id')
            ->join('pir_direcciones', 'pir_empleados.pir_direccion_id', '=', 'pir_direcciones.id')
            ->where('pir_reportes.id', $id_reporte)
            ->where('pir_empleados.activo', 1)
            ->where('pir_direcciones.id', $id_direccion)
            ->get();

        return $empleados;
    }
}
