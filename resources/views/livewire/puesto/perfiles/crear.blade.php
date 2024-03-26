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
                    Información del perfil del puesto
                </h5>
                <!--Close button-->
                <button type="button" wire:click='cerrarPerfilModal'
                    class="box-content rounded-none border-none hover:no-underline hover:opacity-75 focus:opacity-100 focus:shadow-none focus:outline-none"
                    aria-label="Close">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="h-6 w-6 dark:text-gray-200">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!--Modal body-->
            <form method="POST" wire:submit='guardarPerfil'>
                @csrf
                <div class="relative p-4">
                    <div class="space-y-12">
                        <div class="pb-6">
                            <div class="mt-2 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                                <div class="sm:col-span-full">
                                    <x-label for="descripcion" value="{{ __('Descripción') }}" />
                                    <div class="mt-2">
                                        <x-textarea wire:model='descripcion' name="descripcion" rows="2"
                                            id="descripcion" required class="block w-full"></x-textarea>
                                        <div>
                                            <span class="text-red-600 text-sm">
                                                @error('descripcion')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="sm:col-span-full">
                                    <x-label for="experiencia" value="{{ __('Experiencia') }}" />
                                    <div class="mt-2">
                                        <x-textarea wire:model='experiencia' name="experiencia" rows="2"
                                            id="experiencia" required class="block w-full"></x-textarea>
                                        <div>
                                            <span class="text-red-600 text-sm">
                                                @error('experiencia')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="sm:col-span-full">
                                    <x-label for="disponibilidad" value="{{ __('Disponibilidad') }}" />
                                    <div class="mt-2">
                                        <x-textarea wire:model='disponibilidad' name="disponibilidad" rows="1"
                                            id="disponibilidad" required class="block w-full"></x-textarea>
                                        <div>
                                            <span class="text-red-600 text-sm">
                                                @error('disponibilidad')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="sm:col-span-full">
                                    <x-label for="registro_academico" value="{{ __('Nivel acádemico') }}" />
                                    <div class="mt-2">
                                        <x-select wire:model='registro_academico' id="registro_academico" name="registro_academico" required
                                            class="block w-full">
                                            <option value="">Seleccionar...</option>
                                            @foreach ($registros_academicos as $registro)
                                                <option value="{{ $registro->id }}">
                                                    {{ $registro->nivel }}
                                                </option>
                                            @endforeach
                                        </x-select>
                                        <div>
                                            <span class="text-red-600 text-sm">
                                                @error('registro_academico')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="sm:col-span-full">
                                    <x-label for="estudios" value="{{ __('Estudios') }}" />
                                    <div class="mt-2">
                                        <x-textarea wire:model='estudios' name="estudios" rows="2" id="estudios"
                                            required class="block w-full"></x-textarea>
                                        <div>
                                            <span class="text-red-600 text-sm">
                                                @error('estudios')
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
                    <button type="button" wire:click='cerrarPerfilModal'
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
