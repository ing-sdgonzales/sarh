<?php

namespace App\Http\Middleware;

use App\Models\PuestoNominal;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPuestoIsAvailable
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $id_puesto = $request->id_puesto;

        $puesto = PuestoNominal::findOrFail($id_puesto);

        if ($puesto->activo == 1) {
            return $next($request);
        } else {
            return redirect()->route('postularse');
        }
    }
}
