<?php

namespace App\Http\Controllers;

use App\Models\PirDireccion;
use App\Models\PirEmpleado;
use App\Models\PirReporte;
use App\Models\PirSeccion;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Dompdf\Dompdf;
use Dompdf\Options;

class EstadoFuerzaController extends Controller
{
    public function generarFormularioPIR($id_direccion, $region)
    {

        $fecha = date('d/m/Y');
        $hora = date('H:i:s');
        $fecha_hora = date('Y_m_d H_i_s');

        $p_en_sedes = 0;
        $p_comision = 0;
        $p_especial = 0;
        $p_ausente = 0;

        $c_en_sedes = 0;
        $c_comision = 0;
        $c_especial = 0;
        $c_ausente = 0;

        $direccion = '';
        $seccion = '';

        $personal = PirEmpleado::select(
            'pir_empleados.nombre',
            'pir_empleados.observacion',
            'pir_empleados.pir_reporte_id',
            'pir_reportes.reporte as reporte',
            'pir_empleados.pir_grupo_id',
            'pir_grupos.grupo as grupo',
            'pir_direcciones.direccion as direccion',
            'pir_secciones.seccion as seccion'
        )
            ->join('pir_puestos', 'pir_empleados.id', '=', 'pir_puestos.pir_empleado_id')
            ->join('catalogo_puestos', 'pir_puestos.catalogo_puesto_id', '=', 'catalogo_puestos.id')
            ->join('renglones', 'catalogo_puestos.renglones_id', '=', 'renglones.id')
            ->join('pir_reportes', 'pir_empleados.pir_reporte_id', '=', 'pir_reportes.id')
            ->join('pir_grupos', 'pir_empleados.pir_grupo_id', '=', 'pir_grupos.id')
            ->join('pir_direcciones', 'pir_empleados.pir_direccion_id', '=', 'pir_direcciones.id')
            ->leftJoin('pir_secciones', 'pir_direcciones.pir_seccion_id', '=', 'pir_secciones.id')
            ->join('departamentos', 'pir_empleados.departamento_id', '=', 'departamentos.id')
            ->join('regiones', 'pir_empleados.region_id', '=', 'regiones.id')
            ->where('pir_empleados.activo', 1)
            ->whereIn('renglones.renglon', ['011', '021', '022', '031'])
            ->orderBy('pir_empleados.nombre', 'asc');

        $contratista = PirEmpleado::select(
            'pir_empleados.nombre',
            'pir_empleados.observacion',
            'pir_empleados.pir_reporte_id',
            'pir_reportes.reporte as reporte',
            'pir_empleados.pir_grupo_id',
            'pir_grupos.grupo as grupo',
            'pir_direcciones.direccion as direccion',
            'pir_secciones.seccion as seccion'
        )
            ->join('pir_puestos', 'pir_empleados.id', '=', 'pir_puestos.pir_empleado_id')
            ->join('catalogo_puestos', 'pir_puestos.catalogo_puesto_id', '=', 'catalogo_puestos.id')
            ->join('renglones', 'catalogo_puestos.renglones_id', '=', 'renglones.id')
            ->join('pir_reportes', 'pir_empleados.pir_reporte_id', '=', 'pir_reportes.id')
            ->join('pir_grupos', 'pir_empleados.pir_grupo_id', '=', 'pir_grupos.id')
            ->join('pir_direcciones', 'pir_empleados.pir_direccion_id', '=', 'pir_direcciones.id')
            ->leftJoin('pir_secciones', 'pir_direcciones.pir_seccion_id', '=', 'pir_secciones.id')
            ->join('departamentos', 'pir_empleados.departamento_id', '=', 'departamentos.id')
            ->join('regiones', 'pir_empleados.region_id', '=', 'regiones.id')
            ->where('renglones.renglon', '029')
            ->where('pir_empleados.activo', 1)
            ->orderBy('pir_empleados.nombre', 'asc');

        if (!empty($region)) {
            $personal->where('regiones.region', $region);
            $contratista->where('regiones.region', $region);

            $direccion = $region;

            if ($region == 'Región I') {
                $personal = $personal->where('pir_empleados.is_regional_i', 1)->get();
                $contratista = $contratista->where('pir_empleados.is_regional_i', 1)->get();
            } else {
                $personal = $personal->where('pir_empleados.is_regional_i', 0)->get();
                $contratista = $contratista->where('pir_empleados.is_regional_i', 0)->get();
            }
        } else {
            $dir = PirDireccion::findOrFail($id_direccion);
            $direccion = $dir->direccion;
            $seccion = PirSeccion::findOrFail($dir->pir_seccion_id)->seccion;

            $personal = $personal->where('pir_direcciones.id', $id_direccion)->where('pir_empleados.is_regional_i', 0)->get();
            $contratista = $contratista->where('pir_direcciones.id', $id_direccion)->where('pir_empleados.is_regional_i', 0)->get();
        }

        if (!Storage::exists('templates/procesed/')) {
            Storage::makeDirectory('templates/procesed/');
        }

        $headerImagePath2 = public_path('/img/logoalt.svg');
        $type = pathinfo($headerImagePath2, PATHINFO_EXTENSION);
        $data = file_get_contents($headerImagePath2);
        $imgh2 = 'data:image/' . $type . ';base64,' . base64_encode($data);

        $footerImagePath1 = public_path('/img/footer.png');
        $type = pathinfo($footerImagePath1, PATHINFO_EXTENSION);
        $data = file_get_contents($footerImagePath1);
        $imgf1 = 'data:image/' . $type . ';base64,' . base64_encode($data);

        $htmlContent = '
    <html>
    <head>
    <style>
    body { font-family: "Trebuchet MS", sans-serif; }
    table { width: 100%; border-collapse: collapse; font-size: 10px; }
    th, td { border: 1px solid black; padding: 5px; text-align: center; }
    th { font-size: 8px; }
    @page { margin: 100px 50px 70px 50px; }
    header { position: fixed; top: -80px; left: 0; right: 0; height: 60px; text-align: center; }
    footer { position: fixed; bottom: -60px; left: 0; right: 0; height: 40px; text-align: center; line-height: 35px; }
    .header-content { position: relative; width: 100%; height: 100px; }
    .header-text { position: absolute; top: 30%; left: 50%; transform: translate(-50%, -50%); }
    .image-container { position: absolute; top: 5px; }
    .image-container.left { left: -135px; }
    .image-container.right { right: -135px; }
    .footer-content { width: 100%; text-align: center; }
    .footer-content img { height: 100%; width: 100%; }
    .main-content { margin-top: -30px; margin-bottom: 25px; }
    .signature-container {
        border-top: 1px solid black;
        width: 33%;
        margin-top: 150px;
        padding-top: 2px;
        text-align: center;
        position: absolute;
        right: 50px;
    }
    .director-name-container {
        border-top: 1px solid black;
        width: 33%;
        margin-top: 150px;
        padding-top: 2px;
        text-align: center;
        position: absolute;
        left: 50px;
    }
    .direccion-name {
        width: 33%;
        margin-top: 110px;
        padding-top: 2px;
        text-align: center;
        position: absolute;
        left: 50px;
    }
    </style>
    </head>
    <body>
    <header>
        <div class="header-content">
            <div class="image-container left">
                <img src="' . $imgh2 . '" alt="Image 2" style="height: 75%;">
            </div>
            <div class="header-text">
                <h3>FORMATO # PIR001 </br> INFORME DE ESTADO DE FUERZA</h3>
            </div>
        </div>
    </header>
    <footer>
    <div class="footer-content">
        </p>
            <img src="' . $imgf1 . '" alt="Footer Image">
        </div>  
    </footer>
    <main class="main-content">
    <p style="font-size: 9px; text-align:center;"><strong>Fecha: </strong>' . $fecha . '<strong> Hora: </strong>' . $hora . '</p>
    <h4><strong>SECCIÓN: </strong>' . (!empty($seccion) ? $seccion : 'N/A') . '</h4>
        <h4>Personal</h4>
        <table>
            <thead>
                <tr>
                    <th rowspan="2">No.</th>
                    <th rowspan="2">NOMBRE</th>
                    <th rowspan="2">UNIDAD</th>
                    <th rowspan="2">DIVISIÓN</th>
                    <th colspan="6">REPORTE</th>
                </tr>
                <tr>
                    <th>EN SE-CONRED</th>
                    <th>DE COMISIÓN</th>
                    <th>ASIGNACIÓN ESPECIAL</th>
                    <th>AUSENTE</th>
                    <th>GRUPO</th>
                    <th>OBSERVACIÓN</th>
                </tr>
            </thead>
            <tbody>';

        foreach ($personal as $indice => $emp) {
            $htmlContent .= '
                <tr>
                    <td>' . ($indice + 1) . '</td>
                    <td>' . $emp->nombre . '</td>
                    <td>' . $emp->direccion . '</td>
                    <td>' . $emp->seccion . '</td>';

            switch ($emp->reporte) {
                case 'Presente en sedes':
                    $htmlContent .= '
                            <td>X</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>' . $emp->grupo . '</td>
                            <td>' . $emp->observacion . '</td>
                        </tr>';
                    $p_en_sedes++;
                    break;

                case 'Comisión':
                    $htmlContent .= '
                            <td></td>
                            <td>X</td>
                            <td></td>
                            <td></td>
                            <td>' . $emp->grupo . '</td>
                            <td>' . $emp->observacion . '</td>
                        </tr>';
                    $p_comision++;
                    break;

                case 'Capacitación en el extranjero':
                    $htmlContent .= '
                            <td></td>
                            <td></td>
                            <td>X</td>
                            <td></td>
                            <td>' . $emp->grupo . '</td>
                            <td>' . $emp->observacion . '</td>
                        </tr>';
                    $p_especial++;
                    break;

                default:
                    $htmlContent .= '
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>X</td>
                            <td>' . $emp->grupo . '</td>
                            <td>' . $emp->observacion . '</td>
                        </tr>';
                    $p_ausente++;
                    break;
            }
        }

        if (count($personal) == 0) {
            $htmlContent .= '
                <tr>
                    <td colspan="10" style="text-align: center;">No hay datos disponibles</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>';
        }

        $htmlContent .= '
            </tbody>
            <tfoot>
				<tr>
					<td colspan="4" style="text-align: right"><strong>TOTAL</strong></td>
                    <td><strong>' . $p_en_sedes . '<strong></td>
                    <td><strong>' . $p_comision . '<strong></td>
                    <td><strong>' . $p_especial . '<strong></td>
                    <td><strong>' . $p_ausente . '<strong></td>
                    <td colspan="2" style="border-bottom: none; border-right: none;"></td>
				</tr>
			</tfoot>
        </table>
        <h4>Contratistas</h4>
        <table>
            <thead>
                <tr>
                    <th rowspan="2">No.</th>
                    <th rowspan="2">NOMBRE</th>
                    <th rowspan="2">UNIDAD</th>
                    <th rowspan="2">DIVISIÓN</th>
                    <th colspan="6">REPORTE</th>
                </tr>
                <tr>
                    <th>EN SE-CONRED</th>
                    <th>DE COMISIÓN</th>
                    <th>ASIGNACIÓN ESPECIAL</th>
                    <th>AUSENTE</th>
                    <th>GRUPO</th>
                    <th>OBSERVACIÓN</th>
                </tr>
            </thead>
            <tbody>';

        foreach ($contratista as $indice => $emp) {
            $htmlContent .= '
                <tr>
                    <td>' . ($indice + 1) . '</td>
                    <td>' . $emp->nombre . '</td>
                    <td>' . $emp->direccion . '</td>
                    <td>' . $emp->seccion . '</td>';

            switch ($emp->reporte) {
                case 'Disponible':
                    $htmlContent .= '
                            <td>X</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>' . $emp->grupo . '</td>
                            <td>' . $emp->observacion . '</td>
                        </tr>';
                    $c_en_sedes++;
                    break;

                case 'Comisión':
                    $htmlContent .= '
                            <td></td>
                            <td>X</td>
                            <td></td>
                            <td></td>
                            <td>' . $emp->grupo . '</td>
                            <td>' . $emp->observacion . '</td>
                        </tr>';
                    $c_comision++;
                    break;

                case 'Capacitación en el extranjero':
                    $htmlContent .= '
                            <td></td>
                            <td></td>
                            <td>X</td>
                            <td></td>
                            <td>' . $emp->grupo . '</td>
                            <td>' . $emp->observacion . '</td>
                        </tr>';
                    $c_especial++;
                    break;

                default:
                    $htmlContent .= '
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>X</td>
                            <td>' . $emp->grupo . '</td>
                            <td>' . $emp->observacion . '</td>
                        </tr>';
                    $c_ausente++;
                    break;
            }
        }

        if (count($contratista) == 0) {
            $htmlContent .= '
                <tr>
                    <td colspan="10" style="text-align: center;">No hay datos disponibles</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>';
        }

        $htmlContent .= '
            </tbody>
            <tfoot>
				<tr>
					<td colspan="4" style="text-align: right"><strong>TOTAL</strong></td>
                    <td><strong>' . $c_en_sedes . '<strong></td>
                    <td><strong>' . $c_comision . '<strong></td>
                    <td><strong>' . $c_especial . '<strong></td>
                    <td><strong>' . $c_ausente . '<strong></td>
                    <td colspan="2" style="border-bottom: none; border-right: none;"></td>
				</tr>
			</tfoot>
        </table>
        <div class="direccion-name">
            <p style="font-size: 12px;">
                <strong>' . $direccion . '</strong>
            </p>
        </div>
        <div class="director-name-container">
            <p style="font-size: 10px;">
                Nombre de la Dirección
            </p>
        </div>
        <div class="signature-container">
            <p style="font-size: 10px;">
                Firma del Director/Jefe
            </p>
        </div>
    </main>
</body>
</html>';

        // Configurar opciones de Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);

        // Cargar contenido HTML en Dompdf
        $dompdf->loadHtml($htmlContent);

        // Configurar tamaño y orientación del papel
        $dompdf->setPaper('Letter', 'portrait'); // Ajusta según tus necesidades

        // Renderizar el PDF
        $dompdf->render();

        // Agregar números de página
        $canvas = $dompdf->getCanvas();
        $font = $dompdf->getFontMetrics()->getFont('Trebuchet MS', 'normal');
        $size = 8;
        $canvas->page_text(
            ($canvas->get_width() * 0.5 - 10), // Posición horizontal
            $canvas->get_height() - 50,  // Posición vertical
            "{PAGE_NUM} de {PAGE_COUNT}", // Texto a agregar
            $font,
            $size,
            array(0, 0, 0, 0.6)
        );

        // Guardar el archivo PDF
        $pdfFilePath = 'templates/procesed/' . $fecha_hora . '_PIR.pdf';
        file_put_contents($pdfFilePath, $dompdf->output());

        // Descargar el archivo
        return 'templates/procesed/' . $fecha_hora . '_PIR.pdf';
    }

