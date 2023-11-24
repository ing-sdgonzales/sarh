<div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400">
    <div class="flex justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

        <div class="fixed inset-0 transition-opacity">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>

        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-5xl sm:w-full"
            role="dialog" aria-modal="true" aria-labelledby="modal-headline">
            <div
                class="flex flex-shrink-0 items-center justify-between rounded-t-md border-b-2 border-neutral-100 border-opacity-100 p-4 dark:border-opacity-50">
                <!--Modal title-->
                <h5 class="text-xl font-medium leading-normal text-neutral-800 dark:text-neutral-200"
                    id="exampleModalCenterTitle">
                    Nuevo registro
                </h5>
                <!--Close button-->
                <button type="button" wire:click='cerrarModalAsignarPuesto()'
                    class="box-content rounded-none border-none hover:no-underline hover:opacity-75 focus:opacity-100 focus:shadow-none focus:outline-none"
                    aria-label="Close">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!--Modal body-->
            <form method="POST" wire:submit='guardarPuesto'>
                @method('POST')
                @csrf
                <div class="relative p-4">
                    <div class="space-y-12">
                        <div class="border-b border-gray-900/10 pb-6">
                            <div class="mt-2 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                                <div class="sm:col-span-3">
                                    <label for="tipo_contratacion"
                                        class="block text-sm font-medium leading-6 text-gray-900">Tipo de
                                        contratación</label>
                                    <div class="mt-2">
                                        <select wire:model='tipo_contratacion' id="tipo_contratacion"
                                            name="tipo_contratación" required
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            <option value="">Seleccionar...</option>
                                            @foreach ($tipos_contrataciones ?? [] as $contratacion)
                                                <option value="{{ $contratacion->id }}">
                                                    {{ $contratacion->tipo }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('tipo_contratacion')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="tipo_servicio"
                                        class="block text-sm font-medium leading-6 text-gray-900">Tipo de
                                        servicio</label>
                                    <div class="mt-2">
                                        <select wire:model='tipo_servicio' wire:change='getPuestosByTipoServicio'
                                            id="tipo_servicio" name="tipo_servicio" required
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            <option value="">Seleccionar...</option>
                                            @foreach ($tipos_servicios ?? [] as $servicio)
                                                <option value="{{ $servicio->id }}">
                                                    {{ $servicio->tipo_servicio }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('tipo_servicio')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="dependencia_nominal"
                                        class="block text-sm font-medium leading-6 text-gray-900">Dependencia
                                        nominal</label>
                                    <div class="mt-2">
                                        <select wire:model='dependencia_nominal' wire:change='getPuestosByDependencia'
                                            id="dependencia_nominal" name="dependencia_nominal" required
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

                                <div class="sm:col-span-3">
                                    <label for="puesto_nominal"
                                        class="block text-sm font-medium leading-6 text-gray-900">Puesto
                                        nominal</label>
                                    <div class="mt-2">
                                        <select wire:model='puesto_nominal' id="puesto_nominal" name="puesto_nominal"
                                            required wire:change='getSalarioByPuesto'
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            <option value="">Seleccionar...</option>
                                            @foreach ($puestos_nominales ?? [] as $puesto_nominal)
                                                <option value="{{ $puesto_nominal->id }}">
                                                    {{ $puesto_nominal->puesto }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('puesto_nominal')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="fecha_inicio"
                                        class="block text-sm font-medium leading-6 text-gray-900">Fecha de
                                        ingreso</label>
                                    <div class="mt-2">
                                        <input wire:model='fecha_inicio' type="date" name="fecha_inicio"
                                            id="fecha_inicio" min="1996-11-11"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('fecha_inicio')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="fecha_fin"
                                        class="block text-sm font-medium leading-6 text-gray-900">Fecha de
                                        finalización</label>
                                    <div class="mt-2">
                                        <input wire:model='fecha_fin' type="date" name="fecha_fin" id="fecha_fin"
                                            min="1996-11-11"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('fecha_fin')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="salario"
                                        class="block text-sm font-medium leading-6 text-gray-900">Salario</label>
                                    <div class="mt-2">
                                        <input wire:model='salario' type="number" name="salario" id="salario"
                                            disabled readonly required min="0" step="0.01"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('salario')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="dependencia_funcional"
                                        class="block text-sm font-medium leading-6 text-gray-900">Dependencia
                                        funcional</label>
                                    <div class="mt-2">
                                        <select wire:model='dependencia_funcional'
                                            wire:change='getPuestosByDependencia' id="dependencia_funcional"
                                            name="dependencia_funcional" required
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            <option value="">Seleccionar...</option>
                                            @foreach ($dependencias_funcionales ?? [] as $dependencia_funcional)
                                                <option value="{{ $dependencia_funcional->id }}">
                                                    {{ $dependencia_funcional->dependencia }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('dependencia_funcional')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="puesto_funcional"
                                        class="block text-sm font-medium leading-6 text-gray-900">Puesto
                                        funcional</label>
                                    <div class="mt-2">
                                        <select wire:model='puesto_funcional' id="puesto_funcional"
                                            name="puesto_funcional" required
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            <option value="">Seleccionar...</option>
                                            @foreach ($puestos_funcionales ?? [] as $puesto_funcional)
                                                <option value="{{ $puesto_funcional->id }}">
                                                    {{ $puesto_funcional->puesto }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('puesto_funcional')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="col-span-full">
                                    <label for="observacion"
                                        class="block text-sm font-medium leading-6 text-gray-900">Observación</label>
                                    <div class="mt-2">
                                        <textarea wire:model='observacion' id="observacion" name="observación" rows="3"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"></textarea>
                                    </div>
                                    <p class="mt-3 text-sm leading-6 text-gray-600">Breve descripción para la
                                        contratación.</p>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('observacion')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>
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
                    <button type="button" wire:click='cerrarModalAsignarPuesto()'
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
