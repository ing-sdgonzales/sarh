<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    public function show(): View
    {
        return view('admin.usuarios.index');
    }
}
