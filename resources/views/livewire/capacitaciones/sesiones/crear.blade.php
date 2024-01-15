<div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400">
    <div class="flex justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

        <div class="fixed inset-0 transition-opacity">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>

        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full"
            role="dialog" aria-modal="true" aria-labelledby="modal-headline">
            <div
                class="flex flex-shrink-0 items-center justify-between rounded-t-md border-b-2 border-neutral-100 border-opacity-100 p-4 dark:border-opacity-50">
                <!--Modal title-->
                <h5 class="text-xl font-medium leading-normal text-neutral-800 dark:text-neutral-200"
                    id="exampleModalCenterTitle">
                    Nuevo registro
                </h5>
                <!--Close button-->
                <button type="button" wire:click='cerrarModal'
                    class="box-content rounded-none border-none hover:no-underline hover:opacity-75 focus:opacity-100 focus:shadow-none focus:outline-none"
                    aria-label="Close">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="h-6 w-6">
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
                        <div class="border-b border-gray-900/10 pb-4">
                            <div class="mt-2 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">

                                <div class="sm:col-span-2">
                                    <label for="fecha"
                                        class="block text-sm font-medium leading-6 text-gray-900">Fecha</label>
                                    <div class="mt-2">
                                        <input wire:model='fecha' type="date" name="fecha" id="fecha" required
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
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
                                    <label for="hora_inicio"
                                        class="block text-sm font-medium leading-6 text-gray-900">Hora de inicio</label>
                                    <div class="mt-2">
                                        <input wire:model='hora_inicio' type="time" name="hora_inicio"
                                            id="hora_inicio" required
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
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
                                    <label for="hora_fin" class="block text-sm font-medium leading-6 text-gray-900">Hora
                                        de finalización</label>
                                    <div class="mt-2">
                                        <input wire:model='hora_fin' type="time" name="hora_fin" id="hora_fin"
                                            required
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
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
                                    <label for="ubicacion"
                                        class="block text-sm font-medium leading-6 text-gray-900">Ubicación</label>
                                    <div class="mt-2">
                                        <input wire:model='ubicacion' type="text" name="ubicacion" id="ubicacion"
                                            required
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
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

                        <div class="border-b border-gray-900/10 pb-6">
                            <div class="mt-2 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">

                                <div class="sm:col-span-6">
                                    <p class="text-sm leading-6 text-gray-600">
                                        <strong>Participantes</strong>
                                    </p>
                                    <hr>
                                </div>

                                <div class="sm:col-span-6">
                                    <label for="dependencia_nominal"
                                        class="block text-sm font-medium leading-6 text-gray-900">Dependencia</label>
                                    <div class="mt-2">
                                        <select wire:model='dependencia_nominal' wire:change='getEmpleadosByDependencia'
                                            id="dependencia_nominal" name="dependencia_nominal"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            <option value="">Seleccionar...</option>
                                            @foreach ($dependencias_nominales ?? [] as $dependencia_nominal)
                                                <option value="{{ $dependencia_nominal->id }}">
                                                    {{ $dependencia_nominal->dependencia }}
                                                </option>
                                            @endforeach
                                        </select>
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
                                        <input wire:model.live="busqueda_empleado" type="text" name="search"
                                            id="search" style="height: 42px;" autocomplete="off"
                                            class="inline-block w-full rounded-lg border-0 py-1.5 pl-10 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                            placeholder="Buscar">
                                    </div>
                                </div>

                                <div class="sm:col-span-6">
                                    <div>
                                        <!-- Otra parte de tu interfaz -->
                                        <p>Número de empleados seleccionados:
                                            {{ count($participante) }}</p>
                                    </div>
                                    <table
                                        class="min-w-full bg-white rounded-lg overflow-hidden text-center ring-1 ring-gray-300">
                                        <thead class="bg-gray-100 text-center">
                                            <tr>
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
                                        <tbody>
                                            @foreach ($empleados as $empleado)
                                                <tr>
                                                    <td class="py-2 px-4 items-center">
                                                        <div class="relative flex gap-x-2 justify-center">
                                                            <div class="flex h-6 items-center">
                                                                <input wire:model.live='participante' type="checkbox"
                                                                    id="empleado-{{ $empleado->id }}"
                                                                    value="{{ $empleado->id }}"
                                                                    class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600">
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="py-2 px-4">
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

                <div wire:loading.flex wire:target="guardar"
                    class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50">
                    <div
                        class="animate-spin rounded-full h-32 w-32 border-t-4 border-b-4 border-indigo-50 bg-transparent">
                    </div>
                </div>

                <!--Modal footer-->
                <div
                    class="flex flex-shrink-0 flex-wrap items-center justify-end rounded-b-md border-t-2 border-neutral-100 border-opacity-100 p-4 dark:border-opacity-50">
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
