<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Empleados') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-200 h-screen">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-2">
                @can('Crear empleados')
                    <button type="button" wire:click="crear()"
                        class="inline-block rounded-lg bg-primary px-6 pb-2 pt-2.5 text-md font-medium leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-primary-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-primary-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-primary-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                    </button>
                @endcan

                @canany(['Crear empleados', 'Editar empleados'])
                    @if ($modal)
                        @include('livewire.empleados.crear')
                    @endif
                @endcanany
            </div>
            <div class="bg-white dark:bg-gray-800 shadow-xl sm:rounded-lg">
                <table class="min-w-full bg-white rounded-lg text-center">
                    <thead class="bg-gray-100 rounded-lg text-center">
                        <tr>
                            <th class="w-1/12 py-2 px-4">Renglón</th>
                            <th class="w-1/12 py-2 px-4">Foto</th>
                            <th class="w-1/6 py-2 px-4">Nombre</th>
                            <th class="w-1/6 py-2 px-4">Dependencia</th>
                            <th class="w-1/6 py-2 px-4">Servicio</th>
                            <th class="w-1/4 py-2 px-4">Profesión</th>
                            <th class="w-1/4 py-2 px-4">Región</th>
                            <th class="w-1/12 py-2 px-4">Estado</th>
                            <th class="w-1/4 py-2 px-4">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
