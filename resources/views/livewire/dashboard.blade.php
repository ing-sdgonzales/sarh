<div class="w-full">
    <x-dashboard>
        <livewire:chart-tile chartFactory="{{ App\Charts\PersonalRegion::class }}" position="a1:b6" height="75%" />
        <livewire:chart-tile chartFactory="{{ App\Charts\ContratistasRegion::class }}" position="c1:d6" height="75%" />
        <livewire:chart-tile chartFactory="{{ App\Charts\AusenciasDireccionRI::class }}" position="a7:d14"
            height="65%" />
        <livewire:chart-tile chartFactory="{{ App\Charts\AusenciasRegiones::class }}" position="a15:d20"
            height="35%" />
    </x-dashboard>
</div>
