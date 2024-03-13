<?php

namespace App\Http\Middleware;

use App\Models\Empleado;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class VerificarEstadoEmpleado
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $id_empleado = $request->id_empleado;

        $empleado = Empleado::select(
            'relaciones_laborales.relacion_laboral as relacion_laboral',
            DB::raw('(SELECT COUNT(*) FROM contratos 
            WHERE empleados_id = empleados.id) as total_contratos'),
        )
            ->join('relaciones_laborales', 'empleados.relaciones_laborales_id', '=', 'relaciones_laborales.id')
            ->where('empleados.id', $id_empleado)
            ->first();
        if (
            $empleado->relacion_laboral == 'Exempleado'
            || (($empleado->relacion_laboral == 'Nuevo empleado' || $empleado->relacion_laboral == 'Empleado actual') && $empleado->total_contratos > 0)
        ) {
            return $next($request);
        } else {
            return redirect()->route('empleados');
        }
    }
}
