<?php

namespace App\Http\Middleware;

use App\Models\RequisitoCandidato;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerificarEstadoFormulario
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $formulario = RequisitoCandidato::where('requisitos_id', $request->id_requisito)
            ->where('candidatos_id', $request->id_candidato)
            ->first();
        if ($formulario) {
            if ($formulario->fecha_carga && $formulario->fecha_revision == null && $formulario->revisado == 0) {
                return redirect()->route('presentar_requisitos', ['id_candidato' => $formulario->candidatos_id]);
            }
        }
        return $next($request);
    }
}