    public function generateDisponibilidadReport($id_direccion, $region)
    {

        $personal = PirEmpleado::select(
            'pir_empleados.nombre',
            'pir_empleados.observacion',
            'pir_empleados.pir_reporte_id as id_reporte',
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
            'pir_empleados.pir_reporte_id as id_reporte',
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
            if ($region == 'Región I') {
                $personal->where('pir_empleados.is_regional_i', 1)->where('region', $region);
                $contratista->where('pir_empleados.is_regional_i', 1)->where('region', $region);
            } else {
                $personal->where('region', $region);
                $contratista->where('region', $region);
            }
        } else {
            $direccion = PirDireccion::findOrFail($id_direccion);
            $personal = $personal->where('pir_direccion_id', $id_direccion);
            $contratista = $contratista->where('pir_direccion_id', $id_direccion);
        }

        $personal = $personal
            ->whereIn('renglones.renglon', ['011', '021', '022', '031'])
            ->where('pir_empleados.activo', 1)
            ->orderBy('pir_empleados.nombre', 'asc')
            ->get();

        $contratista = $contratista
            ->where('renglones.renglon', '029')
            ->where('pir_empleados.activo', 1)
            ->orderBy('pir_empleados.nombre', 'asc')
            ->get();

        $fecha = date('d/m/Y');
        $hora = date('H:i:s');
        $fecha_hora = date('Y_m_d H_i_s');

        $estados = PirReporte::all();

        /* PLANTILLA */
        /* $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('templates/disponibilidad.xlsx');
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

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx'); */

        if (!Storage::exists('templates/procesed/')) {
            Storage::makeDirectory('templates/procesed/');
        }

        /* $writer->save('templates/procesed/' . $fecha_hora . '_DISPONIBILIDAD.xlsx'); */

        $headerImagePath1 = public_path('/img/gob.svg');
        $type = pathinfo($headerImagePath1, PATHINFO_EXTENSION);
        $data = file_get_contents($headerImagePath1);
        $imgh1 = 'data:image/' . $type . ';base64,' . base64_encode($data);

        $headerImagePath2 = public_path('/img/logoalt.svg');
        $type = pathinfo($headerImagePath2, PATHINFO_EXTENSION);
        $data = file_get_contents($headerImagePath2);
        $imgh2 = 'data:image/' . $type . ';base64,' . base64_encode($data);

        $footerImagePath1 = public_path('/img/footer.png');
        $type = pathinfo($footerImagePath1, PATHINFO_EXTENSION);
        $data = file_get_contents($footerImagePath1);
        $imgf1 = 'data:image/' . $type . ';base64,' . base64_encode($data);

        // HTML básico para depuración
        $htmlContent = '
<html>
<head>
<style>
body { font-family: "Trebuchet MS", sans-serif; }
table { width: 100%; border-collapse: collapse; font-size: 10px; }
th, td { border: 1px solid black; padding: 5px; text-align: center; }
th { font-size: 8px; }
@page { margin: 100px 50px 70px 50px; }
header { position: fixed; top: -80px; left: 0; right: 0; height: 60px; text-align: center; }
footer { position: fixed; bottom: 0px; left: 0; right: 0; height: 40px; text-align: center; line-height: 35px; }
.header-content { position: relative; width: 100%; height: 100px; }
.header-text { position: absolute; top: 30%; left: 50%; transform: translate(-50%, -50%); }
.image-container { position: absolute; top: 5px; }
.image-container.left { left: -295px; }
.image-container.right { right: -135px; }
.footer-content { width: 100%; text-align: center; }
.footer-content img { height: 100%; width: 100%; }
.main-content { margin-top: -30px; margin-bottom: 25px; }
.signature-container {
    border-top: 1px solid black;
    width: 33%;
    margin-top: 150px; /* Ajustar el margen superior según sea necesario */
    padding-top: 2px; /* Ajustar el padding-top según sea necesario */
    text-align: center; /* Centrar el contenido de la firma */
    position: absolute;
}
</style>
</head>
<body>
    <header>
        <div class="header-content">
            <div class="image-container left">
                <img src="' . $imgh1 . '" alt="Image 1" style="height: 75%;">
            </div>
            <div class="image-container right">
                <img src="' . $imgh2 . '" alt="Image 2" style="height: 75%;">
            </div>
            <div class="header-text">
                <h3>CONTROL DE DISPONIBILIDAD <br> ' . $direccion->direccion . '</h3>
            </div>
        </div>
    </header>
    <footer>
    <div class="footer-content">
        <p style="font-size: 9px; line-height: 15px; margin-bottom: 20px; text-align: justify;">
    ';
        foreach ($estados as $estado) {
            $htmlContent .= $estado->id . '.' . $estado->reporte . '&ensp;';
        }
        $htmlContent .= '
        </p>
            <img src="' . $imgf1 . '" alt="Footer Image">
        </div>
        
    </footer>
    <main class="main-content">
    <p style="font-size: 9px; text-align:center;"><strong>Fecha: </strong>' . $fecha . '<strong> Hora: </strong>' . $hora . '</p>
        <h4>Personal</h4>
        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>NOMBRE</th>
                    <th>RENGLÓN</th>
                    <th>PUESTO</th>
                    <th>DIRECCIÓN</th>
                    <th>REGIÓN</th>
                    <th>DEPARTAMENTO</th>
                    <th>ESTADO</th>
                    <th>OBSERVACIONES</th>
                </tr>
            </thead>
            <tbody>';

        foreach ($personal as $indice => $emp) {
            $htmlContent .= '
                <tr>
                    <td>' . ($indice + 1) . '</td>
                    <td>' . $emp->nombre . '</td>
                    <td>' . $emp->renglon . '</td>
                    <td>' . $emp->puesto . '</td>
                    <td>' . $emp->direccion . '</td>
                    <td>' . $emp->region . '</td>
                    <td>' . $emp->departamento . '</td>
                    <td>' . $emp->id_reporte . '</td>
                    <td>' . $emp->observacion . '</td>
                </tr>';
        }

        if (count($personal) == 0) {
            $htmlContent .= '
                <tr>
                    <td colspan="9" style="text-align: center;">No hay datos disponibles</td>
                </tr>';
        }

        $htmlContent .= '
            </tbody>
        </table>
        <h4>Contratistas</h4>
        <table>
            <thead>
                <tr>
                <th>No.</th>
                <th>NOMBRE</th>
                <th>RENGLÓN</th>
                <th>PUESTO</th>
                <th>DIRECCIÓN</th>
                <th>REGIÓN</th>
                <th>DEPARTAMENTO</th>
                <th>ESTADO</th>
                <th>OBSERVACIONES</th>
                </tr>
            </thead>
            <tbody>';

        foreach ($contratista as $indice => $emp) {
            $htmlContent .= '
                <tr>
                <td>' . ($indice + 1) . '</td>
                <td>' . $emp->nombre . '</td>
                <td>' . $emp->renglon . '</td>
                <td>' . $emp->puesto . '</td>
                <td>' . $emp->direccion . '</td>
                <td>' . $emp->region . '</td>
                <td>' . $emp->departamento . '</td>
                <td>' . $emp->id_reporte . '</td>
                <td>' . $emp->observacion . '</td>
                </tr>';
        }

        if (count($contratista) == 0) {
            $htmlContent .= '
                <tr>
                    <td colspan="9" style="text-align: center;">No hay datos disponibles</td>
                </tr>';
        }

        $htmlContent .= '
            </tbody>
        </table>
        <div class="signature-container">
            <p style="font-size: 10px;">
                Firma del Director/Jefe
            </p>
        </div>
    </main>
</body>
</html>';

        // Configurar opciones de Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);

        // Cargar contenido HTML en Dompdf
        $dompdf->loadHtml($htmlContent);

        // Configurar tamaño y orientación del papel
        $dompdf->setPaper('Letter', 'landscape'); // Ajusta según tus necesidades

        // Renderizar el PDF
        $dompdf->render();

        // Agregar números de página
        $canvas = $dompdf->getCanvas();
        $font = $dompdf->getFontMetrics()->getFont('Trebuchet MS', 'normal');
        $size = 8;
        $canvas->page_text(
            ($canvas->get_width() * 0.5 - 10), // Posición horizontal
            $canvas->get_height() - 50,  // Posición vertical
            "{PAGE_NUM} de {PAGE_COUNT}", // Texto a agregar
            $font,
            $size,
            array(0, 0, 0, 0.6)
        );

        // Guardar el archivo PDF
        $pdfFilePath = 'templates/procesed/' . $fecha_hora . '_DISPONIBILIDAD.pdf';
        file_put_contents($pdfFilePath, $dompdf->output());

        // Descargar el archivo
        return 'templates/procesed/' . $fecha_hora . '_DISPONIBILIDAD.pdf';
    }

