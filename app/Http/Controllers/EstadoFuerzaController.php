<?php

namespace App\Http\Controllers;

use App\Models\PirDireccion;
use App\Models\PirEmpleado;
use App\Models\PirSeccion;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

class EstadoFuerzaController extends Controller
{
    public function generarFormularioPIR($id_direccion)
    {
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
            ->join('renglones', 'pir_empleados.renglon_id', '=', 'renglones.id')
            ->join('pir_reportes', 'pir_empleados.pir_reporte_id', '=', 'pir_reportes.id')
            ->join('pir_grupos', 'pir_empleados.pir_grupo_id', '=', 'pir_grupos.id')
            ->where('pir_direccion_id', $id_direccion)
            ->where('renglones.renglon', '011')
            ->orWhere('renglones.renglon', '021')
            ->orWhere('renglones.renglon', '022')
            ->orWhere('renglones.renglon', '031')
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
            ->join('renglones', 'pir_empleados.renglon_id', '=', 'renglones.id')
            ->join('pir_reportes', 'pir_empleados.pir_reporte_id', '=', 'pir_reportes.id')
            ->join('pir_grupos', 'pir_empleados.pir_grupo_id', '=', 'pir_grupos.id')
            ->where('pir_direccion_id', $id_direccion)
            ->where('renglones.renglon', '029')
            ->orderBy('pir_empleados.id', 'asc')
            ->get();

        $fecha = date('d/m/Y');
        $hora = date('H:i:s');
        $fecha_hora = date('d_m_Y H_i_s');
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
        $writer->save('templates/procesed/pir_' . $fecha_hora . '.xlsx');

        // Descargar el archivo
        return 'templates/procesed/pir_' . $fecha_hora . '.xlsx';
        /* return response()->download('templates/procesed/pir_' . $fecha_hora . '.xlsx')->deleteFileAfterSend(true); */
    }
}
