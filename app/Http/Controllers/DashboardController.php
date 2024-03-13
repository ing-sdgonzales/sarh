<?php

namespace App\Http\Controllers;

use App\Charts\SampleChart;
use App\Models\CatalogoPuesto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    public $puestos_renglon = [];
    public function index()
    {
        $data = CatalogoPuesto::join('renglones', 'catalogo_puestos.renglones_id', '=', 'renglones.id')
            ->select('renglones.renglon as renglon', DB::raw('SUM(catalogo_puestos.cantidad) as cantidad_puestos'))
            ->groupBy('renglon')
            ->get()
            ->pluck('cantidad_puestos', 'renglon')
            ->toArray();

        $this->puestos_renglon = $data;
        return view('dashboard')->with('puestos_renglon', $this->puestos_renglon);
    }
}