    public function generarReporteDiario()
    {
        $fecha = Carbon::now()->translatedFormat('l, d \\de F \\de Y');
        $fecha_hora = date('Y_m_d H_i_s');

        $orden_direcciones = [1, 13, 9, 8, 12, 15, 14, 11, 2, 6, 4, 5, 7, 10, 22, 3, 16, 18, 17, 20, 19, 21];

        $reportes = PirReporte::all();

        $direcciones = PirDireccion::select(
            'pir_direcciones.id as id_direccion',
            'pir_direcciones.direccion as direccion',
            'pir_direcciones.hora_actualizacion as actualizacion'
        )
            ->selectRaw('COUNT(pir_empleados.id) AS total_registros_direccion')
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
            ->selectRaw('COUNT(CASE WHEN pir_reportes.reporte = "Disponible" THEN 1 ELSE NULL END) AS disponible')
            ->selectRaw('COUNT(CASE WHEN pir_reportes.reporte = "Problemas de salud" THEN 1 ELSE NULL END) AS salud')
            ->selectRaw('COUNT(CASE WHEN pir_reportes.reporte = "No Disponible" THEN 1 ELSE NULL END) AS no_disponible')
            ->leftJoin('pir_empleados', function ($join) {
                $join->on('pir_direcciones.id', '=', 'pir_empleados.pir_direccion_id')
                    ->leftJoin('regiones', 'pir_empleados.region_id', '=', 'regiones.id')
                    ->leftJoin('pir_reportes', 'pir_empleados.pir_reporte_id', '=', 'pir_reportes.id')
                    ->where('regiones.region', 'Región I')
                    ->where('pir_empleados.is_regional_i', 0)
                    ->where('pir_empleados.activo', 1);
            })
            ->whereIn('pir_direcciones.id', $orden_direcciones)
            ->groupBy('pir_direcciones.direccion')
            ->orderByRaw('FIELD(pir_direcciones.id,' . implode(',', $orden_direcciones) . ')')
            ->get();

        $region_i = PirDireccion::select(
            'regiones.region as region',
            'regiones.nombre as nombre',
            'pir_direcciones.hora_actualizacion as actualizacion'
        )
            ->rightJoin('pir_empleados', 'pir_direcciones.id', '=', 'pir_empleados.pir_direccion_id')
            ->rightJoin('pir_puestos', 'pir_empleados.id', '=', 'pir_puestos.pir_empleado_id')
            ->rightJoin('catalogo_puestos', 'pir_puestos.catalogo_puesto_id', '=', 'catalogo_puestos.id')
            ->rightJoin('regiones', 'pir_empleados.region_id', '=', 'regiones.id')
            ->leftjoin('pir_reportes', 'pir_empleados.pir_reporte_id', '=', 'pir_reportes.id')
            ->selectRaw('COUNT(pir_empleados.id) AS total_registros_regionales')
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
            ->selectRaw('COUNT(CASE WHEN pir_reportes.reporte = "Disponible" THEN 1 ELSE NULL END) AS disponible')
            ->selectRaw('COUNT(CASE WHEN pir_reportes.reporte = "Problemas de salud" THEN 1 ELSE NULL END) AS salud')
            ->selectRaw('COUNT(CASE WHEN pir_reportes.reporte = "No Disponible" THEN 1 ELSE NULL END) AS no_disponible')
            ->groupBy('regiones.region')
            ->where('pir_empleados.activo', 1)
            ->where('regiones.region', 'Región I')
            ->where('pir_empleados.is_regional_i', 1)
            ->orderBy('regiones.id', 'asc');

        $region_otras = PirDireccion::select(
            'regiones.region as region',
            'regiones.nombre as nombre',
            'pir_direcciones.hora_actualizacion as actualizacion'
        )
            ->rightJoin('pir_empleados', 'pir_direcciones.id', '=', 'pir_empleados.pir_direccion_id')
            ->rightJoin('regiones', 'pir_empleados.region_id', '=', 'regiones.id')
            ->leftjoin('pir_reportes', 'pir_empleados.pir_reporte_id', '=', 'pir_reportes.id')
            ->selectRaw('COUNT(pir_empleados.id) AS total_registros_regionales')
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
            ->selectRaw('COUNT(CASE WHEN pir_reportes.reporte = "Disponible" THEN 1 ELSE NULL END) AS disponible')
            ->selectRaw('COUNT(CASE WHEN pir_reportes.reporte = "Problemas de salud" THEN 1 ELSE NULL END) AS salud')
            ->selectRaw('COUNT(CASE WHEN pir_reportes.reporte = "No Disponible" THEN 1 ELSE NULL END) AS no_disponible')
            ->groupBy('regiones.region')
            ->where('pir_empleados.activo', 1)
            ->where('regiones.region', 'NOT LIKE', 'Región I')
            ->orderBy('regiones.id', 'asc');

        $regionales = $region_i->union($region_otras)->get();

        /* PLANTILLA */
        /* $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('templates/reporte.xlsx');
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
            $doc->getCell('W' . $fila_actual)->setValue($dir->vacaciones); */
        /* if ($dir->actualizacion >= $dia_actual . ' 07:45:00' && $dir->actualizacion <= $dia_actual . ' 09:45:00') { */
        /* $doc->getCell('Z' . $fila_actual)->setValue($observacion); */
        /* } else {
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
        }*/

        /* foreach ($regionales as $indice => $region) {
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
            $doc->getCell('W' . $fila_actual)->setValue($region->vacaciones); */
        /* if ($region->actualizacion >= $dia_actual . ' 07:45:00' && $region->actualizacion <= $dia_actual . ' 09:45:00') { */
        /* $doc->getCell('Z' . $fila_actual)->setValue($observacion); */
        /* } else {
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
        }*/

        /* $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx'); */

        if (!Storage::exists('templates/procesed/')) {
            Storage::makeDirectory('templates/procesed/');
        }

        $headerImagePath2 = public_path('/img/logoalt.svg');
        $type = pathinfo($headerImagePath2, PATHINFO_EXTENSION);
        $data = file_get_contents($headerImagePath2);
        $imgh2 = 'data:image/' . $type . ';base64,' . base64_encode($data);

        $footerImagePath1 = public_path('/img/footer.png');
        $type = pathinfo($footerImagePath1, PATHINFO_EXTENSION);
        $data = file_get_contents($footerImagePath1);
        $imgf1 = 'data:image/' . $type . ';base64,' . base64_encode($data);

        $htmlContent = '
    <html>
    <head>
    <style>
    body { font-family: "Trebuchet MS", sans-serif; }
table { width: 100%; border-collapse: collapse; font-size: 8px; }
th, td { border: 1px solid black; padding: 3px; text-align: center; }
th { font-size: 6px; }
@page { margin: 100px 50px 70px 50px; }
header { position: fixed; top: -80px; left: 0; right: 0; height: 60px; text-align: center; }
footer { position: fixed; bottom: -60px; left: 0; right: 0; height: 40px; text-align: center; line-height: 35px; }
.header-content { position: relative; width: 100%; height: 100px; }
.header-text { position: absolute; top: 30%; left: 50%; transform: translate(-50%, -50%); }
.image-container { position: absolute; top: 5px; }
.image-container.left { left: -135px; }
.image-container.right { right: -135px; }
.footer-content { width: 100%; text-align: center; }
.footer-content img { height: 100%; width: 100%; }
.main-content { margin-top: -30px; margin-bottom: 25px; }
    </style>
    </head>
    <body>
    <header>
        <div class="header-content">
            <div class="image-container left">
                <img src="' . $imgh2 . '" alt="Image 2" style="height: 75%;">
            </div>
            <div class="header-text">
                <h3>REPORTE DIARIO</h3>
            </div>
        </div>
    </header>
    <footer>
    <div class="footer-content">
        </p>
            <img src="' . $imgf1 . '" alt="Footer Image">
        </div>  
    </footer>
    <main class="main-content">
    <p style="font-size: 9px; text-align:center;"><strong>Fecha: </strong>' . $fecha . '</p>
        <table>
            <thead style="height: 30px;">
                <tr>
                    <th>No.</th>
                    <th style="width: 18%;">DEPENDENCIAS</th>';

        foreach ($reportes as $reporte) {
            $htmlContent .= '<th>' . $reporte->id . '.' . $reporte->reporte . '</th>';
        }

        $htmlContent .= '<th>TOTAL REPORTADO</th>
            <th style="width: 20%;">OBSERVACIONES</th>
                    </tr>
                </thead>
            <tbody>';

        $observacion = '';
        foreach ($direcciones as $indice => $dir) {
            if ($dir->suspendidos_igss > 0) {
                $empleados = $this->getEmpleados($dir->id_direccion, 2);
                $observacion .= "<b>2. Suspendidos por el IGSS</b><br>";
                foreach ($empleados as $i => $emp) {
                    $observacion .= ($i + 1) . '.' . $emp->nombre . " " . $emp->renglon . " / " . $emp->observacion . "<br>";
                }
            }
            if ($dir->suspendidos_clinica > 0) {
                $empleados = $this->getEmpleados($dir->id_direccion, 3);
                $observacion .= "<b>3. Suspendidos por la Clínica Médica</b><br>";
                foreach ($empleados as $i => $emp) {
                    $observacion .= ($i + 1) . '.' . $emp->nombre . " " . $emp->renglon . " / " . $emp->observacion . "<br>";
                }
            }
            if ($dir->licencia > 0) {
                $empleados = $this->getEmpleados($dir->id_direccion, 4);
                $observacion .= "<b>4. Licencia con goce de salario</b><br>";
                foreach ($empleados as $i => $emp) {
                    $observacion .= ($i + 1) . '.' . $emp->nombre . " " . $emp->renglon . " / " . $emp->observacion . "<br>";
                }
            }
            if ($dir->permiso > 0) {
                $empleados = $this->getEmpleados($dir->id_direccion, 5);
                $observacion .= "<b>5. Permiso autorizado</b><br>";
                foreach ($empleados as $i => $emp) {
                    $observacion .= ($i + 1) . '.' . $emp->nombre . " " . $emp->renglon . " / " . $emp->observacion . "<br>";
                }
            }
            if ($dir->ausente > 0) {
                $empleados = $this->getEmpleados($dir->id_direccion, 9);
                $observacion .= "<b>9. Ausente (justificar)</b><br>";
                foreach ($empleados as $i => $emp) {
                    $observacion .= ($i + 1) . '.' . $emp->nombre . " " . $emp->renglon . " / " . $emp->observacion . "<br>";
                }
            }
            if ($dir->salud > 0) {
                $empleados = $this->getEmpleados($dir->id_direccion, 12);
                $observacion .= "<b>12. Problemas de salud</b><br>";
                foreach ($empleados as $i => $emp) {
                    $observacion .= ($i + 1) . '.' . $emp->nombre . " " . $emp->renglon . " / " . $emp->observacion . "<br>";
                }
            }
            if ($dir->no_disponible > 0) {
                $empleados = $this->getEmpleados($dir->id_direccion, 13);
                $observacion .= "<b>13. No disponible</b><br>";
                foreach ($empleados as $i => $emp) {
                    $observacion .= ($i + 1) . '.' . $emp->nombre . " " . $emp->renglon . " / " . $emp->observacion . "<br>";
                }
            }
            $htmlContent .= '
                <tr>
                    <td>' . ($indice + 1) . '</td>
                    <td style="font-size: 9px; text-align: justify;">' . $dir->direccion . '</td>
                    <td>' . $dir->presente_sedes . '</td>
                    <td>' . $dir->suspendidos_igss . '</td>
                    <td>' . $dir->suspendidos_clinica . '</td>
                    <td>' . $dir->licencia . '</td>
                    <td>' . $dir->permiso . '</td>
                    <td>' . $dir->comision . '</td>
                    <td>' . $dir->descanso . '</td>
                    <td>' . $dir->capacitacion . '</td>
                    <td>' . $dir->ausente . '</td>
                    <td>' . $dir->vacaciones . '</td>
                    <td>' . $dir->disponible . '</td>
                    <td>' . $dir->salud . '</td>
                    <td>' . $dir->no_disponible . '</td>
                    <td>' . $dir->total_registros_direccion . '</td>
                    <td style="text-align: justify">' . $observacion . '</td>
                </tr>';
            $observacion = '';
        }

        foreach ($regionales as $indice => $reg) {
            if ($dir->suspendidos_igss > 0) {
                $empleados = $this->getEmpleados($dir->id_direccion, 2);
                $observacion .= "<b>2. Suspendidos por el IGSS</b><br>";
                foreach ($empleados as $i => $emp) {
                    $observacion .= ($i + 1) . '.' . $emp->nombre . " " . $emp->renglon . " / " . $emp->observacion . "<br>";
                }
            }
            if ($dir->suspendidos_clinica > 0) {
                $empleados = $this->getEmpleados($dir->id_direccion, 3);
                $observacion .= "<b>3. Suspendidos por la Clínica Médica</b><br>";
                foreach ($empleados as $i => $emp) {
                    $observacion .= ($i + 1) . '.' . $emp->nombre . " " . $emp->renglon . " / " . $emp->observacion . "<br>";
                }
            }
            if ($dir->licencia > 0) {
                $empleados = $this->getEmpleados($dir->id_direccion, 4);
                $observacion .= "<b>4. Licencia con goce de salario</b><br>";
                foreach ($empleados as $i => $emp) {
                    $observacion .= ($i + 1) . '.' . $emp->nombre . " " . $emp->renglon . " / " . $emp->observacion . "<br>";
                }
            }
            if ($dir->permiso > 0) {
                $empleados = $this->getEmpleados($dir->id_direccion, 5);
                $observacion .= "<b>5. Permiso autorizado</b><br>";
                foreach ($empleados as $i => $emp) {
                    $observacion .= ($i + 1) . '.' . $emp->nombre . " " . $emp->renglon . " / " . $emp->observacion . "<br>";
                }
            }
            if ($dir->ausente > 0) {
                $empleados = $this->getEmpleados($dir->id_direccion, 9);
                $observacion .= "<b>9. Ausente (justificar)</b><br>";
                foreach ($empleados as $i => $emp) {
                    $observacion .= ($i + 1) . '.' . $emp->nombre . " " . $emp->renglon . " / " . $emp->observacion . "<br>";
                }
            }
            if ($dir->salud > 0) {
                $empleados = $this->getEmpleados($dir->id_direccion, 12);
                $observacion .= "<b>12. Problemas de salud</b><br>";
                foreach ($empleados as $i => $emp) {
                    $observacion .= ($i + 1) . '.' . $emp->nombre . " " . $emp->renglon . " / " . $emp->observacion . "<br>";
                }
            }
            if ($dir->no_disponible > 0) {
                $empleados = $this->getEmpleados($dir->id_direccion, 13);
                $observacion .= "<b>13. No disponible</b><br>";
                foreach ($empleados as $i => $emp) {
                    $observacion .= ($i + 1) . '.' . $emp->nombre . " " . $emp->renglon . " / " . $emp->observacion . "<br>";
                }
            }

            $htmlContent .= '
                <tr>
                    <td>' . ($indice + count($direcciones)) . '</td>
                    <td style="font-size: 9px; text-align: justify;">' . $reg->region . ' - ' . $reg->nombre . '</td>
                    <td>' . $reg->presente_sedes . '</td>
                    <td>' . $reg->suspendidos_igss . '</td>
                    <td>' . $reg->suspendidos_clinica . '</td>
                    <td>' . $reg->licencia . '</td>
                    <td>' . $reg->permiso . '</td>
                    <td>' . $reg->comision . '</td>
                    <td>' . $reg->descanso . '</td>
                    <td>' . $reg->capacitacion . '</td>
                    <td>' . $reg->ausente . '</td>
                    <td>' . $reg->vacaciones . '</td>
                    <td>' . $reg->disponible . '</td>
                    <td>' . $reg->salud . '</td>
                    <td>' . $reg->no_disponible . '</td>
                    <td>' . $reg->total_registros_regionales . '</td>
                    <td style="text-align: justify">' . $observacion . '</td>
                </tr>';
            $observacion = '';
        }

        $headers = array_keys($direcciones->first()->toArray());
        $headers = array_slice($headers, 4);

        $htmlContent .= '
            </tbody>
            <tfoot>
				<tr>
					<td colspan="2" style="text-align: right"><strong>TOTAL</strong></td>';

        foreach ($headers as $header) {
            $htmlContent .= '
                        <td><strong>' . $direcciones->sum($header) + $regionales->sum($header) . '<strong></td>
                    ';
        }

        $htmlContent .= '
                    <td><strong>' . $direcciones->sum('total_registros_direccion') + $regionales->sum('total_registros_regionales') . '</strong></td>
                    <td style="border-bottom: none; border-right: none;"></td>
				</tr>
			</tfoot>
        </table>

        <table style="font-size: 14px; width: 50%; margin: 40px auto 0 auto;">
        <tr>';

        foreach ($reportes as $index => $reporte) {
            $htmlContent .= '<tr>';
            $htmlContent .= '<td style="text-align: justify;">' . $reporte->id . '. ' . $reporte->reporte . '</td>';

            $header = $headers[$index] ?? '';

            if (!empty($header)) {

                $suma_direcciones = $direcciones->sum($header);
                $suma_regionales = $regionales->sum($header);

                $htmlContent .= '<td><strong>' . ($suma_direcciones + $suma_regionales) . '</strong></td>';
            } else {
                $htmlContent .= '<td><strong>0</strong></td>';
            }
        }

        $htmlContent .= '
        </tr>
        <tfoot>
            <tr>
                <td><b>TOTAL REPORTADO</b></td>
                <td><b>' . $direcciones->sum('total_registros_direccion') + $regionales->sum('total_registros_regionales') . '</b></td>
            </tr>
        </tfoot>
        </table>
    </main>
</body>
</html>';

        // Configurar opciones de Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);

        // Cargar contenido HTML en Dompdf
        $dompdf->loadHtml($htmlContent);

        // Configurar tamaño y orientación del papel
        $dompdf->setPaper('Letter', 'landscape'); // Ajusta según tus necesidades

        // Renderizar el PDF
        $dompdf->render();

        // Agregar números de página
        $canvas = $dompdf->getCanvas();
        $font = $dompdf->getFontMetrics()->getFont('Trebuchet MS', 'normal');
        $size = 8;
        $canvas->page_text(
            ($canvas->get_width() * 0.5 - 10), // Posición horizontal
            $canvas->get_height() - 50,  // Posición vertical
            "{PAGE_NUM} de {PAGE_COUNT}", // Texto a agregar
            $font,
            $size,
            array(0, 0, 0, 0.6)
        );

        // Guardar el archivo PDF
        $pdfFilePath = 'templates/procesed/' . $fecha_hora . '_REPORTE_DIARIO.pdf';
        file_put_contents($pdfFilePath, $dompdf->output());

        /* $writer->save('templates/procesed/' . $fecha_hora . '_REPORTE_DIARIO.xlsx'); */

        // Descargar el archivo
        return 'templates/procesed/' . $fecha_hora . '_REPORTE_DIARIO.pdf';
    }

