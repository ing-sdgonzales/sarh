<div class="w-full">
    <x-dashboard>
        <livewire:chart-tile chartFactory="{{ App\Charts\PersonalRegion::class }}" position="a1:b1" height="115%" />
        <livewire:chart-tile chartFactory="{{ App\Charts\ContratistasRegion::class }}" position="c1:d1" height="115%" />
        <livewire:chart-tile chartFactory="{{ App\Charts\AusenciasDireccionRI::class }}" position="a2:d2" height="75%" />
    </x-dashboard>
</div>
