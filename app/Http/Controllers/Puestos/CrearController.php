<?php

namespace App\Http\Controllers\Puestos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CrearController extends Controller
{
    public function show (): View {
        return view('puestos.crear');
    }
}
