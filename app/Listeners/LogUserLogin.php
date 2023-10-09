<?php

namespace App\Listeners;

use App\Models\User;
use Illuminate\Auth\Events\Login;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogUserLogin
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Login $event)
    {
        $user = auth()->user();
        activity()
            ->causedBy($user) // Pasa la instancia del usuario como causante
            ->log('El usuario ' . $user->name . ' inició sesión.');
    }
}
