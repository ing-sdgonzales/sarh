<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Settings;
use PhpOffice\PhpWord\TemplateProcessor;
use Illuminate\Support\Str;


class FormularioController extends Controller
{

    public function generarDoc($id_empleado)
    {
        $empleado = Empleado::select(
            'empleados.id as id',
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
            'empleados.municipios_id as id_municipio',
            'municipios.nombre as municipio',
            'departamentos.id as id_departamento',
            'departamentos.nombre as departamento',
            'nacionalidades.id as id_nacionalidad',
            'nacionalidades.nacionalidad as nacionalidad'
        )
            ->selectRaw('TIMESTAMPDIFF(YEAR, empleados.fecha_nacimiento, CURDATE()) as edad')
            ->join('municipios', 'empleados.municipios_id', '=', 'municipios.id')
            ->join('departamentos', 'municipios.departamentos_id', '=', 'departamentos.id')
            ->join('nacionalidades', 'empleados.nacionalidades_id', '=', 'nacionalidades.id')
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
        $doc->setValue('igss', $empleado->igss);
        $doc->setValue('email', $empleado->email);

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
