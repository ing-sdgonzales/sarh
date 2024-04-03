<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Informe de Estado de Fuerza') }}
        </h2>
    </x-slot>

    <div class="p-4 mt-2 grid grid-cols-6 gap-x-4 gap-y-8">
        @can('Consolidar PIR')
            <div class="sm:col-span-1">
                <button type="button" wire:click="consolidarPIR"
                    class="inline-block w-full rounded-md h-[42px] bg-primary px-6 pb-2 pt-2.5 text-md font-medium leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-primary-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-primary-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-primary-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]">
                    <div class="flex items-end space-x-2 justify-center">
                        <h6 class="text-sm font-normal text-gray-200">Consolidar PIR</h6>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                        </svg>
                    </div>
                </button>
            </div>

            <div class="sm:col-span-1">
                <button type="button" wire:click="generarReporteDiario"
                    class="inline-block w-full rounded-md h-[42px] bg-primary px-6 pb-2 pt-2.5 text-md font-medium leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-primary-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-primary-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-primary-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]">
                    <div class="flex items-end space-x-2 justify-center">
                        <h6 class="text-sm font-normal text-gray-200">Reporte diario</h6>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                        </svg>
                    </div>
                </button>
            </div>

            <div class="sm:col-span-2">
                <button type="button" wire:click="generarReporteAusencias"
                    class="inline-block w-full rounded-md h-[42px] bg-primary px-6 pb-2 pt-2.5 text-md font-medium leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-primary-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-primary-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-primary-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]">
                    <div class="flex items-end space-x-2 justify-center">
                        <h6 class="text-sm font-normal text-gray-200">Reporte de ausencias</h6>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                        </svg>
                    </div>
                </button>
            </div>
        @endcan
        <div class="sm:col-span-1">
            <button type="button" wire:click="generarFromularioPIR"
                class="inline-block w-full rounded-md h-[42px] bg-primary px-6 pb-2 pt-2.5 text-md font-medium leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-primary-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-primary-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-primary-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]">
                <div class="flex items-end space-x-2 justify-center">
                    <h6 class="text-sm font-normal text-gray-200">PIR</h6>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                    </svg>
                </div>
            </button>
        </div>
    </div>

    <div class="relative p-4">
        <form wire:submit='guardar'>
            @csrf
            <div class="space-y-12 h-full">
                <div class="border-b border-gray-900/10 dark:border-b-gray-600 pb-6">
                    <div class="mt-2 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                        <div class="sm:col-span-3">
                            <x-label for=seccion value="{{ __('División') }}" />
                            <div class="mt-2">
                                <x-input wire:model='seccion' type="text" name="seccion" id="seccion" required
                                    class="block w-full" disabled readonly />
                            </div>
                            <div>
                                <span class="text-red-600 text-sm">
                                    @error('seccion')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <x-label for=direccion value="{{ __('Dirección o Unidad') }}" />
                            <div class="mt-2">
                                <x-input wire:model='direccion' type="text" name="direccion" id="direccion" required
                                    class="block w-full" disabled readonly />
                            </div>
                            <div>
                                <span class="text-red-600 text-sm">
                                    @error('direccion')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        </div>
                        <div class="sm:col-span-full">
                            <div class="text-xl">
                                <h1 class="p-2 mt-8 font-semibold leading-7 text-gray-900 dark:text-gray-400">Registro
                                    de personal
                                </h1>
                            </div>
                            <div class="bg-white dark:bg-gray-800 overflow-x-hidden shadow-xl sm:rounded-lg">
                                <div>
                                    <table class="min-w-full rounded-lg overflow-x-hidden text-center">
                                        <thead class="bg-gray-300 dark:bg-gray-800 text-center">
                                            <tr class="text-gray-800 dark:text-gray-300">
                                                <th class="w-1/12 py-2 px-4">No.</th>
                                                <th class="w-1/4 py-2 px-4">Nombre</th>
                                                <th class="w-1/6 py-2 px-4">Reporte</th>
                                                <th class="w-1/6 py-2 px-4">Departamento</th>
                                                <th class="w-1/12 py-2 px-4">Grupo</th>
                                                <th class="w-1/6 py-2 px-4">Observación</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white dark:bg-gray-600">
                                            @foreach ($personal as $key => $emp)
                                                <tr
                                                    class="text-gray-800 dark:text-gray-200 border-b border-gray-300 dark:border-gray-700">
                                                    <td class="py-2 px-4">{{ $loop->iteration . '.' }}</td>
                                                    <td class="py-2 px-4"><x-input
                                                            wire:model='personal.{{ $key }}.nombre'
                                                            type="text" required
                                                            class="text-center block w-full border-none" disabled
                                                            readonly /></td>
                                                    <td class="py-2 px-4"><x-select
                                                            wire:model='personal.{{ $key }}.pir_reporte_id'
                                                            class="block w-full text-center border-none">
                                                            @foreach ($reportes ?? [] as $reporte)
                                                                <option value="{{ $reporte->id }}">
                                                                    {{ $reporte->reporte }}
                                                                </option>
                                                            @endforeach
                                                        </x-select></td>
                                                    <td class="py-2 px-4"><x-select
                                                            wire:model='personal.{{ $key }}.departamento_id'
                                                            class="block w-full text-center border-none">
                                                            @foreach ($departamentos ?? [] as $depto)
                                                                <option value="{{ $depto->id }}">
                                                                    {{ $depto->nombre }}
                                                                </option>
                                                            @endforeach
                                                        </x-select></td>
                                                    <td class="py-2 px-4"><x-select
                                                            wire:model='personal.{{ $key }}.pir_grupo_id'
                                                            class="block w-full text-center border-none">
                                                            @foreach ($grupos ?? [] as $grupo)
                                                                <option value="{{ $grupo->id }}">
                                                                    {{ $grupo->grupo }}
                                                                </option>
                                                            @endforeach
                                                        </x-select></td>
                                                    <td class="py-2 px-4"><x-input
                                                            wire:model='personal.{{ $key }}.observacion'
                                                            type="text" class="text-center block w-full" />
                                                        <div>
                                                            <span class="text-red-600 text-sm">
                                                                @error('personal.{{ $key }}.observacion')
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="sm:col-span-full">
                            <div class="text-xl">
                                <h1 class="p-2 mt-8 font-semibold leading-7 text-gray-900 dark:text-gray-400">Registro
                                    de contratistas
                                </h1>
                            </div>
                            <div class="bg-white dark:bg-gray-800 overflow-x-hidden shadow-xl sm:rounded-lg">
                                <div>
                                    <table class="min-w-full rounded-lg overflow-x-hidden text-center">
                                        <thead class="bg-gray-300 dark:bg-gray-800 text-center">
                                            <tr class="text-gray-800 dark:text-gray-300">
                                                <th class="w-1/12 py-2 px-4">No.</th>
                                                <th class="w-1/4 py-2 px-4">Nombre</th>
                                                <th class="w-1/6 py-2 px-4">Reporte</th>
                                                <th class="w-1/6 py-2 px-4">Departamento</th>
                                                <th class="w-1/12 py-2 px-4">Grupo</th>
                                                <th class="w-1/6 py-2 px-4">Observación</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white dark:bg-gray-600">
                                            @foreach ($contratista as $key => $emp)
                                                <tr
                                                    class="text-gray-800 dark:text-gray-200 border-b border-gray-300 dark:border-gray-700">
                                                    <td class="py-2 px-4">{{ $loop->iteration . '.' }}</td>
                                                    <td class="py-2 px-4"><x-input
                                                            wire:model='contratista.{{ $key }}.nombre'
                                                            type="text" required
                                                            class="text-center block w-full border-none" disabled
                                                            readonly /></td>
                                                    <td class="py-2 px-4"><x-select
                                                            wire:model='contratista.{{ $key }}.pir_reporte_id'
                                                            class="block w-full text-center border-none">
                                                            @foreach ($reportes ?? [] as $reporte)
                                                                <option value="{{ $reporte->id }}">
                                                                    {{ $reporte->reporte }}
                                                                </option>
                                                            @endforeach
                                                        </x-select></td>
                                                    <td class="py-2 px-4"><x-select
                                                            wire:model='contratista.{{ $key }}.departamento_id'
                                                            class="block w-full text-center border-none">
                                                            @foreach ($departamentos as $depto)
                                                                <option value="{{ $depto->id }}">
                                                                    {{ $depto->nombre }}
                                                                </option>
                                                            @endforeach
                                                        </x-select></td>
                                                    <td class="py-2 px-4"><x-select
                                                            wire:model='contratista.{{ $key }}.pir_grupo_id'
                                                            class="block w-full text-center border-none">
                                                            @foreach ($grupos ?? [] as $grupo)
                                                                <option value="{{ $grupo->id }}">
                                                                    {{ $grupo->grupo }}
                                                                </option>
                                                            @endforeach
                                                        </x-select></td>
                                                    <td class="py-2 px-4"><x-input
                                                            wire:model="contratista.{{ $key }}.observacion"
                                                            type="text" class="text-center block w-full" />
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex gap-x-2 mt-2 justify-end">
                <x-button type="submit">{{ __('Guardar') }}</x-button>
            </div>
        </form>
        <div wire:loading.flex
            wire:target="guardar,generarFromularioPIR,consolidarPIR,generarReporteDiario,generarReporteAusencias"
            class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50">
            <div class="animate-spin rounded-full h-32 w-32 border-t-4 border-b-4 border-[#FF921F] bg-transparent">
            </div>
        </div>
    </div>
    @push('js')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Livewire.on('download', data => {
                    Swal.fire({
                        title: '¡Hecho!',
                        text: data[0].message,
                        icon: 'success',
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
                    html: `<?php echo session('error'); ?>`,
                    confirmButtonText: 'Aceptar',
                    confirmButtonColor: '#1F2937'
                })
            </script>
        @endif

        {{-- Validación de campos --}}
        @if ($errors->any())
            <script>
                Swal.fire({
                    icon: 'error',
                    title: '¡Ups!',
                    html: `<small class="text-danger"><?php echo implode('<br>', $errors->all()); ?></small>`,
                    confirmButtonText: 'Aceptar',
                    confirmButtonColor: '#1F2937'
                })
            </script>
        @endif
    @endpush
</div>
