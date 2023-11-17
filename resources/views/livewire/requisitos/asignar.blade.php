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
                <button type="button" wire:click='cerrarModalAsignar()'
                    class="box-content rounded-none border-none hover:no-underline hover:opacity-75 focus:opacity-100 focus:shadow-none focus:outline-none"
                    aria-label="Close">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!--Modal body-->
            <div class="relative p-4">
                <form method="POST">
                    @csrf
                    <div class="space-y-12">
                        <div class="border-b border-gray-900/10 pb-6">
                            <h2 class="text-base font-semibold leading-7 text-gray-900">Requisitos</h2>
                            <div class="mt-2 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                                <div class="sm:col-span-6">
                                    <label for="puesto_requisitos"
                                        class="block text-sm font-medium leading-6 text-gray-900">Puesto</label>
                                    <div class="mt-2">
                                        <input type="text" name="puesto_requisitos" readonly id="puesto_requisitos"
                                            value="{{ $puesto_requisitos->cod_puesto }} - {{ $puesto_requisitos->cod_catalogo }} - {{ $puesto_requisitos->puesto }}"
                                            class="block w-full rounded-md text-center border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>
                                <div class="sm:col-span-6">
                                    <table
                                        class="min-w-full bg-white rounded-lg overflow-hidden text-center ring-1 ring-gray-300">
                                        <thead class="bg-gray-100 text-center">
                                            <tr>
                                                <th class="w-1/12 py-2 px-4">No.</th>
                                                <th class="w-1/3 py-2 px-4">Requisito</th>
                                                <th class="w-1/3 py-2 px-4">Especificación</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($requisitos as $req)
                                                <tr>
                                                    <td class="py-2 px-4 items-center">
                                                        <div class="relative flex gap-x-2">
                                                            {{ $loop->iteration }}.
                                                            <div class="flex h-6 items-center">
                                                                <input wire:model='requisito' type="checkbox"
                                                                    id="requisito-{{ $req->id }}"
                                                                    value="{{ $req->id }}"
                                                                    class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600">
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="py-2 px-4"><label for="requisito-{{ $req->id }}">
                                                            {{ $req->requisito }}</label></td>
                                                    <td class="py-2 px-4">{{ $req->especificacion }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="mt-2">
                                {{ $requisitos->links() }}
                            </div>
                        </div>
                    </div>
                    {{-- <div class="mt-6 flex items-center justify-end gap-x-6">
                            <button type="button"
                                class="text-sm font-semibold leading-6 text-gray-900">{{ __('Cancel') }}</button>
                            <button type="submit"
                                class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">{{ __('Save') }}</button>
                        </div> --}}
                </form>
            </div>
            <div wire:loading.flex wire:target="guardarRequisitos"
                class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50">
                <div class="animate-spin rounded-full h-32 w-32 border-t-4 border-b-4 border-indigo-50 bg-transparent">
                </div>
            </div>

            <!--Modal footer-->
            <div
                class="flex flex-shrink-0 flex-wrap items-center justify-end rounded-b-md border-t-2 border-neutral-100 border-opacity-100 p-4 dark:border-opacity-50">
                <button type="button" wire:click='cerrarModalAsignar()'
                    class="inline-block rounded-lg bg-danger-200 px-6 pb-2 pt-2.5 font-medium leading-normal text-danger-700 transition duration-150 ease-in-out hover:bg-red-400 focus:bg-red-accent-100 focus:outline-none focus:ring-0 active:bg-primary-accent-200"
                    data-te-ripple-init data-te-ripple-color="light">
                    {{ __('Cancel') }}
                </button>
                <button type="submit" wire:click='guardarRequisitos()'
                    class="ml-1 inline-block rounded-lg bg-primary px-6 pb-2 pt-2.5 font-medium leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-primary-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-primary-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-primary-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]"
                    data-te-ripple-init data-te-ripple-color="light">
                    {{ __('Save') }}
                </button>
            </div>
        </div>
    </div>
</div>
