<?php

namespace App\Livewire\Pir;

use App\Models\PirDireccion;
use App\Models\PirEmpleado;
use Livewire\Component;
use Illuminate\Support\Str;

class ConsultaDisponibilidad extends Component
{
    public $id_direccion, $direccion, $seccion;
    public function render()
    {
        $dir = PirDireccion::select(
            'pir_direcciones.direccion as direccion',
            'pir_secciones.seccion as seccion'
        )
            ->leftJoin('pir_secciones', 'pir_direcciones.pir_seccion_id', '=', 'pir_secciones.id')
            ->where('pir_direcciones.id', $this->id_direccion)
            ->first();

        $this->direccion = $dir->direccion;
        $this->seccion = $dir->seccion;

        $personal = PirEmpleado::select(
            'pir_empleados.nombre as nombre',
            'pir_empleados.observacion as observacion',
            'departamentos.nombre as departamento',
            'pir_reportes.reporte as reporte',
            'pir_grupos.grupo as grupo'
        )
            ->leftJoin('departamentos', 'pir_empleados.departamento_id', '=', 'departamentos.id')
            ->join('regiones', 'pir_empleados.region_id', '=', 'regiones.id')
            ->join('pir_reportes', 'pir_empleados.pir_reporte_id', '=', 'pir_reportes.id')
            ->join('pir_grupos', 'pir_empleados.pir_grupo_id', '=', 'pir_grupos.id')
            ->join('pir_puestos', 'pir_empleados.id', '=', 'pir_puestos.pir_empleado_id')
            ->join('catalogo_puestos', 'pir_puestos.catalogo_puesto_id', '=', 'catalogo_puestos.id')
            ->join('renglones', 'catalogo_puestos.renglones_id', '=', 'renglones.id')
            ->whereIn('renglones.renglon', ['011', '021', '022', '031'])
            ->orderBy('pir_empleados.nombre');

        $contratistas = PirEmpleado::select(
            'pir_empleados.nombre as nombre',
            'pir_empleados.observacion as observacion',
            'departamentos.nombre as departamento',
            'pir_reportes.reporte as reporte',
            'pir_grupos.grupo as grupo'
        )
            ->leftJoin('departamentos', 'pir_empleados.departamento_id', '=', 'departamentos.id')
            ->join('regiones', 'pir_empleados.region_id', '=', 'regiones.id')
            ->join('pir_reportes', 'pir_empleados.pir_reporte_id', '=', 'pir_reportes.id')
            ->join('pir_grupos', 'pir_empleados.pir_grupo_id', '=', 'pir_grupos.id')
            ->join('pir_puestos', 'pir_empleados.id', '=', 'pir_puestos.pir_empleado_id')
            ->join('catalogo_puestos', 'pir_puestos.catalogo_puesto_id', '=', 'catalogo_puestos.id')
            ->join('renglones', 'catalogo_puestos.renglones_id', '=', 'renglones.id')
            ->where('renglones.renglon', '029')
            ->orderBy('pir_empleados.nombre');

        if (Str::startsWith($this->direccion, 'Región')) {
            if ($this->direccion == 'Región I') {
                $personal->where('pir_empleados.is_regional_i', 1);
                $contratistas->where('pir_empleados.is_regional_i', 1);
            } else {
                $personal->where('regiones.region', $this->direccion);
                $contratistas->where('regiones.region', $this->direccion);
            }
        } else {
            $personal->where('pir_empleados.pir_direccion_id', $this->id_direccion)->where('regiones.region', 'Región I');
            $contratistas->where('pir_empleados.pir_direccion_id', $this->id_direccion)->where('regiones.region', 'Región I');
        }
        $personal = $personal->where('pir_empleados.activo', 1);
        $contratistas = $contratistas->where('pir_empleados.activo', 1);

        return view('livewire.pir.consulta-disponibilidad', [
            'personal' => $personal->paginate(10, pageName: 'personal'),
            'contratistas' => $contratistas->paginate(10, pageName: 'contratistas'),
        ]);
    }

    public function mount($id_direccion)
    {
        $this->id_direccion = $id_direccion;
    }
}
