<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Renglones presupuestarios') }}
        </h2>
    </x-slot>

    <div class="py-12 h-full">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="mt-2 grid grid-cols-8 gap-x-6 gap-y-8 mb-2">
                <div class="col-end-1">
                    @can('Crear renglones')
                        <button type="button" wire:click="crear"
                            class="inline-block rounded-md bg-primary px-6 pb-2 pt-2.5 text-md font-medium leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-primary-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-primary-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-primary-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                        </button>
                    @endcan

                    @canany(['Crear renglones', 'Editar renglones'])
                        @if ($modal)
                            @include('livewire.renglones.crear')
                        @endif
                    @endcanany
                </div>

                <div class="col-span-8">
                    <div class="relative rounded-md shadow-sm">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <span class="text-gray-500 sm:text-sm"><svg xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                    class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                                </svg>
                            </span>
                        </div>
                        <x-input wire:model.live="busqueda" type="text" name="search" id="search"
                            class="inline-block w-full pl-10" autocomplete="off" placeholder="Buscar" />
                    </div>
                </div>
            </div>
            <div {{-- class="overflow-x-auto" --}}>
                <div class="bg-white dark:bg-gray-800 shadow-xl sm:rounded-md">
                    <table
                        class="min-w-full border-2 border-separate border-spacing-0 text-center shadow-lg rounded-md border-solid border-gray-300 dark:border-gray-800">
                        <thead class="bg-gray-300 dark:bg-gray-800 text-center">
                            <tr class="text-gray-800 dark:text-gray-300">
                                <th class="w-1/12 py-2 px-4">Renglón</th>
                                <th class="w-1/12 py-2 px-4">Asignado</th>
                                <th class="w-1/12 py-2 px-4">Modificaciones</th>
                                <th class="w-1/12 py-2 px-4">Vigente</th>
                                <th class="w-1/12 py-2 px-4">Pre-comprometido</th>
                                <th class="w-1/12 py-2 px-4">Comprometido</th>
                                <th class="w-1/12 py-2 px-4">Devengado</th>
                                <th class="w-1/12 py-2 px-4">Pagado</th>
                                <th class="w-1/12 py-2 px-4">Por comprometer</th>
                                <th class="w-1/12 py-2 px-4">Por devengar</th>
                                <th class="w-1/12 py-2 px-4">Por pagar</th>
                                <th class="w-1/12 py-2 px-4">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-600">
                            @foreach ($renglones as $renglon)
                                <tr
                                    class="text-gray-800 dark:text-gray-200 border-b border-gray-300 dark:border-gray-700">
                                    <td
                                        class="py-2 px-4 {{ $loop->last ? 'border-none' : 'border-b border-gray-200 dark:border-gray-700' }}">
                                        <div class="has-tooltip">
                                            <span
                                                class='tooltip rounded text-xs shadow-lg p-1 bg-gray-100 dark:bg-gray-700 -mt-8'>
                                                {{ $renglon->nombre }}</span>
                                            {{ $renglon->renglon }}
                                        </div>
                                    </td>
                                    <td
                                        class="py-2 px-4 {{ $loop->last ? 'border-none' : 'border-b border-gray-200 dark:border-gray-700' }} {{ $renglon->asignado > 0 ? 'text-success-600' : ($renglon->asignado < 0 ? 'text-danger-600' : '') }}">
                                        {{ 'Q. ' . $renglon->asignado }}</td>
                                    <td
                                        class="py-2 px-4 {{ $loop->last ? 'border-none' : 'border-b border-gray-200 dark:border-gray-700' }} {{ $renglon->modificaciones > 0 ? 'text-success-600' : ($renglon->modificaciones < 0 ? 'text-danger-600' : '') }}">
                                        {{ 'Q. ' . $renglon->modificaciones }}</td>
                                    <td
                                        class="py-2 px-4 {{ $loop->last ? 'border-none' : 'border-b border-gray-200 dark:border-gray-700' }} {{ $renglon->vigente > 0 ? 'text-success-600' : ($renglon->vigente < 0 ? 'text-danger-600' : '') }}">
                                        {{ 'Q. ' . $renglon->vigente }}</td>
                                    <td
                                        class="py-2 px-4 {{ $loop->last ? 'border-none' : 'border-b border-gray-200 dark:border-gray-700' }} {{ $renglon->pre_comprometido > 0 ? 'text-success-600' : ($renglon->pre_comprometido < 0 ? 'text-danger-600' : '') }}">
                                        {{ 'Q. ' . $renglon->pre_comprometido }}</td>
                                    <td
                                        class="py-2 px-4 {{ $loop->last ? 'border-none' : 'border-b border-gray-200 dark:border-gray-700' }} {{ $renglon->comprometido > 0 ? 'text-success-600' : ($renglon->comprometido < 0 ? 'text-danger-600' : '') }}">
                                        {{ 'Q. ' . $renglon->comprometido }}</td>
                                    <td
                                        class="py-2 px-4 {{ $loop->last ? 'border-none' : 'border-b border-gray-200 dark:border-gray-700' }} {{ $renglon->devengado > 0 ? 'text-success-600' : ($renglon->devengado < 0 ? 'text-danger-600' : '') }}">
                                        {{ 'Q. ' . $renglon->devengado }}</td>
                                    <td
                                        class="py-2 px-4 {{ $loop->last ? 'border-none' : 'border-b border-gray-200 dark:border-gray-700' }} {{ $renglon->pagado > 0 ? 'text-success-600' : ($renglon->pagado < 0 ? 'text-danger-600' : '') }}">
                                        {{ 'Q. ' . $renglon->pagado }}</td>
                                    <td
                                        class="py-2 px-4 {{ $loop->last ? 'border-none' : 'border-b border-gray-200 dark:border-gray-700' }} {{ $renglon->saldo_por_comprometer > 0 ? 'text-success-600' : ($renglon->saldo_por_comprometer < 0 ? 'text-danger-600' : '') }}">
                                        {{ 'Q. ' . $renglon->saldo_por_comprometer }}</td>
                                    <td
                                        class="py-2 px-4 {{ $loop->last ? 'border-none' : 'border-b border-gray-200 dark:border-gray-700' }} {{ $renglon->saldo_por_devengar > 0 ? 'text-success-600' : ($renglon->saldo_por_devengar < 0 ? 'text-danger-600' : '') }}">
                                        {{ 'Q. ' . $renglon->saldo_por_devengar }}</td>
                                    <td
                                        class="py-2 px-4 {{ $loop->last ? 'border-none' : 'border-b border-gray-200 dark:border-gray-700' }} {{ $renglon->saldo_por_pagar > 0 ? 'text-success-600' : ($renglon->saldo_por_pagar < 0 ? 'text-danger-600' : '') }}">
                                        {{ 'Q. ' . $renglon->saldo_por_pagar }}</td>
                                    <td
                                        class="py-2 px-4 {{ $loop->last ? 'border-none' : 'border-b border-gray-200 dark:border-gray-700' }}">
                                        <div class="relative" data-te-dropdown-position="dropstart">
                                            <button
                                                class="flex items-center mx-auto whitespace-nowrap rounded bg-gray-400 px-2 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-gray-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-gray-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-gray-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] motion-reduce:transition-none dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]"
                                                type="button" id="dropdownMenuButton{{ $renglon->id }}"
                                                data-te-dropdown-toggle-ref aria-expanded="false" data-te-ripple-init
                                                data-te-ripple-color="light">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                            </button>
                                            <ul class="absolute z-[1000] left-0 top-full m-0 hidden list-none rounded-lg border-none bg-gray-200 bg-clip-padding text-center text-base shadow-lg dark:bg-neutral-700 [&[data-te-dropdown-show]]:block overflow-y-auto"
                                                aria-labelledby="dropdownMenuButton{{ $renglon->id }}"
                                                data-te-dropdown-menu-ref>
                                                @can('Editar renglones')
                                                    <li>
                                                        <button type="button" wire:click='editar({{ $renglon->id }})'
                                                            class="block w-full whitespace-nowrap bg-transparent px-4 py-2 text-sm font-normal text-neutral-700 hover:bg-neutral-100 active:text-neutral-800 active:no-underline disabled:pointer-events-none disabled:bg-transparent disabled:text-neutral-400 dark:text-neutral-200 dark:hover:bg-neutral-600"
                                                            data-te-dropdown-item-ref>
                                                            <div class="flex items-end space-x-2">
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                    viewBox="0 0 24 24" stroke-width="1.5"
                                                                    stroke="currentColor" class="w-5 h-5">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                                </svg>
                                                                <h6
                                                                    class="text-sm font-normal text-neutral-700 dark:text-gray-200">
                                                                    Editar
                                                                </h6>
                                                            </div>
                                                        </button>
                                                    </li>
                                                @endcan
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="mt-2">
                {{ $renglones->links() }}
            </div>
            <div wire:loading.flex wire:target="guardar"
                class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50">
                <div class="animate-spin rounded-full h-32 w-32 border-t-4 border-b-4 border-[#FF921F] bg-transparent">
                </div>
            </div>
        </div>
    </div>
</div>
