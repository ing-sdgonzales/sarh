<?php

namespace App\Charts;

use App\Models\PirDireccion;
use App\Models\PirEmpleado;
use Fidum\ChartTile\Charts\Chart;
use Fidum\ChartTile\Contracts\ChartFactory;

class AusenciasDireccionRI implements ChartFactory
{
    public static function make(array $settings): ChartFactory
    {
        return new static;
    }

    public function chart(): Chart
    {
        $chart = new Chart();

        $orden_direcciones = [1, 13, 9, 8, 12, 15, 14, 11, 2, 6, 4, 5, 7, 10, 22, 3, 16, 18, 17, 20, 19, 21];
        $titulo = 'Ausencias por Dirección - Región I';
        $direcciones = PirDireccion::select(
            'pir_direcciones.direccion as direccion'
        )
            ->selectRaw('COUNT(CASE WHEN pir_reportes.reporte NOT IN ("Presente en sedes", "Comisión", "Capacitación en el extranjero") THEN 1 ELSE NULL END) AS total')
            ->join('pir_empleados', 'pir_direcciones.id', '=', 'pir_empleados.pir_direccion_id')
            ->leftJoin('regiones', 'pir_empleados.region_id', '=', 'regiones.id')
            ->leftJoin('pir_reportes', 'pir_empleados.pir_reporte_id', '=', 'pir_reportes.id')
            ->where('regiones.region', 'Región I')
            ->where('pir_empleados.is_regional_i', 0)
            ->where('pir_empleados.activo', 1)
            ->whereIn('pir_direcciones.id', $orden_direcciones)
            ->orderByRaw('FIELD(pir_direcciones.id,' . implode(',', $orden_direcciones) . ')')
            ->groupBy('pir_direcciones.direccion')
            ->get();

        $labels = $direcciones->pluck('direccion')->toArray();
        $data = $direcciones->pluck('total')->toArray();

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
                    'xAxes' => ['display' => false],
                    'yAxes' => ['display' => false],
                ],
                'title' => [
                    'display' => true,
                    'text' => $titulo,
                ],
            ])
            ->dataset('Contratistas', 'bar', $data)
            ->backgroundColor('#0074D9');

        return $chart;
    }
}
