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
            } elseif (auth()->user()->hasRole('Súper Administrador')) {
                return redirect()->route('dashboard');
            } elseif (auth()->user()->hasRole('Administrador')) {
                return redirect()->route('dashboard');
            } elseif (auth()->user()->hasRole('Operativo')) {
                return redirect()->route('dashboard');
            } else {
                return redirect()->route('formulario_pir');
            }
        }
    }
}
