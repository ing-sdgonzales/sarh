<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Gestión de vacaciones') }}
        </h2>
    </x-slot>
    <div class="py-12 bg-gray-200 h-auto">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-xl sm:rounded-lg">
                <div>
                    <table class="min-w-full bg-white rounded-lg text-center">
                        <thead class="bg-gray-100 text-center">
                            <tr>
                                <th class="w-1/4 py-2 px-4">Año</th>
                                <th class="w-1/4 py-2 px-4">Días disponibles</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($vacaciones as $vacacion)
                                <tr>
                                    <td class="py-2 px-4">{{ $vacacion->year }}</td>
                                    <td class="py-2 px-4">{{ $vacacion->dias_disponibles }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="mt-2">
                {{ $vacaciones->links() }}
            </div>
            <div class="mt-12 grid grid-cols-8 gap-x-6 gap-y-8 mb-2">
                <div class="col-end-1">
                    <button type="button" wire:click="crear"
                        class="inline-block rounded-lg bg-primary px-6 pb-2 pt-2.5 text-md font-medium leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-primary-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-primary-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-primary-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                    </button>

                    @if ($modal)
                        @include('livewire.vacaciones.crear-solicitud')
                    @endif
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 shadow-xl sm:rounded-lg">
                <div>
                    <table class="min-w-full bg-white rounded-lg text-center">
                        <thead class="bg-gray-100 text-center">
                            <tr>
                                <th class="w-1/6 py-2 px-4">Fecha de solicitud</th>
                                <th class="w-1/6 py-2 px-4">Período</th>
                                <th class="w-1/12 py-2 px-4">Fecha de ingreso</th>
                                <th class="w-1/12 py-2 px-4">Duración</th>
                                <th class="w-1/12 py-2 px-4">Estado</th>
                                <th class="w-1/12 py-2 px-4">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($solicitudes->sortBy('created_at') as $solicitud)
                                <tr>
                                    <td class="py-2 px-4">
                                        {{ date('H:i:s d/m/Y', strtotime($solicitud->fecha_solicitud)) }}
                                    </td>
                                    <td class="py-2 px-4">
                                        {{ date('d/m/Y', strtotime($solicitud->fecha_salida)) .
                                            ' - ' .
                                            date('d/m/Y', strtotime($solicitud->fecha_ingreso . '-1 day')) }}
                                    </td>
                                    <td class="py-2 px-4">{{ date('d/m/Y', strtotime($solicitud->fecha_ingreso)) }}</td>
                                    <td class="py-2 px-4">{{ $solicitud->duracion . ' día(s)' }}</td>
                                    <td class="py-2 px-4">
                                        @if ($solicitud->aprobada == 1)
                                            <span
                                                class="inline-block whitespace-nowrap rounded-[0.27rem] bg-yellow-400 px-[0.65em] pb-[0.25em] pt-[0.35em] text-center text-md align-baseline text-[0.75em] font-bold leading-none text-yellow-800">Pendiente</span>
                                        @elseif($solicitud->aprobada == 2)
                                            <span
                                                class="inline-block whitespace-nowrap rounded-[0.27rem] bg-success-400 px-[0.65em] pb-[0.25em] pt-[0.35em] text-center text-md align-baseline text-[0.75em] font-bold leading-none text-succes-800">Aprobada</span>
                                        @else
                                            <span
                                                class="inline-block whitespace-nowrap rounded-[0.27rem] bg-gray-400 px-[0.65em] pb-[0.25em] pt-[0.35em] text-center text-md align-baseline text-[0.75em] font-bold leading-none text-gray-800">No
                                                aprobada</span>
                                        @endif
                                    </td>
                                    <td class="py-2 px-4">
                                        <div class="relative" data-te-dropdown-position="dropstart">
                                            <button
                                                class="flex items-center mx-auto whitespace-nowrap rounded bg-gray-400 px-2 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-gray-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-gray-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-gray-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] motion-reduce:transition-none dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]"
                                                type="button" id="dropdownMenuButton{{ $solicitud->id }}"
                                                data-te-dropdown-toggle-ref aria-expanded="false" data-te-ripple-init
                                                data-te-ripple-color="light">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                            </button>
                                            <ul class="absolute z-[1000] left-0 top-full m-0 hidden list-none rounded-lg border-none bg-gray-200 bg-clip-padding text-center text-base shadow-lg dark:bg-neutral-700 [&[data-te-dropdown-show]]:block overflow-y-auto"
                                                aria-labelledby="dropdownMenuButton{{ $solicitud->id }}"
                                                data-te-dropdown-menu-ref>
                                                @if ($solicitud->aprobada == 1 && $solicitud->fecha_salida == $utlima_solicitud->fecha_salida)
                                                    <li>
                                                        <button type="button"
                                                            wire:click='eliminar({{ $solicitud->id }})'
                                                            class="block w-full whitespace-nowrap bg-transparent px-4 py-2 text-sm font-normal text-neutral-700 hover:bg-neutral-100 active:text-neutral-800 active:no-underline disabled:pointer-events-none disabled:bg-transparent disabled:text-neutral-400 dark:text-neutral-200 dark:hover:bg-neutral-600"
                                                            data-te-dropdown-item-ref>
                                                            <div class="flex items-end space-x-2">
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                    viewBox="0 0 24 24" stroke-width="1.5"
                                                                    stroke="currentColor" class="w-5 h-5">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                                </svg>

                                                                <h6 class="text-sm font-normal text-neutral-700">
                                                                    Eliminar
                                                                </h6>
                                                            </div>
                                                        </button>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-2">
                    {{ $solicitudes->links() }}
                </div>
                <div wire:loading.flex wire:target="guardar"
                    class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50">
                    <div
                        class="animate-spin rounded-full h-32 w-32 border-t-4 border-b-4 border-indigo-50 bg-transparent">
                    </div>
                </div>
            </div>

        </div>
    </div>
    @push('js')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Livewire.on('diasInsuficientesAlert', data => {
                    Swal.fire({
                        title: '¡Ups!',
                        text: data[0].message,
                        icon: 'warning',
                        confirmButtonText: 'Aceptar',
                        confirmButtonColor: '#1F2937'
                    });
                });

                Livewire.on('showSolicitudesAlert', data => {
                    Swal.fire({
                        title: '¡Ups!',
                        text: data[0].message,
                        icon: 'warning',
                        confirmButtonText: 'Aceptar',
                        confirmButtonColor: '#1F2937'
                    });
                });
            });
        </script>
        @if (session()->has('message'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: '¡Operación completada con éxito!',
                    showConfirmButton: false,
                    timer: 2000
                })
            </script>
        @endif
        {{-- Error en crear nuevo registro --}}
        @if (session()->has('error'))
            <script>
                Swal.fire({
                    icon: 'error',
                    title: '¡Ups!',
                    html: `<?php echo session('error'); ?>`
                })
            </script>
        @endif

        {{-- Validación de campos --}}
        @if ($errors->any())
            <script>
                Swal.fire({
                    icon: 'error',
                    title: '¡Ups!',
                    html: `<small class="text-danger"><?php echo implode('<br>', $errors->all()); ?></small>`
                })
            </script>
        @endif
    @endpush
</div>