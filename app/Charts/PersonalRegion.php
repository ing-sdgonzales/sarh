<?php

namespace App\Charts;

use App\Models\PirEmpleado;
use Fidum\ChartTile\Charts\Chart;
use Fidum\ChartTile\Contracts\ChartFactory;

class PersonalRegion implements ChartFactory
{
    public static function make(array $settings): ChartFactory
    {
        return new static;
    }

    public function chart(): Chart
    {
        $chart = new Chart();

        $titulo = 'Personal por región';
        $empleados = PirEmpleado::select(
            'regiones.region as region'
        )
            ->selectRaw('COUNT(*) as total')
            ->join('regiones', 'pir_empleados.region_id', '=', 'regiones.id')
            ->join('pir_puestos', 'pir_empleados.id', '=', 'pir_puestos.pir_empleado_id')
            ->join('catalogo_puestos', 'pir_puestos.catalogo_puesto_id', '=', 'catalogo_puestos.id')
            ->leftJoin('renglones', 'catalogo_puestos.renglones_id', '=', 'renglones.id')
            ->whereIn('renglones.renglon', ['011', '021', '022', '031'])
            ->groupBy('regiones.region')
            ->get();

        $labels = $empleados->pluck('region')->toArray();
        $data = $empleados->pluck('total')->toArray();

        $chart->labels($labels)
            ->options([
                'responsive' => true,
                'maintainAspectRatio' => true,
                'animation' => [
                    'duration' => 0,
                ],
                'legend' => [
                    'display' => true,
                    'position' => 'right',
                ],
                'scales' => [
                    'xAxes' => ['display' => false],
                    'yAxes' => ['display' => false],
                ],
                'title' => [
                    'display' => true,
                    'text' => $titulo,
                    'fontSize' => 18,
                ],
            ])
            ->dataset('Contratistas', 'pie', $data)
            ->backgroundColor(
                ['#0074D9', '#B28DFF', '#6EB5FF', '#BFFCC6', '#FF4136', '#FF851B', '#2ECC40', '#FFDC00']
            );

        return $chart;
    }
}
