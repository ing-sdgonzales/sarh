<?php

namespace App\Http\Controllers\Puestos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EditarController extends Controller
{
    public function show($id): View{
        return view('puestos.editar', compact('id'));
    }
}
