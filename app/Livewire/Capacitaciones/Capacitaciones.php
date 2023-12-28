<?php

namespace App\Livewire\Capacitaciones;

use Livewire\Component;

class Capacitaciones extends Component
{
    public function render()
    {
        activity()
            ->causedBy(auth()->user())
            ->withProperties(['user_id' => auth()->id()])
            ->log("El usuario " . auth()->user()->name .  " visitó la página: " . request()->path());
        return view('livewire.capacitaciones.capacitaciones');
    }
}
