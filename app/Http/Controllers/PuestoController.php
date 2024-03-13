<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class PuestoController extends Controller
{
    public function show (): View {
        return view('puestos.index');
    }
}
