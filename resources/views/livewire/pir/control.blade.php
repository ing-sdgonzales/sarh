<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Horarios de entrega de reportes') }}
        </h2>
    </x-slot>

    <div class="py-12 h-full">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-10">
            <div class="mt-2 grid grid-cols-8 gap-x-6 gap-y-8 mb-2">
                <!--Button trigger extra large modal-->
                <div class="sm:col-span-full">
                    <div class="relative rounded-md shadow-sm">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <span class="text-gray-500 sm:text-sm"><svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                                </svg>
                            </span>
                        </div>
                        <x-input wire:model.live="busqueda" type="text" name="search" id="search"
                            class="inline-block w-full pl-10" autocomplete="off" placeholder="Buscar" />
                    </div>
                </div>
            </div>

            <div {{-- class="overflow-x-auto" --}}>
                <div class="bg-white dark:bg-gray-800 shadow-xl sm:rounded-md">
                    <table
                        class="min-w-full border-2 border-separate border-spacing-0 text-center shadow-lg rounded-md border-solid border-gray-300 dark:border-gray-800">
                        <thead class="bg-gray-300 dark:bg-gray-800 text-center">
                            <tr class="text-gray-800 dark:text-gray-300">
                                <th class="w-1/12 py-2 px-4"></th>
                                <th class="w-1/2 py-2 px-4">Dirección o Unidad</th>
                                <th class="w-1/12 py-2 px-4">Entrega hoy</th>
                                <th class="w-1/4 py-2 px-4">Última actualización</th>
                                <th class="w-1/12 py-2 px-4">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-600">
                            @foreach ($direcciones as $dir)
                                <tr
                                    class="text-gray-800 dark:text-gray-200 border-b border-gray-300 dark:border-gray-700 {{ $dir->cantidad_solicitudes > 0 ? 'bg-[#FF921F] bg-opacity-40' : 'bg-transparent' }}">
                                    <td
                                        class="py-2 px-4 {{ $loop->last ? 'border-none' : 'border-b border-gray-200 dark:border-gray-700' }}">
                                        @if ($dir->cantidad_solicitudes > 0)
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="#FF921F" class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0M3.124 7.5A8.969 8.969 0 0 1 5.292 3m13.416 0a8.969 8.969 0 0 1 2.168 4.5" />
                                            </svg>
                                        @endif
                                    </td>
                                    <td
                                        class="py-2 px-4 {{ $loop->last ? 'border-none' : 'border-b border-gray-200 dark:border-gray-700' }}">
                                        {{ $dir->direccion }}
                                    </td>
                                    <td
                                        class="py-2 px-4 {{ $loop->last ? 'border-none' : 'border-b border-gray-200 dark:border-gray-700' }}">
                                        @if (\Carbon\Carbon::parse($dir->hora_actualizacion)->isToday())
                                            <span
                                                class="inline-block whitespace-nowrap rounded-[0.27rem] bg-success-400 px-[0.65em] pb-[0.25em] pt-[0.35em] text-center text-lg align-baseline text-[0.75em] font-bold leading-none text-success-800"
                                                style="width: 51.4333px;">SÍ</span>
                                        @else
                                            <span
                                                class="inline-block whitespace-nowrap rounded-[0.27rem] bg-danger-400 px-[0.65em] pb-[0.25em] pt-[0.35em] text-center text-lg align-baseline text-[0.75em] font-bold leading-none text-danger-800">NO</span>
                                        @endif
                                    </td>
                                    <td
                                        class="py-2 px-4 {{ $loop->last ? 'border-none' : 'border-b border-gray-200 dark:border-gray-700' }}">
                                        {{ \Carbon\Carbon::parse($dir->hora_actualizacion)->translatedFormat('l, d \\de F \\de Y H:i:s') }}
                                    </td>
                                    <td
                                        class="py-2 px-4 {{ $loop->last ? 'border-none' : 'border-b border-gray-200 dark:border-gray-700' }}">
                                        <div class="relative" data-te-dropdown-position="dropstart">
                                            <button
                                                class="flex items-center mx-auto whitespace-nowrap rounded bg-gray-400 px-2 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-gray-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-gray-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-gray-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] motion-reduce:transition-none dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]"
                                                type="button" id="dropdownMenuButton1" data-te-dropdown-toggle-ref
                                                aria-expanded="false" data-te-ripple-init data-te-ripple-color="light">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                            </button>
                                            <ul class="absolute z-[1000] float-left m-0 hidden min-w-max list-none overflow-hidden rounded-lg border-none bg-gray-200 bg-clip-padding text-center text-base shadow-lg dark:bg-neutral-700 [&[data-te-dropdown-show]]:block"
                                                aria-labelledby="dropdownMenuButton1s" data-te-dropdown-menu-ref>
                                                @role('Dirección de Recursos Humanos')
                                                    @if ($dir->cantidad_solicitudes > 0 && $dir->habilitado == 0)
                                                        <li>
                                                            <button type="button"
                                                                wire:click='habilitar({{ $dir->id }})'
                                                                class="block w-full whitespace-nowrap bg-transparent px-4 py-2 text-sm font-normal text-neutral-700 hover:bg-neutral-100 active:text-neutral-800 active:no-underline disabled:pointer-events-none disabled:bg-transparent disabled:text-neutral-400 dark:text-neutral-200 dark:hover:bg-neutral-600"
                                                                data-te-dropdown-item-ref>
                                                                <div class="flex items-end space-x-2">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                        viewBox="0 0 24 24" stroke-width="1.5"
                                                                        stroke="currentColor"
                                                                        class="w-5 h-5 bg-transparent">
                                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                                            d="m4.5 12.75 6 6 9-13.5" />
                                                                    </svg>

                                                                    <h6
                                                                        class="text-sm font-normal text-neutral-700 dark:text-gray-200">
                                                                        Habilitar</h6>
                                                                </div>
                                                            </button>
                                                        </li>
                                                    @endif
                                                @endrole
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="mt-2">
                {{ $direcciones->links() }}
            </div>
        </div>
        @if ($modal)
            @include('livewire.pir.habilitar')
        @endif
        <div wire:loading.flex wire:target="habilitarDir"
            class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50">
            <div class="animate-spin rounded-full h-32 w-32 border-t-4 border-b-4 border-[#FF921F] bg-transparent">
            </div>
        </div>
    </div>
    @push('js')
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
