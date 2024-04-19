<div class="w-full">
    <x-dashboard>
        <livewire:chart-tile chartFactory="{{ App\Charts\PersonalRegion::class }}" position="a1:b2" />
        <livewire:chart-tile chartFactory="{{ App\Charts\ContratistasRegion::class }}" position="c1:d2" />
        <livewire:chart-tile chartFactory="{{ App\Charts\AusenciasDireccionRI::class }}" position="a3:d5" height="85%" />
    </x-dashboard>
</div>
