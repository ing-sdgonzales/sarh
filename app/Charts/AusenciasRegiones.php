<?php

namespace App\Charts;

use App\Models\PirEmpleado;
use Fidum\ChartTile\Charts\Chart;
use Fidum\ChartTile\Contracts\ChartFactory;

class AusenciasRegiones implements ChartFactory
{
    public static function make(array $settings): ChartFactory
    {
        return new static;
    }

    public function chart(): Chart
    {
        $chart = new Chart();

        $titulo = 'Ausencias por Región';
        $ausencias_regiones = PirEmpleado::select(
            'regiones.region as region'
        )
            ->selectRaw('COUNT(CASE WHEN pir_reportes.reporte NOT IN ("Presente en sedes", "Comisión", "Capacitación en el extranjero") THEN 1 ELSE NULL END) AS total')
            ->leftJoin('regiones', 'pir_empleados.region_id', '=', 'regiones.id')
            ->leftJoin('pir_reportes', 'pir_empleados.pir_reporte_id', '=', 'pir_reportes.id')
            ->where('pir_empleados.activo', 1)
            ->groupBy('regiones.region')
            ->get();

        $labels = $ausencias_regiones->pluck('region')->toArray();
        $data = $ausencias_regiones->pluck('total')->toArray();

        $chart->labels($labels)
            ->options([
                'responsive' => true,
                'maintainAspectRatio' => true,
                'animation' => [
                    'duration' => 0,
                ],
                'legend' => [
                    'display' => false,
                    'position' => 'top',
                ],
                'scales' => [
                    'xAxes' => [
                        'barPercentage' => 0,
                        'display' => false,
                    ],
                    'yAxes' => [
                        [
                            'type' => 'linear',
                            'ticks' => [
                                'fontSize' => 12,
                                'stepSize' => 1,
                            ],
                        ],
                    ],
                ],
                'title' => [
                    'display' => true,
                    'text' => $titulo,
                    'fontSize' => 18,
                ],
            ])
            ->dataset('Ausentes', 'bar', $data)
            ->backgroundColor('#0074D9');

        return $chart;
    }
}