    public function generarReporteAusencias()
    {
        $fecha = date('d/m/Y');
        $hora = date('H:i:s');
        $fecha_hora = date('Y_m_d H_i_s');

        /* PLANTILLA */
        /* $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('templates/ausencias.xlsx');
        $ausente = $spreadsheet->setActiveSheetIndexByName('Ausencias');
        $comision = $spreadsheet->setActiveSheetIndexByName('Comisión');
        $capacitacion = $spreadsheet->setActiveSheetIndexByName('Capacitación');

        $ausente->setCellValue('B6', $fecha);
        $ausente->setCellValue('E6', $hora);

        $comision->setCellValue('B6', $fecha);
        $comision->setCellValue('E6', $hora);

        $capacitacion->setCellValue('B6', $fecha);
        $capacitacion->setCellValue('E6', $hora);

        $fila_inicial = 8; */

        $ausentes = PirEmpleado::select(
            'pir_empleados.nombre',
            'pir_empleados.observacion',
            'pir_empleados.pir_reporte_id as id_reporte',
            'pir_reportes.reporte as reporte',
            'pir_empleados.pir_grupo_id',
            'pir_grupos.grupo as grupo',
            'catalogo_puestos.puesto as puesto',
            'renglones.renglon as renglon',
            'pir_direcciones.direccion as direccion',
            'departamentos.nombre as departamento',
            'regiones.region as region'
        )
            ->join('pir_puestos', 'pir_empleados.id', '=', 'pir_puestos.pir_empleado_id')
            ->leftJoin('departamentos', 'pir_empleados.departamento_id', '=', 'departamentos.id')
            ->join('regiones', 'pir_empleados.region_id', '=', 'regiones.id')
            ->join('catalogo_puestos', 'pir_puestos.catalogo_puesto_id', '=', 'catalogo_puestos.id')
            ->join('renglones', 'catalogo_puestos.renglones_id', '=', 'renglones.id')
            ->join('pir_reportes', 'pir_empleados.pir_reporte_id', '=', 'pir_reportes.id')
            ->join('pir_grupos', 'pir_empleados.pir_grupo_id', '=', 'pir_grupos.id')
            ->join('pir_direcciones', 'pir_empleados.pir_direccion_id', '=', 'pir_direcciones.id')
            ->whereIn('pir_reportes.id', [2, 3, 4, 5, 7, 9, 10, 12, 13])
            ->where('pir_empleados.activo', 1)
            ->get();

        $comisiones = PirEmpleado::select(
            'pir_empleados.nombre',
            'pir_empleados.observacion',
            'pir_empleados.pir_reporte_id as id_reporte',
            'pir_reportes.reporte as reporte',
            'pir_empleados.pir_grupo_id',
            'pir_grupos.grupo as grupo',
            'catalogo_puestos.puesto as puesto',
            'renglones.renglon as renglon',
            'pir_direcciones.direccion as direccion',
            'departamentos.nombre as departamento',
            'regiones.region as region'
        )
            ->join('pir_puestos', 'pir_empleados.id', '=', 'pir_puestos.pir_empleado_id')
            ->leftJoin('departamentos', 'pir_empleados.departamento_id', '=', 'departamentos.id')
            ->join('regiones', 'pir_empleados.region_id', '=', 'regiones.id')
            ->join('catalogo_puestos', 'pir_puestos.catalogo_puesto_id', '=', 'catalogo_puestos.id')
            ->join('renglones', 'catalogo_puestos.renglones_id', '=', 'renglones.id')
            ->join('pir_reportes', 'pir_empleados.pir_reporte_id', '=', 'pir_reportes.id')
            ->join('pir_grupos', 'pir_empleados.pir_grupo_id', '=', 'pir_grupos.id')
            ->join('pir_direcciones', 'pir_empleados.pir_direccion_id', '=', 'pir_direcciones.id')
            ->where('reporte', 'Comisión')
            ->where('pir_empleados.activo', 1)
            ->get();

        $capacitaciones = PirEmpleado::select(
            'pir_empleados.nombre',
            'pir_empleados.observacion',
            'pir_empleados.pir_reporte_id as id_reporte',
            'pir_reportes.reporte as reporte',
            'pir_empleados.pir_grupo_id',
            'pir_grupos.grupo as grupo',
            'catalogo_puestos.puesto as puesto',
            'renglones.renglon as renglon',
            'pir_direcciones.direccion as direccion',
            'departamentos.nombre as departamento',
            'regiones.region as region'
        )
            ->join('pir_puestos', 'pir_empleados.id', '=', 'pir_puestos.pir_empleado_id')
            ->leftJoin('departamentos', 'pir_empleados.departamento_id', '=', 'departamentos.id')
            ->join('regiones', 'pir_empleados.region_id', '=', 'regiones.id')
            ->join('catalogo_puestos', 'pir_puestos.catalogo_puesto_id', '=', 'catalogo_puestos.id')
            ->join('renglones', 'catalogo_puestos.renglones_id', '=', 'renglones.id')
            ->join('pir_reportes', 'pir_empleados.pir_reporte_id', '=', 'pir_reportes.id')
            ->join('pir_grupos', 'pir_empleados.pir_grupo_id', '=', 'pir_grupos.id')
            ->join('pir_direcciones', 'pir_empleados.pir_direccion_id', '=', 'pir_direcciones.id')
            ->where('reporte', 'Capacitación en el extranjero')
            ->where('pir_empleados.activo', 1)
            ->get();

        $estados = PirReporte::all();

        $num_elementos_estados = $estados->count();
        $num_columnas_estados = 3;
        $elementos_por_columna_estados = ceil($num_elementos_estados / $num_columnas_estados);

        // Crear las columnas para los estados
        $columnas_estados = [];
        $indice_inicio_estados = 0;
        for ($i = 0; $i < $num_columnas_estados; $i++) {
            $columnas_estados[] = $estados->slice($indice_inicio_estados, $elementos_por_columna_estados);
            $indice_inicio_estados += $elementos_por_columna_estados;
        }

        /* if (count($ausentes) > 2) {
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
        } */

        /* $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx'); */

        if (!Storage::exists('templates/procesed/')) {
            Storage::makeDirectory('templates/procesed/');
        }

        /* $writer->save('templates/procesed/' . $fecha_hora . '_CONTROL_AUSENCIAS.xlsx'); */

        $headerImagePath1 = public_path('/img/gob.svg');
        $type = pathinfo($headerImagePath1, PATHINFO_EXTENSION);
        $data = file_get_contents($headerImagePath1);
        $imgh1 = 'data:image/' . $type . ';base64,' . base64_encode($data);

        $headerImagePath2 = public_path('/img/logoalt.svg');
        $type = pathinfo($headerImagePath2, PATHINFO_EXTENSION);
        $data = file_get_contents($headerImagePath2);
        $imgh2 = 'data:image/' . $type . ';base64,' . base64_encode($data);

        $footerImagePath1 = public_path('/img/footer.png');
        $type = pathinfo($footerImagePath1, PATHINFO_EXTENSION);
        $data = file_get_contents($footerImagePath1);
        $imgf1 = 'data:image/' . $type . ';base64,' . base64_encode($data);

        // HTML básico para depuración
        $htmlContent = '
<html>
<head>
<style>
body { font-family: "Trebuchet MS", sans-serif; }
table { width: 100%; border-collapse: collapse; font-size: 10px; }
th, td { border: 1px solid black; padding: 5px; text-align: center; }
th { font-size: 8px; }
@page { margin: 100px 50px 70px 50px; }
header { position: fixed; top: -80px; left: 0; right: 0; height: 60px; text-align: center; }
footer { position: fixed; bottom: 0px; left: 0; right: 0; height: 40px; text-align: center; line-height: 35px; }
.header-content { position: relative; width: 100%; height: 100px; }
.header-text { position: absolute; top: 30%; left: 50%; transform: translate(-50%, -50%); }
.image-container { position: absolute; top: 5px; }
.image-container.left { left: -295px; }
.image-container.right { right: -135px; }
.footer-content { width: 100%; text-align: center; }
.footer-content img { height: 100%; width: 100%; }
.main-content { margin-top: -30px; margin-bottom: 25px; }
</style>
</head>
<body>
<header>
<div class="header-content">
    <div class="image-container left">
        <img src="' . $imgh1 . '" alt="Image 1" style="height: 75%;">
    </div>
    <div class="image-container right">
        <img src="' . $imgh2 . '" alt="Image 2" style="height: 75%;">
    </div>
    <div class="header-text">
        <h3>CONTROL DE DISPONIBILIDAD</h3>
    </div>
</div>
</header>
<footer>
<div class="footer-content">
<p style="font-size: 9px; line-height: 15px; margin-bottom: 20px; text-align: justify;">
';
        foreach ($estados as $estado) {
            $htmlContent .= $estado->id . '.' . $estado->reporte . '&ensp;';
        }
        $htmlContent .= '
</p>
    <img src="' . $imgf1 . '" alt="Footer Image">
</div>

</footer>
    <main class="main-content">
    <p style="font-size: 9px; text-align:center;"><strong>Fecha: </strong>' . $fecha . '<strong> Hora: </strong>' . $hora . '</p>
        <h4>Ausentes</h4>
        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>NOMBRE</th>
                    <th>RENGLÓN</th>
                    <th>PUESTO</th>
                    <th>DIRECCIÓN</th>
                    <th>REGIÓN</th>
                    <th>DEPARTAMENTO</th>
                    <th>ESTADO</th>
                    <th>OBSERVACIONES</th>
                </tr>
            </thead>
            <tbody>';

        foreach ($ausentes as $indice => $emp) {
            $htmlContent .= '
                <tr>
                    <td>' . ($indice + 1) . '</td>
                    <td>' . $emp->nombre . '</td>
                    <td>' . $emp->renglon . '</td>
                    <td>' . $emp->puesto . '</td>
                    <td>' . $emp->direccion . '</td>
                    <td>' . $emp->region . '</td>
                    <td>' . $emp->departamento . '</td>
                    <td>' . $emp->id_reporte . '</td>
                    <td>' . $emp->observacion . '</td>
                </tr>';
        }

        if (count($ausentes) == 0) {
            $htmlContent .= '
                <tr>
                    <td colspan="9" style="text-align: center;">No hay datos disponibles</td>
                </tr>';
        }

        $htmlContent .= '
            </tbody>
        </table>
        <h4>Comisión</h4>
        <table>
            <thead>
                <tr>
                <th>No.</th>
                <th>NOMBRE</th>
                <th>RENGLÓN</th>
                <th>PUESTO</th>
                <th>DIRECCIÓN</th>
                <th>REGIÓN</th>
                <th>DEPARTAMENTO</th>
                <th>ESTADO</th>
                <th>OBSERVACIONES</th>
                </tr>
            </thead>
            <tbody>';

        foreach ($comisiones as $indice => $emp) {
            $htmlContent .= '
                <tr>
                <td>' . ($indice + 1) . '</td>
                <td>' . $emp->nombre . '</td>
                <td>' . $emp->renglon . '</td>
                <td>' . $emp->puesto . '</td>
                <td>' . $emp->direccion . '</td>
                <td>' . $emp->region . '</td>
                <td>' . $emp->departamento . '</td>
                <td>' . $emp->id_reporte . '</td>
                <td>' . $emp->observacion . '</td>
                </tr>';
        }

        if (count($comisiones) == 0) {
            $htmlContent .= '
                <tr>
                    <td colspan="9" style="text-align: center;">No hay datos disponibles</td>
                </tr>';
        }

        $htmlContent .= '
        </tbody>
    </table>
    <h4>Capacitaciones en el extranjero</h4>
    <table>
        <thead>
            <tr>
            <th>No.</th>
            <th>NOMBRE</th>
            <th>RENGLÓN</th>
            <th>PUESTO</th>
            <th>DIRECCIÓN</th>
            <th>REGIÓN</th>
            <th>DEPARTAMENTO</th>
            <th>ESTADO</th>
            <th>OBSERVACIONES</th>
            </tr>
        </thead>
        <tbody>';

        foreach ($capacitaciones as $indice => $emp) {
            $htmlContent .= '
            <tr>
            <td>' . ($indice + 1) . '</td>
            <td>' . $emp->nombre . '</td>
            <td>' . $emp->renglon . '</td>
            <td>' . $emp->puesto . '</td>
            <td>' . $emp->direccion . '</td>
            <td>' . $emp->region . '</td>
            <td>' . $emp->departamento . '</td>
            <td>' . $emp->id_reporte . '</td>
            <td>' . $emp->observacion . '</td>
            </tr>';
        }

        if (count($capacitaciones) == 0) {
            $htmlContent .= '
            <tr>
                <td colspan="9" style="text-align: center;">No hay datos disponibles</td>
            </tr>';
        }

        $htmlContent .= '
            </tbody>
        </table>
    </main>
</body>
</html>';

        // Configurar opciones de Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);

        // Cargar contenido HTML en Dompdf
        $dompdf->loadHtml($htmlContent);

        // Configurar tamaño y orientación del papel
        $dompdf->setPaper('Letter', 'landscape'); // Ajusta según tus necesidades

        // Renderizar el PDF
        $dompdf->render();

        // Agregar números de página
        $canvas = $dompdf->getCanvas();
        $font = $dompdf->getFontMetrics()->getFont('Trebuchet MS', 'normal');
        $size = 8;
        $canvas->page_text(
            ($canvas->get_width() * 0.5 - 10), // Posición horizontal
            $canvas->get_height() - 50,  // Posición vertical
            "{PAGE_NUM} de {PAGE_COUNT}", // Texto a agregar
            $font,
            $size,
            array(0, 0, 0, 0.6)
        );

        // Guardar el archivo PDF
        $pdfFilePath = 'templates/procesed/' . $fecha_hora . '_CONTROL_AUSENCIAS.pdf';
        file_put_contents($pdfFilePath, $dompdf->output());


        // Descargar el archivo
        return 'templates/procesed/' . $fecha_hora . '_CONTROL_AUSENCIAS.pdf';
    }

