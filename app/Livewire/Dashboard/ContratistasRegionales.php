<?php

namespace App\Livewire\Dashboard;

use Spatie\Dashboard\Models\Tile;

use Livewire\Component;

class ContratistasRegionales extends Component
{
    public $position;

    public function mount(string $position)
    {
        $this->position = $position;
    }

    public function render()
    {
        
        return view('livewire.dashboard.contratistas-regionales');
    }
}
