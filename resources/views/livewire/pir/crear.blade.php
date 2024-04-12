<div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400">
    <div class="flex justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

        <div class="fixed inset-0 transition-opacity">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>

        <div class="inline-block align-bottom bg-gray-100 dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full"
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
                        <div class="pb-6">
                            <div class="mt-2 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                                <div class="sm:col-span-full">
                                    <x-label for="nombre" value="{{ __('Nombre completo') }}" />
                                    <div class="mt-2">
                                        <x-input wire:model='nombre' type="text" name="nombre" id="nombre"
                                            required class="block w-full" />
                                        <div>
                                            <span class="text-red-600 text-sm">
                                                @error('nombre')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="sm:col-span-full">
                                    <x-label for="renglon" value="{{ __('Renglón') }}" />
                                    <div class="mt-2">
                                        <x-select wire:model='renglon' wire:change='getPuestosByRenglon' id="renglon"
                                            name="renglón" required class="block w-full">
                                            <option value="">Seleccionar...</option>
                                            @foreach ($renglones as $renglon)
                                                <option value="{{ $renglon->id }}">{{ $renglon->renglon }} -
                                                    {{ $renglon->nombre }}
                                                </option>
                                            @endforeach
                                        </x-select>
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('renglon')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-full">
                                    <x-label for="puesto" value="{{ __('Puesto') }}" />
                                    <div class="mt-2">
                                        <x-select wire:model='puesto' id="puesto" name="puesto" class="block w-full"
                                            required>
                                            <option value="">Seleccionar...</option>
                                            @foreach ($puestos ?? [] as $puesto)
                                                <option value="{{ $puesto->id }}">
                                                    {{ $puesto->puesto }}
                                                </option>
                                            @endforeach
                                        </x-select>
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('puesto')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-full">
                                    <x-label for="direccion" value="{{ __('Dirección') }}" />
                                    <div class="mt-2">
                                        <x-select wire:model='direccion' id="direccion" name="dirección"
                                            class="block w-full" required>
                                            <option value="">Seleccionar...</option>
                                            @foreach ($direcciones ?? [] as $direccion)
                                                <option value="{{ $direccion->id }}">
                                                    {{ $direccion->direccion }}
                                                </option>
                                            @endforeach
                                        </x-select>
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
                                    <x-label for="region" value="{{ __('Región') }}" />
                                    <div class="mt-2">
                                        <x-select wire:model='region' wire:change='getDepartamentosByRegion'
                                            id="region" name="región" required class="block w-full">
                                            <option value="">Seleccionar...</option>
                                            @foreach ($regiones ?? [] as $region)
                                                <option value="{{ $region->id }}">{{ $region->region }} -
                                                    {{ $region->nombre }}
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

                                <div class="sm:col-span-full">
                                    <x-label for="departamento" value="{{ __('Departamento') }}" />
                                    <div class="mt-2">
                                        <x-select wire:model='departamento' id="departamento" name="departamento"
                                            required class="block w-full">
                                            <option value="">Seleccionar...</option>
                                            @foreach ($departamentos ?? [] as $departamento)
                                                <option value="{{ $departamento->id }}">
                                                    {{ $departamento->nombre }}
                                                </option>
                                            @endforeach
                                        </x-select>
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('departamento')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-full">
                                    <x-label for="regional"
                                        value="{{ __('¿Pertenece al Estado de Fuerza de la Región I - Metropolitana?') }}" />
                                    <div class="mt-2">
                                        <x-select wire:model='regional' id="regional" name="regional" required
                                            class="block w-full">
                                            <option value="0" selected>No</option>
                                            <option value="1" selected>Sí</option>
                                        </x-select>
                                    </div>
                                    <p class="text-sm leading-6 text-gray-600 dark:text-gray-200">Este campo debe
                                        marcarse si el empleado o contratista se incluye en el Estado de Fuerza de
                                        la Región I.
                                    </p>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('regional')
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
