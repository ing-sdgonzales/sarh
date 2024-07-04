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
                                    <x-label for="renglon" value="{{ __('Renglón') }}" />
                                    <div class="mt-2">
                                        <x-input wire:model='renglon' type="text" name="renglon" id="renglon"
                                            required class="block w-full" />
                                        <div>
                                            <span class="text-red-600 text-sm">
                                                @error('renglon')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="sm:col-span-full">
                                    <x-label for="nombre" value="{{ __('Nombre') }}" />
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
                                    <x-label for="asignado" value="{{ __('Asignado') }}" />
                                    <div class="mt-2 relative">
                                        <span
                                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm dark:text-gray-200">Q</span>
                                        </span>
                                        <x-input wire:model='asignado' type="number" name="asignado" id="asignado"
                                            required class="block w-full pl-7" step='0.01' />
                                        <div>
                                            <span class="text-red-600 text-sm">
                                                @error('asignado')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="sm:col-span-full">
                                    <x-label for="modificaciones" value="{{ __('Modificaciones') }}" />
                                    <div class="mt-2 relative">
                                        <span
                                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm dark:text-gray-200">Q</span>
                                        </span>
                                        <x-input wire:model='modificaciones' type="number" name="modificaciones"
                                            id="modificaciones" required class="block w-full pl-7" step='0.01' />
                                        <div>
                                            <span class="text-red-600 text-sm">
                                                @error('modificaciones')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="sm:col-span-full">
                                    <x-label for="vigente" value="{{ __('Vigente') }}" />
                                    <div class="mt-2 relative">
                                        <span
                                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm dark:text-gray-200">Q</span>
                                        </span>
                                        <x-input wire:model='vigente' type="number" name="vigente" id="vigente"
                                            required class="block w-full pl-7" step='0.01' />
                                        <div>
                                            <span class="text-red-600 text-sm">
                                                @error('vigente')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="sm:col-span-full">
                                    <x-label for="pre_comprometido" value="{{ __('Pre-comprometido') }}" />
                                    <div class="mt-2 relative">
                                        <span
                                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm dark:text-gray-200">Q</span>
                                        </span>
                                        <x-input wire:model='pre_comprometido' type="number" name="pre_comprometido"
                                            id="pre_comprometido" required class="block w-full pl-7" step='0.01' />
                                        <div>
                                            <span class="text-red-600 text-sm">
                                                @error('pre_comprometido')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="sm:col-span-full">
                                    <x-label for="comprometido" value="{{ __('Comprometido') }}" />
                                    <div class="mt-2 relative">
                                        <span
                                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm dark:text-gray-200">Q</span>
                                        </span>
                                        <x-input wire:model='comprometido' type="number" name="comprometido"
                                            id="comprometido" required class="block w-full pl-7" step='0.01' />
                                        <div>
                                            <span class="text-red-600 text-sm">
                                                @error('comprometido')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="sm:col-span-full">
                                    <x-label for="devengado" value="{{ __('Devengado') }}" />
                                    <div class="mt-2 relative">
                                        <span
                                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm dark:text-gray-200">Q</span>
                                        </span>
                                        <x-input wire:model='devengado' type="number" name="devengado"
                                            id="devengado" required class="block w-full pl-7" step='0.01' />
                                        <div>
                                            <span class="text-red-600 text-sm">
                                                @error('devengado')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="sm:col-span-full">
                                    <x-label for="pagado" value="{{ __('Pagado') }}" />
                                    <div class="mt-2 relative">
                                        <span
                                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm dark:text-gray-200">Q</span>
                                        </span>
                                        <x-input wire:model='pagado' type="number" name="pagado" id="pagado"
                                            required class="block w-full pl-7" step='0.01' />
                                        <div>
                                            <span class="text-red-600 text-sm">
                                                @error('pagado')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="sm:col-span-full">
                                    <x-label for="saldo_por_comprometer" value="{{ __('Saldo por comprometer') }}" />
                                    <div class="mt-2 relative">
                                        <span
                                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm dark:text-gray-200">Q</span>
                                        </span>
                                        <x-input wire:model='saldo_por_comprometer' type="number"
                                            name="saldo_por_comprometer" id="saldo_por_comprometer" required
                                            class="block w-full pl-7" step='0.01' />
                                        <div>
                                            <span class="text-red-600 text-sm">
                                                @error('saldo_por_comprometer')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="sm:col-span-full">
                                    <x-label for="saldo_por_devengar" value="{{ __('Saldo por devengar') }}" />
                                    <div class="mt-2 relative">
                                        <span
                                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm dark:text-gray-200">Q</span>
                                        </span>
                                        <x-input wire:model='saldo_por_devengar' type="number"
                                            name="saldo_por_devengar" id="saldo_por_devengar" required
                                            class="block w-full pl-7" step='0.01' />
                                        <div>
                                            <span class="text-red-600 text-sm">
                                                @error('saldo_por_devengar')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="sm:col-span-full">
                                    <x-label for="saldo_por_pagar" value="{{ __('Saldo por pagar') }}" />
                                    <div class="mt-2 relative">
                                        <span
                                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm dark:text-gray-200">Q</span>
                                        </span>
                                        <x-input wire:model='saldo_por_pagar' type="number" name="saldo_por_pagar"
                                            id="saldo_por_pagar" required class="block w-full pl-7" step='0.01' />
                                        <div>
                                            <span class="text-red-600 text-sm">
                                                @error('saldo_por_pagar')
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
