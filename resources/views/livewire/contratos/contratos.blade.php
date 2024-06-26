<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Historial de contratos') }}
        </h2>
    </x-slot>

    <div class="py-12 h-full">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="mt-2 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6 mb-2">
                <div class="sm:col-span-6 mx-auto">
                    <img src="{{ asset('storage') . '/' . $empleado->imagen }}" class="mx-auto max-w-full rounded-lg"
                        style="height: 150px" alt="imagen" />
                    <x-label value="{{ __($empleado->nombres . ' ' . $empleado->apellidos) }}" />
                    <x-label value="{{ __($empleado->dpi) }}" />
                    {{-- <label
                        class="mt-1 block text-sm font-medium leading-6 text-gray-900 text-center">{{ $empleado->dpi }}</label> --}}
                </div>
                <div class="sm:col-span-2">
                    <div class="mt-2">
                        @can('Crear contratos')
                            <button type="button" wire:click='crear'
                                class="inline-block rounded-lg bg-primary px-6 pb-2 pt-2.5 text-md font-medium leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-primary-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-primary-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-primary-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                            </button>
                        @endcan

                        @can('Crear contratos')
                            @if ($modal)
                                @include('livewire.contratos.crear')
                            @endif
                        @endcan

                        @can('Editar contratos')
                            @if ($modal_editar)
                                @include('livewire.contratos.editar')
                            @endif
                        @endcan

                        @can('Crear puestos en contrato')
                            @if ($modal_crear_puestos)
                                @include('livewire.contratos.puestos-funcionales.crear')
                            @endif
                        @endcan

                        @canany(['Crear período de contrato'])
                            @if ($modal_periodo)
                                @include('livewire.contratos.crear-periodo')
                            @endif
                        @endcanany

                    </div>
                </div>
                <div class="sm:col-span-4">
                    <div class="mt-2 w-full text-right items-baseline">
                        @can('Ver historial de puestos')
                            <a type="button" href="{{ route('historial_puestos', ['id_empleado' => $id_empleado]) }}">
                                <div
                                    class="inline-block rounded-lg bg-success px-6 pb-2 pt-2.5 text-md font-medium leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-success-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-success-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-success-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]">
                                    {{ __('Puestos') }}
                                </div>
                            </a>
                        @endcan
                    </div>
                </div>
            </div>

            <div {{-- class="overflow-x-auto" --}}>
                <div class="bg-white dark:bg-gray-800 shadow-xl sm:rounded-md">
                    <table
                        class="min-w-full border-2 border-separate border-spacing-0 text-center shadow-lg rounded-md border-solid border-gray-300 dark:border-gray-800">
                        <thead class="bg-gray-300 dark:bg-gray-800 text-center">
                            <tr class="text-gray-800 dark:text-gray-300">
                                <th class="w-1/12 py-2 px-4">No.</th>
                                <th class="w-1/12 py-2 px-4">Contrato</th>
                                <th class="w-1/6 py-2 px-4">Puesto Nominal</th>
                                <th class="w-1/6 py-2 px-4">Dependencia Nominal</th>
                                <th class="w-1/12 py-2 px-4">Salario</th>
                                <th class="w-1/6 py-2 px-4">Plazo</th>
                                <th class="w-1/12 py-2 px-4">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-600">
                            @foreach ($contratos as $contrato)
                                <tr
                                    class="text-gray-800 dark:text-gray-200 border-b border-gray-300 dark:border-gray-700">
                                    <td
                                        class="py-2 px-4 {{ $loop->last ? 'border-none' : 'border-b border-gray-200 dark:border-gray-700' }}">
                                        {{ $loop->iteration }}.</td>
                                    <td
                                        class="py-2 px-4 {{ $loop->last ? 'border-none' : 'border-b border-gray-200 dark:border-gray-700' }}">
                                        {{ $contrato->numero }}</td>
                                    <td
                                        class="py-2 px-4 {{ $loop->last ? 'border-none' : 'border-b border-gray-200 dark:border-gray-700' }}">
                                        {{ $contrato->codigo }} - {{ $contrato->puesto }}</td>
                                    <td
                                        class="py-2 px-4 {{ $loop->last ? 'border-none' : 'border-b border-gray-200 dark:border-gray-700' }}">
                                        {{ $contrato->dependencia }}</td>
                                    <td
                                        class="py-2 px-4 {{ $loop->last ? 'border-none' : 'border-b border-gray-200 dark:border-gray-700' }}">
                                        Q {{ number_format($contrato->salario, 2, '.', ',') }}</td>
                                    <td
                                        class="py-2 px-4 {{ $loop->last ? 'border-none' : 'border-b border-gray-200 dark:border-gray-700' }}">
                                        {{ date('d/m/Y', strtotime($contrato->fecha_inicio)) }} -
                                        {{ date('d/m/Y', strtotime($contrato->fecha_fin)) }}</td>
                                    <td class="py-2 px-1">
                                        <div class="relative" data-te-dropdown-position="dropstart">
                                            <button
                                                class="flex items-center mx-auto whitespace-nowrap rounded bg-gray-400 px-2 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-gray-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-gray-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-gray-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] motion-reduce:transition-none dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]"
                                                type="button" id="dropdownMenuButton{{ $contrato->id }}"
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
                                            <ul class="absolute z-[1000] left-0 top-full m-0 hidden h-auto list-none rounded-lg border-none bg-gray-200 bg-clip-padding text-center text-base shadow-lg dark:bg-neutral-700 [&[data-te-dropdown-show]]:block overflow-y-auto"
                                                aria-labelledby="dropdownMenuButton{{ $contrato->id }}"
                                                data-te-dropdown-menu-ref>
                                                @can('Editar contratos')
                                                    <li>
                                                        <button type="button"
                                                            wire:click='editar({{ $contrato->id }}, {{ $contrato->id_periodo }})'
                                                            class="block w-full whitespace-nowrap bg-transparent px-4 py-2 text-sm font-normal text-neutral-700 hover:bg-neutral-100 active:text-neutral-800 active:no-underline disabled:pointer-events-none disabled:bg-transparent disabled:text-neutral-400 dark:text-neutral-200 dark:hover:bg-neutral-600"
                                                            data-te-dropdown-item-ref>
                                                            <div class="flex items-end space-x-2">
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                    viewBox="0 0 24 24" stroke-width="1.5"
                                                                    stroke="currentColor" class="w-5 h-5">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                                </svg>
                                                                <h6
                                                                    class="text-sm font-normal text-neutral-700 dark:text-gray-200">
                                                                    Editar</h6>
                                                            </div>
                                                        </button>
                                                    </li>
                                                @endcan
                                                @can('Crear puestos en contrato')
                                                    <li>
                                                        <button type="button"
                                                            wire:click='crearPuestoContrato({{ $contrato->id }})'
                                                            class="block w-full whitespace-nowrap bg-transparent px-4 py-2 text-sm font-normal text-neutral-700 hover:bg-neutral-100 active:text-neutral-800 active:no-underline disabled:pointer-events-none disabled:bg-transparent disabled:text-neutral-400 dark:text-neutral-200 dark:hover:bg-neutral-600"
                                                            data-te-dropdown-item-ref>
                                                            <div class="flex items-end space-x-2">
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                    viewBox="0 0 24 24" stroke-width="1.5"
                                                                    stroke="currentColor" class="w-5 h-5">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        d="M10.5 6a7.5 7.5 0 107.5 7.5h-7.5V6z" />
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        d="M13.5 10.5H21A7.5 7.5 0 0013.5 3v7.5z" />
                                                                </svg>

                                                                <h6
                                                                    class="text-sm font-normal text-neutral-700 dark:text-gray-200">
                                                                    Agregar
                                                                    puesto</h6>
                                                            </div>
                                                        </button>
                                                    </li>
                                                @endcan

                                                @if ($contrato_renglon != '029')
                                                    @can('Crear nuevo período de contrato')
                                                        <li>
                                                            <button type="button"
                                                                wire:click='crearPeriodo({{ $contrato->id }})'
                                                                class="block w-full whitespace-nowrap bg-transparent px-4 py-2 text-sm font-normal text-neutral-700 hover:bg-neutral-100 active:text-neutral-800 active:no-underline disabled:pointer-events-none disabled:bg-transparent disabled:text-neutral-400 dark:text-neutral-200 dark:hover:bg-neutral-600"
                                                                data-te-dropdown-item-ref>
                                                                <div class="flex items-end space-x-2">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                        viewBox="0 0 24 24" stroke-width="1.5"
                                                                        stroke="currentColor" class="w-5 h-5">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round"
                                                                            d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                                                                    </svg>

                                                                    <h6
                                                                        class="text-sm font-normal text-neutral-700 dark:text-gray-200">
                                                                        Agregar
                                                                        período</h6>
                                                                </div>
                                                            </button>
                                                        </li>
                                                    @endcan
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
                    {{ $contratos->links() }}
                </div>
                <div wire:loading.flex wire:target="guardarContrato"
                    class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50">
                    <div
                        class="animate-spin rounded-full h-32 w-32 border-t-4 border-b-4 border-[#FF921F] bg-transparent">
                    </div>
                </div>
                <div wire:loading.flex wire:target="editarContrato"
                    class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50">
                    <div
                        class="animate-spin rounded-full h-32 w-32 border-t-4 border-b-4 border-[#FF921F] bg-transparent">
                    </div>
                </div>
                <div wire:loading.flex wire:target="guardarPeriodo"
                    class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50">
                    <div
                        class="animate-spin rounded-full h-32 w-32 border-t-4 border-b-4 border-[#FF921F] bg-transparent">
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('js')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Livewire.on('showSweetAlert', data => {
                    Swal.fire({
                        title: '¡Ups!',
                        text: data[0].message,
                        icon: 'warning',
                        confirmButtonText: 'Aceptar',
                        confirmButtonColor: '#1F2937'
                    });
                });

                Livewire.on('showPeriodosAlert', data => {
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
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Livewire.on('fechasOcupadasAlert', data => {
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
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Livewire.on('errorUltimoPuesto', data => {
                    Swal.fire({
                        title: '¡Ups!',
                        text: data[0].message,
                        icon: 'error',
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
