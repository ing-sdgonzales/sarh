<div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400">
    <div class="flex justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

        <div class="fixed inset-0 transition-opacity">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>

        <div class="inline-block align-bottom bg-gray-100 dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full"
            role="dialog" aria-modal="true" aria-labelledby="modal-headline">
            <div
                class="flex flex-shrink-0 items-center justify-between rounded-t-md border-b-2 border-gray-300 border-opacity-100 p-4 dark:border-opacity-50">
                <!--Modal title-->
                <h5 class="text-xl font-medium leading-normal text-neutral-800 dark:text-neutral-200"
                    id="exampleModalCenterTitle">
                    {{ $modo_edicion ? 'Editar registro' : 'Nuevo registro' }}
                </h5>
                <!--Close button-->
                <button type="button" wire:click='cerrarModal'
                    class="box-content rounded-none border-none hover:no-underline hover:opacity-75 focus:opacity-100 focus:shadow-none focus:outline-none"
                    aria-label="Close">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="h-6 w-6 dark:text-gray-200">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!--Modal body-->
            <form method="POST" wire:submit='guardar'>
                @method('POST')
                @csrf
                <div class="relative p-4">
                    <div class="space-y-12">
                        <div>
                            <div class="mt-2 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                                <div class="sm:col-span-2">
                                    <x-label for="fecha" value="{{ __('Fecha') }}" />
                                    <div class="mt-2">
                                        <x-input wire:model='fecha' type="date" name="fecha" id="fecha"
                                            required class="block w-full" />
                                        <div>
                                            <span class="text-red-600 text-sm">
                                                @error('fecha')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <x-label for="hora_inicio" value="{{ __('Hora de inicio') }}" />
                                    <div class="mt-2">
                                        <x-input wire:model='hora_inicio' type="time" name="hora_inicio"
                                            id="hora_inicio" required class="block w-full" />
                                        <div>
                                            <span class="text-red-600 text-sm">
                                                @error('hora_inicio')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <x-label for="hora_fin" value="{{ __('Hora de finalización') }}" />
                                    <div class="mt-2">
                                        <x-input wire:model='hora_fin' type="time" name="hora_fin" id="hora_fin"
                                            required class="block w-full" />
                                        <div>
                                            <span class="text-red-600 text-sm">
                                                @error('hora_fin')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="sm:col-span-full">
                                    <x-label for="ubicacion" value="{{ __('Ubicación') }}" />
                                    <div class="mt-2">
                                        <x-input wire:model='ubicacion' type="text" name="ubicacion" id="ubicacion"
                                            required class="block w-full" />
                                        <div>
                                            <span class="text-red-600 text-sm">
                                                @error('ubicacion')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="pb-6">
                            <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                                <div class="sm:col-span-6">
                                    <p class="text-sm leading-6 text-gray-600 dark:text-gray-200">
                                        <strong>Participantes</strong>
                                    </p>
                                    <hr>
                                </div>
                                <div class="sm:col-span-6">
                                    <x-label for="dependencia_nominal" value="{{ __('Dependencia') }}" />
                                    <div class="mt-2">
                                        <x-select wire:model='dependencia_nominal'
                                            wire:change='getEmpleadosByDependencia' id="dependencia_nominal"
                                            name="dependencia_nominal" class="block w-full">
                                            <option value="">Seleccionar...</option>
                                            @foreach ($dependencias_nominales ?? [] as $dependencia_nominal)
                                                <option value="{{ $dependencia_nominal->id }}">
                                                    {{ $dependencia_nominal->dependencia }}
                                                </option>
                                            @endforeach
                                        </x-select>
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('dependencia_nominal')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-6">
                                    <div class="relative rounded-md">
                                        <div
                                            class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                            <span class="text-gray-500 sm:text-sm"><svg
                                                    xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="w-5 h-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                                                </svg>
                                            </span>
                                        </div>
                                        <x-input wire:model.live="busqueda_empleado" type="text" name="search"
                                            id="search" class="inline-block w-full pl-10" autocomplete="off"
                                            placeholder="Buscar" />
                                    </div>
                                </div>

                                <div class="sm:col-span-6">
                                    <div>
                                        <!-- Otra parte de tu interfaz -->
                                        <p class="dark:text-gray-200">Empleados seleccionados:
                                            {{ count($participante) }}</p>
                                    </div>
                                    <table
                                        class="min-w-full border-2 border-separate border-spacing-0 text-center shadow-lg rounded-md border-solid border-gray-300 dark:border-gray-600">
                                        <thead class="bg-gray-300 dark:bg-gray-800 text-center">
                                            <tr class="text-gray-800 dark:text-gray-300">
                                                <th class="w-1/12 py-2 px-4">
                                                    @if (empty($filtro))
                                                        @if ($marcador == false)
                                                            <button wire:click.prevent='marcarEmpleados'
                                                                @if (count($empleados) == 0) disabled @endif>
                                                                <div
                                                                    class="bg-green-300 rounded hover:bg-green-400 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-green-400 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-green-400 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]">
                                                                    <div class="flex flex-row items-center p-1">
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            fill="none" viewBox="0 0 24 24"
                                                                            stroke-width="2" stroke="green"
                                                                            class="w-4 h-4">
                                                                            <path stroke-linecap="round"
                                                                                stroke-linejoin="round"
                                                                                d="m4.5 12.75 6 6 9-13.5" />
                                                                        </svg>
                                                                    </div>
                                                                </div>
                                                            </button>
                                                        @else
                                                            <button wire:click.prevent='desmarcarEmpleados'
                                                                @if (count($empleados) == 0) disabled @endif>
                                                                <div
                                                                    class="bg-red-300 rounded hover:bg-red-400 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-red-400 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-red-400 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]">
                                                                    <div class="flex flex-row items-center p-1">
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            fill="none" viewBox="0 0 24 24"
                                                                            stroke-width="2" stroke="red"
                                                                            class="w-4 h-4">
                                                                            <path stroke-linecap="round"
                                                                                stroke-linejoin="round"
                                                                                d="M6 18 18 6M6 6l12 12" />
                                                                        </svg>
                                                                    </div>
                                                                </div>
                                                            </button>
                                                        @endif
                                                    @else
                                                        @if ($marcador_dependencia[$filtro] == false)
                                                            <button wire:click.prevent='marcarEmpleados'
                                                                @if (count($empleados) == 0) disabled @endif>
                                                                <div
                                                                    class="bg-green-300 rounded hover:bg-green-400 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-green-400 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-green-400 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]">
                                                                    <div class="flex flex-row items-center p-1">
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            fill="none" viewBox="0 0 24 24"
                                                                            stroke-width="2" stroke="green"
                                                                            class="w-4 h-4">
                                                                            <path stroke-linecap="round"
                                                                                stroke-linejoin="round"
                                                                                d="m4.5 12.75 6 6 9-13.5" />
                                                                        </svg>
                                                                    </div>
                                                                </div>
                                                            </button>
                                                        @elseif($marcador_dependencia[$filtro] == true)
                                                            <button wire:click.prevent='desmarcarEmpleados'
                                                                @if (count($empleados) == 0) disabled @endif>
                                                                <div
                                                                    class="bg-red-300 rounded hover:bg-red-400 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-red-400 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-red-400 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]">
                                                                    <div class="flex flex-row items-center p-1">
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            fill="none" viewBox="0 0 24 24"
                                                                            stroke-width="2" stroke="red"
                                                                            class="w-4 h-4">
                                                                            <path stroke-linecap="round"
                                                                                stroke-linejoin="round"
                                                                                d="M6 18 18 6M6 6l12 12" />
                                                                        </svg>
                                                                    </div>
                                                                </div>
                                                            </button>
                                                        @endif
                                                    @endif
                                                </th>
                                                <th class="w-1/3 py-2 px-4">Nombre</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white dark:bg-gray-600">
                                            @foreach ($empleados as $empleado)
                                                <tr class="text-gray-800 dark:text-gray-200">
                                                    <td
                                                        class="py-2 px-4 items-center {{ $loop->last ? 'border-none' : 'border-b border-gray-200 dark:border-gray-700' }}">
                                                        <div class="relative flex gap-x-2 justify-center">
                                                            <div class="flex h-6 items-center">
                                                                <input wire:model.live='participante' type="checkbox"
                                                                    id="empleado-{{ $empleado->id }}"
                                                                    value="{{ $empleado->id }}"
                                                                    class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600">
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td
                                                        class="py-2 px-4 {{ $loop->last ? 'border-none' : 'border-b border-gray-200 dark:border-gray-700' }}">
                                                        <label for="empleado-{{ $empleado->id }}">
                                                            {{ $empleado->nombres . ' ' . $empleado->apellidos }}
                                                        </label>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="mt-2">
                                {{ $empleados->links() }}
                            </div>
                        </div>
                    </div>
                </div>

                <!--Modal footer-->
                <div
                    class="flex flex-shrink-0 flex-wrap items-center justify-end rounded-b-md border-t-2 border-gray-300 border-opacity-100 p-4 dark:border-opacity-50">
                    <button type="button" wire:click='cerrarModal'
                        class="inline-block rounded-lg bg-danger-200 px-6 pb-2 pt-2.5 font-medium leading-normal text-danger-700 transition duration-150 ease-in-out hover:bg-red-400 focus:bg-red-accent-100 focus:outline-none focus:ring-0 active:bg-primary-accent-200"
                        data-te-ripple-init data-te-ripple-color="light">
                        {{ __('Cancel') }}
                    </button>
                    <button type="submit"
                        class="ml-1 inline-block rounded-lg bg-primary px-6 pb-2 pt-2.5 font-medium leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-primary-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-primary-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-primary-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]"
                        data-te-ripple-init data-te-ripple-color="light">
                        {{ __('Save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
