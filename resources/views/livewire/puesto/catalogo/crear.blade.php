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
            <form method="POST" wire:submit='guardar'>
                @csrf
                <!--Modal body-->
                <div class="relative p-4">
                    <div class="space-y-12">
                        <div class="{{-- border-b border-gray-900/10 dark:border-gray-500 --}} pb-6">
                            <div class="mt-2 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">

                                <div class="sm:col-span-2">
                                    <x-label for="codigo" value="{{ __('Código') }}" />
                                    <div class="mt-2">{{-- 
                                        <input wire:model='codigo' type="text" name="codigo" id="codigo" required
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"> --}}
                                        <x-input wire:model='codigo' type="number" min="1" step="1"
                                            name="codigo" id="codigo" required class="block w-full" />
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('codigo')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-4">
                                    {{-- <label for="renglon"
                                        class="block text-sm font-medium leading-6 text-gray-900">Renglón</label> --}}
                                    <x-label for="renglon" value="{{ __('Renglón') }}" />
                                    <div class="mt-2">
                                        {{-- <select wire:model='renglon' id="renglon" name="renglon" required
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            <option value="">Seleccionar...</option>
                                            @foreach ($renglones ?? [] as $renglon)
                                                <option value="{{ $renglon->id }}">
                                                    {{ $renglon->renglon }} - {{ $renglon->nombre }}
                                                </option>
                                            @endforeach
                                        </select> --}}
                                        <x-select wire:model='renglon' id="renglon" name="renglon" required
                                            class="block w-full">
                                            <option value="">Seleccionar...</option>
                                            @foreach ($renglones ?? [] as $renglon)
                                                <option value="{{ $renglon->id }}">
                                                    {{ $renglon->renglon }} - {{ $renglon->nombre }}
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
                                    {{-- <label for="puesto"
                                        class="block text-sm font-medium leading-6 text-gray-900">Puesto</label> --}}
                                    <x-label for="puesto" value="{{ __('Puesto') }}" />
                                    <div class="mt-2">
                                        {{-- <input wire:model='puesto' type="text" name="puesto" id="puesto" required
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"> --}}
                                        <x-input wire:model='puesto' type="text" name="puesto" id="puesto"
                                            required class="block w-full" />
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('puesto')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-6">
                                    {{-- <label for="cantidad"
                                        class="block text-sm font-medium leading-6 text-gray-900">Cantidad</label> --}}
                                    <x-label for="cantidad" value="{{ __('Cantidad') }}" />
                                    <div class="mt-2">
                                        {{-- <input wire:model='cantidad' type="number" name="cantidad" id="cantidad"
                                            required min="0" step="1"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"> --}}
                                        <x-input wire:model='cantidad' type="number" name="cantidad" id="cantidad"
                                            required min="1" step="1" class="block w-full" />

                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('cantidad')
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
