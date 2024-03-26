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
                                    <x-label for="fecha_consulta" value="{{ __('Fecha de consulta') }}" />
                                    <div class="mt-2">
                                        <x-input wire:model='fecha_consulta' type="date" name="fecha_consulta"
                                            id="fecha_consulta" required class="block w-full" />
                                        <div>
                                            <span class="text-red-600 text-sm">
                                                @error('fecha_consulta')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-span-full">
                                    <x-label for="consulta" value="{{ __('Consulta') }}" />
                                    <div class="mt-2">
                                        <x-textarea wire:model='consulta' id="consulta" name="consulta" rows="3"
                                            required class="block w-full"></x-textarea>
                                    </div>
                                    <p class="mt-3 text-sm leading-6 text-gray-700 dark:text-gray-200">Síntomas,
                                        diagnostico o razón de la
                                        visita.</p>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('consulta')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="col-span-full">
                                    <x-label for="receta" value="{{ __('Receta') }}" />
                                    <div class="mt-2">
                                        <x-textarea wire:model='receta' id="receta" name="receta" rows="3"
                                            required class="block w-full"></x-textarea>
                                    </div>
                                    <p class="mt-3 text-sm leading-6 text-gray-700 dark:text-gray-200">Recomendaciones
                                        médicas,
                                        tratamientos, medicamentos, dosis, frecuencia y duración del tratamiento.</p>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('receta')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-full">
                                    <div class="relative flex gap-x-3">
                                        <div class="flex h-6 items-center">
                                            <x-checkbox wire:model.live='suspension' id="suspension" name="suspension"
                                                type="checkbox" class="h-4 w-4" />
                                        </div>
                                        <div class="text-sm leading-6">
                                            <x-label for="suspension" value="{{ __('¿Requiere suspensión?') }}" />
                                            <p class="text-gray-700 dark:text-gray-200">Indicador cuando el paciente
                                                require suspensión
                                        </div>
                                    </div>
                                </div>

                                @if ($suspension)
                                    <div class="sm:col-span-3">
                                        <x-label for="desde" value="{{ __('Desde') }}" />
                                        <div class="mt-2">
                                            <x-input wire:model='desde' type="date" name="desde" id="desde"
                                                required class="block w-full" />
                                            <div>
                                                <span class="text-red-600 text-sm">
                                                    @error('desde')
                                                        {{ $message }}
                                                    @enderror
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="sm:col-span-3">
                                        <x-label for="hasta" value="{{ __('Hasta') }}" />
                                        <div class="mt-2">
                                            <x-input wire:model='hasta' type="date" name="hasta" id="hasta"
                                                required class="block w-full" />
                                            <div>
                                                <span class="text-red-600 text-sm">
                                                    @error('hasta')
                                                        {{ $message }}
                                                    @enderror
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <div class="sm:col-span-full">
                                    <x-label for="proxima_consulta" value="{{ __('Próxima consulta') }}" />
                                    <div class="mt-2">
                                        <x-input wire:model='proxima_consulta' type="date" name="proxima_consulta"
                                            id="proxima_consulta" class="block w-full" />
                                        <div>
                                            <span class="text-red-600 text-sm">
                                                @error('proxima_consulta')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
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
