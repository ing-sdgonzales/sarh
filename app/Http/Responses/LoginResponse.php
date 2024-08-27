<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        /* return $request->wantsJson()
            ? new JsonResponse(['two_factor' => false], 200)
            : redirect()->intended(
                auth()->user()->hasRole('Empleado') ? route('dashboard-empleados') : (
                    auth()->user()->hasRole('Súper Administrador') ? route('dashboard') : (
                        auth()->user()->hasRole('Administrador') ? route('dashboard') : (
                            auth()->user()->hasRole('Operativo') ? route('dashboard') : (
                                route('formulario_pir')
                            )
                        )
                    )
                )
            ); */
        if ($request->wantsJson()) {
            return new JsonResponse(['two_factor' => false], 200);
        } else {
            if (auth()->user()->hasRole('Empleado')) {
                return redirect()->route('dashboard-empleados');
            } elseif (auth()->user()->hasAnyRole(['Súper Administrador', 'Administrador', 'Operativo'])) {
                return redirect()->route('dashboard');
            } elseif (auth()->user()->hasRole('Consultas')) {
                return redirect()->route('consultas_pir');
            } else {
                return redirect()->route('formulario_pir');
            }
        }
    }
}
