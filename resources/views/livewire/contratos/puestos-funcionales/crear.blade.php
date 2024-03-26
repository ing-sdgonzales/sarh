<div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400">
    <div class="flex justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

        <div class="fixed inset-0 transition-opacity">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>

        <div class="inline-block align-bottom bg-gray-100 dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl sm:w-full"
            role="dialog" aria-modal="true" aria-labelledby="modal-headline">
            <div
                class="flex flex-shrink-0 items-center justify-between rounded-t-md border-b-2 border-gray-300 border-opacity-100 p-4 dark:border-opacity-50">
                <!--Modal title-->
                <h5 class="text-xl font-medium leading-normal text-neutral-800 dark:text-neutral-200"
                    id="exampleModalCenterTitle">
                    Nuevo registro
                </h5>
                <!--Close button-->
                <button type="button" wire:click='cerrarModalPuestoContrato'
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
                @csrf
                <div class="relative p-4">
                    <div class="space-y-12">
                        <div class="pb-6">
                            <div class="mt-2 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                                <div class="sm:col-span-2">
                                    <x-label for="contrato" value="{{ __('Número de contrato') }}" />
                                    <div class="mt-2">
                                        <x-select wire:model='contrato' id="contrato" name="contrato" required
                                            wire:change='getDisponibilidadFechas' class="block w-full">
                                            <option value="">Seleccionar...</option>
                                            @foreach ($contratos ?? [] as $contrato)
                                                <option value="{{ $contrato->id }}">
                                                    {{ $contrato->numero }}
                                                </option>
                                            @endforeach
                                        </x-select>
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('contrato')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-4">
                                    <x-label for="dependencia_funcional" value="{{ __('Dependencia funcional') }}" />
                                    <div class="mt-2">
                                        <x-select wire:model='dependencia_funcional' id="dependencia_funcional"
                                            name="dependencia_funcional" required class="block w-full">
                                            <option value="">Seleccionar...</option>
                                            @foreach ($dependencias_funcionales ?? [] as $dependencia_funcional)
                                                <option value="{{ $dependencia_funcional->id }}">
                                                    {{ $dependencia_funcional->dependencia }}
                                                </option>
                                            @endforeach
                                        </x-select>
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
                                    <x-label for="puesto_funcional" value="{{ __('Puesto Funcional') }}" />
                                    <div class="mt-2">
                                        <x-select wire:model='puesto_funcional' id="puesto_funcional"
                                            name="puesto_funcional" class="block w-full">
                                            <option value="">No aplica</option>
                                            @foreach ($puestos_funcionales ?? [] as $puesto_funcional)
                                                <option value="{{ $puesto_funcional->id }}">
                                                    {{ $puesto_funcional->puesto }}
                                                </option>
                                            @endforeach
                                        </x-select>
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('puesto_funcional')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <x-lable for="region" value="{{ __('Región') }}" />
                                    <div class="mt-2">
                                        <x-select wire:model='region' id="region" name="region" required
                                            class="block w-full">
                                            <option value="">Seleccionar...</option>
                                            @foreach ($regiones ?? [] as $region)
                                                <option value="{{ $region->id }}">
                                                    {{ $region->region }} - {{ $region->nombre }}
                                                </option>
                                            @endforeach
                                        </x-select>
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('region')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <x-label for="fecha_inicio" value="{{ __('Fecha de inicio') }}" />
                                    <div class="mt-2">
                                        <x-input wire:model='fecha_inicio' type="date" name="fecha_inicio"
                                            id="fecha_inicio" min="{{ $fecha_min }}" max="{{ $fecha_max }}"
                                            class="block w-full" />
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('fecha_inicio')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <x-label for="fecha_fin" value="{{ __('Fecha de finalización') }}" />
                                    <div class="mt-2">
                                        <x-input wire:model='fecha_fin' type="date" name="fecha_fin" id="fecha_fin"
                                            min="{{ $fecha_min }}" max="{{ $fecha_max }}"
                                            class="block w-full" />
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('fecha_fin')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="col-span-full">
                                    <x-lable for="observacion" value="{{ __('Observación') }}" />
                                    <div class="mt-2">
                                        <x-textarea wire:model='observacion' id="observacion" name="observación"
                                            rows="3" class="block w-full"></x-textarea>
                                    </div>
                                    <p class="mt-3 text-sm leading-6 text-gray-700 dark:text-gray-200">Breve
                                        descripción para la
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

                <!--Modal footer-->
                <div
                    class="flex flex-shrink-0 flex-wrap items-center justify-end rounded-b-md border-t-2 border-gray-300 border-opacity-100 p-4 dark:border-opacity-50">
                    <button type="button" wire:click='cerrarModalPuestoContrato'
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