    public function consolidarPIR()
    {
        $fecha = Carbon::now()->translatedFormat('l, d \\de F \\de Y');
        $hora = date('H:i');
        $fecha_hora = date('Y_m_d H_i_s');

        $orden_direcciones = [1, 3, 2, 8, 22, 12, 6, 13, 9, 14, 17, 19, 20, 21, 7, 11, 16, 18, 15, 5, 4, 10];
        $orden_secciones = [1, 4, 2, 3, 8, 5, 9, 10, 11, 12, 13];

        $direcciones_personal = PirDireccion::select(
            'pir_direcciones.id as id_direccion',
            'pir_direcciones.direccion as direccion',
            'pir_secciones.seccion as seccion'
        )
            ->selectRaw('COUNT(pir_empleados.id) AS total_registros_personal')
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
            ->leftJoin('pir_secciones', 'pir_direcciones.pir_seccion_id', '=', 'pir_secciones.id')
            ->whereIn('pir_direcciones.id', $orden_direcciones)
            ->groupBy('pir_secciones.seccion', 'pir_direcciones.id', 'pir_direcciones.direccion')
            ->orderByRaw('FIELD(pir_secciones.id,' . implode(',', $orden_secciones) . ')')
            ->get();

        $resultado_direcciones = [];
        foreach ($direcciones_personal as $direccion) {
            $seccion = $direccion->seccion;
            if (!isset($resultado_direcciones[$seccion])) {
                $resultado_direcciones[$seccion] = [
                    'seccion' => $seccion,
                    'total_presente' => 0,
                    'total_comision' => 0,
                    'total_asignacion_especial' => 0,
                    'total_ausente' => 0,
                    'direcciones' => []
                ];
            }
            $resultado_direcciones[$seccion]['total_presente'] += $direccion->presente;
            $resultado_direcciones[$seccion]['total_comision'] += $direccion->comision;
            $resultado_direcciones[$seccion]['total_asignacion_especial'] += $direccion->asignacion_especial;
            $resultado_direcciones[$seccion]['total_ausente'] += $direccion->ausente;
            $resultado_direcciones[$seccion]['direcciones'][] = [
                'id_direccion' => $direccion->id_direccion,
                'direccion' => $direccion->direccion,
                'presente' => $direccion->presente,
                'comision' => $direccion->comision,
                'asignacion_especial' => $direccion->asignacion_especial,
                'ausente' => $direccion->ausente,
            ];
        }

        $staff_presente = 0;
        $staff_comision = 0;
        $staff_asignacion_especial = 0;
        $staff_ausente = 0;

        $direcciones_contratistas = PirDireccion::select(
            'pir_direcciones.id as id_direccion',
            'pir_direcciones.direccion as direccion',
            'pir_secciones.seccion as seccion'
        )
            ->selectRaw('COUNT(pir_empleados.id) AS total_registros_contratistas')
            ->selectRaw('COUNT(CASE WHEN pir_reportes.reporte = "Disponible" THEN 1 ELSE NULL END) AS disponible')
            ->selectRaw('COUNT(CASE WHEN pir_reportes.reporte = "Problemas de salud" THEN 1 ELSE NULL END) AS salud')
            ->selectRaw('COUNT(CASE WHEN pir_reportes.reporte = "Comisión" THEN 1 ELSE NULL END) AS comision')
            ->selectRaw('COUNT(CASE WHEN pir_reportes.reporte = "Capacitación en el extranjero" THEN 1 ELSE NULL END) AS asignacion_especial')
            ->selectRaw('COUNT(CASE WHEN pir_reportes.reporte = "No disponible" THEN 1 ELSE NULL END) AS no_disponible')
            ->leftJoin('pir_empleados', function ($join) {
                $join->on('pir_direcciones.id', '=', 'pir_empleados.pir_direccion_id')
                    ->leftJoin('pir_reportes', 'pir_empleados.pir_reporte_id', '=', 'pir_reportes.id')
                    ->leftJoin('pir_puestos', 'pir_empleados.id', '=', 'pir_puestos.pir_empleado_id')
                    ->leftJoin('catalogo_puestos', 'pir_puestos.catalogo_puesto_id', '=', 'catalogo_puestos.id')
                    ->leftJoin('renglones', 'catalogo_puestos.renglones_id', '=', 'renglones.id')
                    ->where('renglones.renglon', '029')
                    ->where('pir_empleados.activo', 1);
            })
            ->leftJoin('pir_secciones', 'pir_direcciones.pir_seccion_id', '=', 'pir_secciones.id')
            ->whereIn('pir_direcciones.id', $orden_direcciones)
            ->groupBy('pir_secciones.seccion', 'pir_direcciones.id', 'pir_direcciones.direccion')
            ->orderByRaw('FIELD(pir_secciones.id,' . implode(',', $orden_secciones) . ')')
            ->get();

        $staff_disponible = 0;
        $staff_salud = 0;
        $staff_asignacion = 0;
        $staff_comision_contratistas = 0;
        $staff_no_disponible = 0;

        $resultado_contratistas = [];
        foreach ($direcciones_contratistas as $direccion) {
            $seccion = $direccion->seccion;
            if (!isset($resultado_contratistas[$seccion])) {
                $resultado_contratistas[$seccion] = [
                    'seccion' => $seccion,
                    'total_disponible' => 0,
                    'total_comision' => 0,
                    'total_asignacion_especial' => 0,
                    'total_salud' => 0,
                    'total_no_disponible' => 0,
                    'direcciones' => []
                ];
            }
            $resultado_contratistas[$seccion]['total_disponible'] += $direccion->disponible;
            $resultado_contratistas[$seccion]['total_comision'] += $direccion->comision;
            $resultado_contratistas[$seccion]['total_salud'] += $direccion->salud;
            $resultado_contratistas[$seccion]['total_asignacion_especial'] += $direccion->asignacion_especial;
            $resultado_contratistas[$seccion]['total_no_disponible'] += $direccion->no_disponible;
            $resultado_contratistas[$seccion]['direcciones'][] = [
                'id_direccion' => $direccion->id_direccion,
                'direccion' => $direccion->direccion,
                'disponible' => $direccion->disponible,
                'salud' => $direccion->salud,
                'comision' => $direccion->comision,
                'asignacion_especial' => $direccion->asignacion_especial,
                'no_disponible' => $direccion->no_disponible,
            ];
        }

        $sarray_oficiales = ['Seguridad', 'Información', 'Enlace', 'Auditoría', 'Jurídico'];

        foreach ($resultado_direcciones as $res) {
            if (in_array($res['seccion'], $sarray_oficiales)) {
                $staff_presente += $res['total_presente'];
                $staff_comision += $res['total_comision'];
                $staff_asignacion_especial += $res['total_asignacion_especial'];
                $staff_ausente += $res['total_ausente'];
            }
        }

        foreach ($resultado_contratistas as $res) {
            if (in_array($res['seccion'], $sarray_oficiales)) {
                $staff_disponible += $res['total_disponible'];
                $staff_salud += $res['total_salud'];
                $staff_comision_contratistas += $res['total_comision'];
                $staff_asignacion += $res['total_asignacion_especial'];
                $staff_no_disponible += $res['total_no_disponible'];
            }
        }

        /* PLANTILLA */
        /* $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('templates/PIRConsolidado.xlsx');
        $formatoPersonal = $spreadsheet->setActiveSheetIndexByName('Personal');
        $formatoContratista = $spreadsheet->setActiveSheetIndexByName('Contratistas');

        $formatoPersonal->getCell('B11')->setValue('Fecha: ' . $fecha);
        $formatoPersonal->getCell('I11')->setValue($hora . ' horas');

        $formatoContratista->getCell('B11')->setValue('Fecha: ' . $fecha);
        $formatoContratista->getCell('I11')->setValue($hora . ' horas'); */

        /* Personal */

        /* $formatoPersonal->setCellValue('D16', $direcciones_personal[0]->presente);
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
        $formatoPersonal->setCellValue('G46', $direcciones_personal[21]->ausente); */

        /* Contratistas */

        /* $formatoContratista->setCellValue('D16', $direcciones_contratistas[0]->presente);
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

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx'); */

        if (!Storage::exists('templates/procesed/')) {
            Storage::makeDirectory('templates/procesed/');
        }

        $headerImagePath2 = public_path('/img/logoalt.svg');
        $type = pathinfo($headerImagePath2, PATHINFO_EXTENSION);
        $data = file_get_contents($headerImagePath2);
        $imgh2 = 'data:image/' . $type . ';base64,' . base64_encode($data);

        $footerImagePath1 = public_path('/img/footer.png');
        $type = pathinfo($footerImagePath1, PATHINFO_EXTENSION);
        $data = file_get_contents($footerImagePath1);
        $imgf1 = 'data:image/' . $type . ';base64,' . base64_encode($data);

        $htmlContent = '
    <html>
    <head>
    <style>
    body { font-family: "Trebuchet MS", sans-serif; }
table { width: 100%; border-collapse: collapse; font-size: 10px; }
th, td { border: 1px solid black; padding: 3px; text-align: center; }
th { font-size: 8px; }
@page { margin: 100px 50px 70px 50px; }
header { position: fixed; top: -80px; left: 0; right: 0; height: 60px; text-align: center; }
footer { position: fixed; bottom: -60px; left: 0; right: 0; height: 40px; text-align: center; line-height: 35px; }
.header-content { position: relative; width: 100%; height: 100px; }
.header-text { position: absolute; top: 30%; left: 50%; transform: translate(-50%, -50%); }
.image-container { position: absolute; top: 5px; }
.image-container.left { left: -135px; }
.image-container.right { right: -135px; }
.footer-content { width: 100%; text-align: center; }
.footer-content img { height: 100%; width: 100%; }
.main-content { margin-top: -30px; margin-bottom: 25px; }
    </style>
    </head>
    <body>
    <header>
        <div class="header-content">
            <div class="image-container left">
                <img src="' . $imgh2 . '" alt="Image 2" style="height: 75%;">
            </div>
            <div class="header-text">
                <h3>CONTROL DE ESTADO DE FUERZA POR SECCIÓN</h3>
            </div>
        </div>
    </header>
    <footer>
    <div class="footer-content">
        </p>
            <img src="' . $imgf1 . '" alt="Footer Image">
        </div>  
    </footer>
    <main class="main-content">
    <p style="font-size: 9px; text-align:center;"><strong>Fecha: </strong>' . $fecha . ' <strong> Hora: </strong>' . $hora . '</p>
        <h4>Personal</h4>
        <table>
            <thead>
                <tr>
                    <th style="width: 20%;">DEPENDENCIAS</th>
                    <th>TOTAL</th>
                    <th>Presentes</th>
                    <th>Comisión</th>
                    <th>Asignación Especial</th>
                    <th>Ausente</th>
                    <th style="width: 15%;">Nombre</th>
                    <th>Motivo Ausencia</th>
                    <th>Ubicación</th>
                </tr>
            </thead>
            <tbody>';

        foreach ($resultado_direcciones as $sec) {

            if ($sec['seccion'] == 'Comando') {
                $htmlContent .= '<tr style="background-color: #cfd1d1; ">
            <td style="text-align: justify; "><strong>' . $sec['seccion'] . '</strong></td>
            <td><strong>' . $sec['total_presente'] + $sec['total_comision'] + $sec['total_asignacion_especial'] + $sec['total_ausente'] . '</strong></td>
            <td><strong>' . $sec['total_presente'] . '</strong></td>
            <td><strong>' . $sec['total_comision'] . '</strong></td>
            <td><strong>' . $sec['total_asignacion_especial'] . '</strong></td>
            <td><strong>' . $sec['total_ausente'] . '</strong></td>
            <td colspan="3"></td>
            </tr>';
            } elseif (in_array($sec['seccion'], $sarray_oficiales)) {
                $htmlContent .= '<tr">
            <td colspan="9" style="text-align: left; "><strong>' . 'Oficial de ' . $sec['seccion']  . '</strong></td>
            </tr>';
            } else {
                $htmlContent .= '<tr style="background-color: #cfd1d1; ">
                <td style="text-align: justify; "><strong>' . (in_array($sec['seccion'], $sarray_oficiales) ? 'Oficial de ' . $sec['seccion'] : $sec['seccion']) . '</strong></td>
                <td><strong>' . $sec['total_presente'] + $sec['total_comision'] + $sec['total_asignacion_especial'] + $sec['total_ausente'] . '</strong></td>
                <td><strong>' . $sec['total_presente'] . '</strong></td>
                <td><strong>' . $sec['total_comision'] . '</strong></td>
                <td><strong>' . $sec['total_asignacion_especial'] . '</strong></td>
                <td><strong>' . $sec['total_ausente'] . '</strong></td>
                <td colspan="3"></td>
                </tr>';
            }

            $observacion = '';
            $personal = '';
            $ubicacion = '';
            $index = 1;
            foreach ($sec['direcciones'] as $dir) {
                if ($dir['comision'] > 0) {
                    $empleados = $this->getEmpleados($dir['id_direccion'], 6);
                    foreach ($empleados as $i => $emp) {
                        $personal .= ($i + $index) . '. ' . $emp->nombre . "<br>";
                        (!empty($emp->observacion)) ? $observacion .= ($i + $index) . '.' . $emp->observacion . "<br>" : $observacion .= ($i + $index) . '.' . $emp->reporte . "<br>";
                        $ubicacion .= ($i + $index) . '.' . $emp->departamento . "<br>";
                        $index = $i + $index;
                    }
                    $index++;
                }
                if ($dir['asignacion_especial'] > 0) {
                    $empleados = $this->getEmpleados($dir['id_direccion'], 8);
                    foreach ($empleados as $i => $emp) {
                        $personal .= ($i + $index) . '. ' . $emp->nombre . "<br>";
                        (!empty($emp->observacion)) ? $observacion .= ($i + $index) . '.' . $emp->observacion . "<br>" : $observacion .= ($i + $index) . '.' . $emp->reporte . "<br>";
                        $ubicacion .= ($i + $index) . '.' . $emp->departamento . "<br>";
                        $index = $i + $index;
                    }
                    $index++;
                }
                if ($dir['ausente'] > 0) {
                    $empleados = $this->getEmpleados($dir['id_direccion'], 2);
                    if (count($empleados) > 0) {
                        foreach ($empleados as $i => $emp) {
                            $personal .= ($i + $index) . '. ' . $emp->nombre . "<br>";
                            (!empty($emp->observacion)) ? $observacion .= ($i + $index) . '.' . $emp->observacion . "<br>" : $observacion .= ($i + $index) . '.' . $emp->reporte . "<br>";
                            $ubicacion .= ($i + $index) . '.' . $emp->departamento . "<br>";
                            $index = $i + $index;
                        }
                        $index++;
                    }

                    $empleados = $this->getEmpleados($dir['id_direccion'], 3);
                    if (count($empleados) > 0) {
                        foreach ($empleados as $i => $emp) {
                            $personal .= ($i + $index) . '. ' . $emp->nombre . "<br>";
                            (!empty($emp->observacion)) ? $observacion .= ($i + $index) . '.' . $emp->observacion . "<br>" : $observacion .= ($i + $index) . '.' . $emp->reporte . "<br>";
                            $ubicacion .= ($i + $index) . '.' . $emp->departamento . "<br>";
                            $index = $i + $index;
                        }
                        $index++;
                    }
                    $empleados = $this->getEmpleados($dir['id_direccion'], 4);
                    if (count($empleados) > 0) {
                        foreach ($empleados as $i => $emp) {
                            $personal .= ($i + $index) . '. ' . $emp->nombre . "<br>";
                            (!empty($emp->observacion)) ? $observacion .= ($i + $index) . '.' . $emp->observacion . "<br>" : $observacion .= ($i + $index) . '.' . $emp->reporte . "<br>";
                            $ubicacion .= ($i + $index) . '.' . $emp->departamento . "<br>";
                            $index = $i + $index;
                        }
                        $index++;
                    }
                    $empleados = $this->getEmpleados($dir['id_direccion'], 5);
                    if (count($empleados) > 0) {
                        foreach ($empleados as $i => $emp) {
                            $personal .= ($i + $index) . '. ' . $emp->nombre . "<br>";
                            (!empty($emp->observacion)) ? $observacion .= ($i + $index) . '.' . $emp->observacion . "<br>" : $observacion .= ($i + $index) . '.' . $emp->reporte . "<br>";
                            $ubicacion .= ($i + $index) . '.' . $emp->departamento . "<br>";
                            $index = $i + $index;
                        }
                        $index++;
                    }
                    $empleados = $this->getEmpleados($dir['id_direccion'], 7);
                    if (count($empleados) > 0) {
                        foreach ($empleados as $i => $emp) {
                            $personal .= ($i + $index) . '. ' . $emp->nombre . "<br>";
                            (!empty($emp->observacion)) ? $observacion .= ($i + $index) . '.' . $emp->observacion . "<br>" : $observacion .= ($i + $index) . '.' . $emp->reporte . "<br>";
                            $ubicacion .= ($i + $index) . '.' . $emp->departamento . "<br>";
                            $index = $i + $index;
                        }
                        $index++;
                    }
                    $empleados = $this->getEmpleados($dir['id_direccion'], 9);
                    if (count($empleados) > 0) {
                        foreach ($empleados as $i => $emp) {
                            $personal .= ($i + $index) . '. ' . $emp->nombre . "<br>";
                            (!empty($emp->observacion)) ? $observacion .= ($i + $index) . '.' . $emp->observacion . "<br>" : $observacion .= ($i + $index) . '.' . $emp->reporte . "<br>";
                            $ubicacion .= ($i + $index) . '.' . $emp->departamento . "<br>";
                            $index = $i + $index;
                        }
                        $index++;
                    }
                    $empleados = $this->getEmpleados($dir['id_direccion'], 10);
                    if (count($empleados) > 0) {
                        foreach ($empleados as $i => $emp) {
                            $personal .= ($i + $index) . '. ' . $emp->nombre . "<br>";
                            (!empty($emp->observacion)) ? $observacion .= ($i + $index) . '.' . $emp->observacion . "<br>" : $observacion .= ($i + $index) . '.' . $emp->reporte . "<br>";
                            $ubicacion .= ($i + $index) . '.' . $emp->departamento . "<br>";
                            $index = $i + $index;
                        }
                        $index++;
                    }
                }

                $htmlContent .= '
                    <tr>
                        <td style="text-align: justify;">' . $dir['direccion'] . '</td>
                        <td><strong>' . $dir['presente'] + $dir['comision'] + $dir['asignacion_especial'] + $dir['ausente'] . '</strong></td>
                        <td>' . $dir['presente'] . '</td>
                        <td>' . $dir['comision'] . '</td>
                        <td>' . $dir['asignacion_especial'] . '</td>
                        <td>' . $dir['ausente'] . '</td>
                        <td>' . $personal . '</td>
                        <td>' . $observacion . '</td>
                        <td>' . $ubicacion . '</td>
                    </tr>
                ';
            }

            if ($sec['seccion'] == 'Comando') {
                $htmlContent .= '<tr style="background-color: #cfd1d1; ">
            <td style="text-align: justify; "><strong>Staff</strong></td>
            <td><strong>' . $staff_presente + $staff_comision + $staff_asignacion_especial + $staff_ausente . '</strong></td>
            <td><strong>' . $staff_presente . '</strong></td>
            <td><strong>' . $staff_comision . '</strong></td>
            <td><strong>' . $staff_asignacion_especial . '</strong></td>
            <td><strong>' . $staff_ausente . '</strong></td>
            <td colspan="3"></td>
            </tr>';
            }
        }

        $htmlContent .= '
        <tfoot>
            <tr>
                <td><strong>Total personal reportado</strong></td>
                <td><strong>' . $direcciones_personal->sum('total_registros_personal') . '</strong></td>
                <td><strong>' . $direcciones_personal->sum('presente') . '</strong></td>
                <td><strong>' . $direcciones_personal->sum('comision') . '</strong></td>
                <td><strong>' . $direcciones_personal->sum('asignacion_especial') . '</strong></td>
                <td><strong>' . $direcciones_personal->sum('ausente') . '</strong></td>
                <td colspan="3"></td>
            </tr>
        </tfoot>
        </tbody>
        </table>
        <h4>Contratistas</h4>
        <table>
            <thead>
            <tr>
                    <th style="width: 20%;">DEPENDENCIAS</th>
                    <th>TOTAL</th>
                    <th>Disponibles</th>
                    <th>Problemas de salud</th>
                    <th>Comisión</th>
                    <th>Asignación Especial</th>
                    <th>No disponible</th>
                    <th style="width: 15%;">Nombre</th>
                    <th>Motivo Ausencia</th>
                    <th>Ubicación</th>
                </tr>
            </thead>
            <tbody>
        ';

        foreach ($resultado_contratistas as $sec) {

            if ($sec['seccion'] == 'Comando') {
                $htmlContent .= '<tr style="background-color: #cfd1d1; ">
            <td style="text-align: justify; "><strong>' . $sec['seccion'] . '</strong></td>
            <td><strong>' . $sec['total_disponible'] + $sec['total_comision'] + $sec['total_asignacion_especial'] + $sec['total_no_disponible'] + $sec['total_salud'] . '</strong></td>
            <td><strong>' . $sec['total_disponible'] . '</strong></td>
            <td><strong>' . $sec['total_salud'] . '</strong></td>
            <td><strong>' . $sec['total_comision'] . '</strong></td>
            <td><strong>' . $sec['total_asignacion_especial'] . '</strong></td>
            <td><strong>' . $sec['total_no_disponible'] . '</strong></td>
            <td colspan="3"></td>
            </tr>';
            } elseif (in_array($sec['seccion'], $sarray_oficiales)) {
                $htmlContent .= '<tr">
            <td colspan="10" style="text-align: left; "><strong>' . 'Oficial de ' . $sec['seccion']  . '</strong></td>
            </tr>';
            } else {
                $htmlContent .= '<tr style="background-color: #cfd1d1; ">
                <td style="text-align: justify; "><strong>' . (in_array($sec['seccion'], $sarray_oficiales) ? 'Oficial de ' . $sec['seccion'] : $sec['seccion']) . '</strong></td>
                <td><strong>' . $sec['total_disponible'] + $sec['total_comision'] + $sec['total_asignacion_especial'] + $sec['total_no_disponible'] + $sec['total_salud'] . '</strong></td>
                <td><strong>' . $sec['total_disponible'] . '</strong></td>
                <td><strong>' . $sec['total_salud'] . '</strong></td>
                <td><strong>' . $sec['total_comision'] . '</strong></td>
                <td><strong>' . $sec['total_asignacion_especial'] . '</strong></td>
                <td><strong>' . $sec['total_no_disponible'] . '</strong></td>
                <td colspan="3"></td>
                </tr>';
            }

            $observacion = '';
            $personal = '';
            $ubicacion = '';
            $index = 1;

            foreach ($sec['direcciones'] as $dir) {
                if ($dir['comision'] > 0) {
                    $empleados = $this->getEmpleados($dir['id_direccion'], 6);
                    foreach ($empleados as $i => $emp) {
                        $personal .= ($i + $index) . '. ' . $emp->nombre . "<br>";
                        $observacion .= ($i + $index) . '.' . $emp->observacion . "<br>";
                        $ubicacion .= ($i + $index) . '.' . $emp->departamento . "<br>";
                        $index = $i + $index;
                    }
                    $index++;
                }

                if ($dir['asignacion_especial'] > 0) {
                    $empleados = $this->getEmpleados($dir['id_direccion'], 8);
                    foreach ($empleados as $i => $emp) {
                        $personal .= ($i + $index) . '. ' . $emp->nombre . "<br>";
                        $observacion .= ($i + $index) . '.' . $emp->observacion . "<br>";
                        $ubicacion .= ($i + $index) . '.' . $emp->departamento . "<br>";
                        $index = $i + $index;
                    }
                    $index++;
                }

                if ($dir['salud'] > 0) {
                    $empleados = $this->getEmpleados($dir['id_direccion'], 12);
                    foreach ($empleados as $i => $emp) {
                        $personal .= ($i + $index) . '. ' . $emp->nombre . "<br>";
                        $observacion .= ($i + $index) . '.' . $emp->observacion . "<br>";
                        $ubicacion .= ($i + $index) . '.' . $emp->departamento . "<br>";
                        $index = $i + $index;
                    }
                    $index++;
                }

                if ($dir['no_disponible'] > 0) {
                    $empleados = $this->getEmpleados($dir['id_direccion'], 13);
                    foreach ($empleados as $i => $emp) {
                        $personal .= ($i + $index) . '. ' . $emp->nombre . "<br>";
                        $observacion .= ($i + $index) . '.' . $emp->observacion . "<br>";
                        $ubicacion .= ($i + $index) . '.' . $emp->departamento . "<br>";
                        $index = $i + $index;
                    }
                    $index++;
                }


                $htmlContent .= '
                    <tr>
                        <td style="text-align: justify;">' . $dir['direccion'] . '</td>
                        <td><strong>' . $dir['disponible'] + $dir['comision'] + $dir['asignacion_especial'] + $dir['no_disponible'] + $dir['salud'] . '</strong></td>
                        <td>' . $dir['disponible'] . '</td>
                        <td>' . $dir['salud'] . '</td>
                        <td>' . $dir['comision'] . '</td>
                        <td>' . $dir['asignacion_especial'] . '</td>
                        <td>' . $dir['no_disponible'] . '</td>
                        <td>' . $personal . '</td>
                        <td>' . $observacion . '</td>
                        <td>' . $ubicacion . '</td>
                    </tr>
                ';
            }

            if ($sec['seccion'] == 'Comando') {
                $htmlContent .= '<tr style="background-color: #cfd1d1; ">
            <td style="text-align: justify; "><strong>Staff</strong></td>
            <td><strong>' . $staff_disponible + $staff_comision_contratistas + $staff_asignacion_especial + $staff_no_disponible + $staff_salud . '</strong></td>
            <td><strong>' . $staff_disponible . '</strong></td>
            <td><strong>' . $staff_salud . '</strong></td>
            <td><strong>' . $staff_comision_contratistas . '</strong></td>
            <td><strong>' . $staff_asignacion . '</strong></td>
            <td><strong>' . $staff_no_disponible . '</strong></td>
            <td colspan="3"></td>
            </tr>';
            }
        }

        $htmlContent .= '
        </tbody>
        <tfoot>
            <tr>
                <td><strong>Total contratistas reportados</strong></td>
                <td><strong>' . $direcciones_contratistas->sum('total_registros_contratistas') . '</strong></td>
                <td><strong>' . $direcciones_contratistas->sum('disponible') . '</strong></td>
                <td><strong>' . $direcciones_contratistas->sum('problemas de salud') . '</strong></td>
                <td><strong>' . $direcciones_contratistas->sum('comision') . '</strong></td>
                <td><strong>' . $direcciones_contratistas->sum('asignacion_especial') . '</strong></td>
                <td><strong>' . $direcciones_contratistas->sum('no_disponible') . '</strong></td>
                <td colspan="3"></td>
            </tr>
        </tfoot>
        </table>
    </main>
</body>
</html>';

        // Configurar opciones de Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);

        // Cargar contenido HTML en Dompdf
        $dompdf->loadHtml($htmlContent);

        // Configurar tamaño y orientación del papel
        $dompdf->setPaper('Letter', 'landscape'); // Ajusta según tus necesidades

        // Renderizar el PDF
        $dompdf->render();

        // Agregar números de página
        $canvas = $dompdf->getCanvas();
        $font = $dompdf->getFontMetrics()->getFont('Trebuchet MS', 'normal');
        $size = 8;
        $canvas->page_text(
            ($canvas->get_width() * 0.5 - 10), // Posición horizontal
            $canvas->get_height() - 50,  // Posición vertical
            "{PAGE_NUM} de {PAGE_COUNT}", // Texto a agregar
            $font,
            $size,
            array(0, 0, 0, 0.6)
        );

        // Guardar el archivo PDF
        $pdfFilePath = 'templates/procesed/' . $fecha_hora . '_PIR_CONSOLIDADO.pdf';
        file_put_contents($pdfFilePath, $dompdf->output());

        /* $writer->save('templates/procesed/' . $fecha_hora . '_PIR_CONSOLIDADO.xlsx'); */

        // Descargar el archivo
        return 'templates/procesed/' . $fecha_hora . '_PIR_CONSOLIDADO.pdf';
    }

    private function getEmpleados($id_direccion, $id_reporte)
    {
        $empleados = PirEmpleado::select(
            'pir_empleados.nombre as nombre',
            'departamentos.nombre as departamento',
            'pir_empleados.observacion as observacion',
            'pir_reportes.reporte as reporte',
            'renglones.renglon as renglon'
        )
            ->leftJoin('pir_puestos', 'pir_empleados.id', '=', 'pir_puestos.pir_empleado_id')
            ->leftJoin('catalogo_puestos', 'pir_puestos.catalogo_puesto_id', '=', 'catalogo_puestos.id')
            ->leftJoin('renglones', 'catalogo_puestos.renglones_id', '=', 'renglones.id')
            ->leftJoin('departamentos', 'pir_empleados.departamento_id', '=', 'departamentos.id')
            ->join('pir_reportes', 'pir_empleados.pir_reporte_id', '=', 'pir_reportes.id')
            ->join('pir_direcciones', 'pir_empleados.pir_direccion_id', '=', 'pir_direcciones.id')
            ->where('pir_reportes.id', $id_reporte)
            ->where('pir_empleados.activo', 1)
            ->where('pir_direcciones.id', $id_direccion)
            ->get();

        return $empleados;
    }
}
