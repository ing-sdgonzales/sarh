<?php

namespace App\Http\Controllers;

use App\Models\Candidato;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BuscarAplicacionController extends Controller
{
    public function index()
    {
        return view('buscar-aplicacion');
    }

    public function buscar(Request $request)
    {
        $email = $request->input('email');

        $candidato = Candidato::where('email', $email)->first();

        if (!$candidato) {
            $validator = Validator::make([], []);
            $validator->errors()->add('custom', 'El correo electrónico no coincide con nuestros registros.');

            return redirect()->route('buscar_aplicacion')
                ->withErrors($validator);
        } else {
            session()->put('email_search_success', true);
            return redirect()->route('presentar_requisitos',$candidato->id);
        }
    }
}
