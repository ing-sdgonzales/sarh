<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Expediente') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-200">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="mt-2 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6 mb-2">
                <div class="sm:col-span-6 mx-auto">
                    <img src="{{ asset('storage') . '/' . $candidato->imagen }}" class="mx-auto max-w-full rounded-lg"
                        style="height: 150px" alt="imagen" />
                    <label class="block text-sm font-medium leading-6 text-gray-900">{{ $candidato->nombre }}</label>
                </div>
                <div class="sm:col-span-6">
                    <div>
                        <div class="mb-4">
                            <p>Porcentaje de requisitos presentados: {{ $total_requisitos_cargados }} de
                                {{ $total_requisitos }}</p>
                            @if ($porcentaje_requisitos_presentados == 0)
                                <div class="w-full h-5 bg-gray-200 rounded">
                                    <div class="h-full bg-blue-500 rounded text-center align-middle text-sm"
                                        style="width: {{ $porcentaje_requisitos_presentados }}%">
                                        {{ $porcentaje_requisitos_presentados }}%</div>
                                </div>
                            @else
                                <div class="w-full h-5 bg-gray-200 rounded">
                                    <div class="h-full bg-blue-500 rounded text-center align-middle text-white text-sm"
                                        style="width: {{ $porcentaje_requisitos_presentados }}%">
                                        {{ $porcentaje_requisitos_presentados }}%</div>
                                </div>
                            @endif
                        </div>
                        <div>
                            <p>Porcentaje de requisitos aprobados: {{ $total_requisitos_aprobados }} de
                                {{ $total_requisitos }}</p>
                            @if ($porcentaje_requisitos_aprobados == 0)
                                <div class="w-full h-5 bg-gray-200 rounded">
                                    <div class="h-full bg-green-500 rounded text-center align-middle text-sm"
                                        style="width: {{ $porcentaje_requisitos_aprobados }}%">
                                        {{ $porcentaje_requisitos_aprobados }}%</div>
                                </div>
                            @else
                                <div class="w-full h-5 bg-gray-200 rounded">
                                    <div class="h-full bg-green-500 rounded text-center align-middle text-white text-sm"
                                        style="width: {{ $porcentaje_requisitos_aprobados }}%">
                                        {{ $porcentaje_requisitos_aprobados }}%</div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="sm:col-span-2">
                    <div class="mt-2">
                        <select wire:model='puesto' id="puesto" name="puesto" wire:change='getRequisitosByPuesto'
                            required style="height: 42px;"
                            class="block w-full rounded-lg border-0 py-1.5 text-gray-900 shadow-md ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            <option value="">Seleccionar aplicación...</option>
                            @foreach ($puestos as $puesto)
                                <option value="{{ $puesto->id }}">
                                    {{ $puesto->puesto }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="sm:col-span-4">
                    <div class="mt-2 w-full text-right items-baseline">
                        @can('Ver etapas')
                            <a type="button" href="{{ route('proceso', ['id_candidato' => $id_candidato]) }}">
                                <div
                                    class="inline-block rounded-lg bg-success px-6 pb-2 pt-2.5 text-md font-medium leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-success-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-success-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-success-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]">
                                    {{ __('Progreso') }}
                                </div>
                            </a>
                        @endcan
                        @can('Notificar requisitos')
                            <button type="button" wire:click="notificar()"
                                @if ($notificar == false) disabled @endif
                                class=" @if ($notificar == false) pointer-events-none @endif inline-block rounded-lg bg-primary px-6 pb-2 pt-2.5 text-md font-medium leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-primary-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-primary-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-primary-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] disabled:opacity-60 dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]">
                                {{ __('Notificar') }}
                            </button>
                        @endcan
                    </div>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <table class="min-w-full bg-white rounded-lg overflow-hidden text-center">
                    <thead class="bg-gray-100 text-center">
                        <tr>
                            <th class="w-1/12 py-2 px-4">No.</th>
                            <th class="w-1/6 py-2 px-4">Requisito</th>
                            <th class="w-1/4 py-2 px-4">Especificación</th>
                            <th class="w-1/12 py-2 px-4">Presentado</th>
                            <th class="w-1/12 py-2 px-4">Revisión</th>
                            <th class="w-1/12 py-2 px-4">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($requisitos as $req)
                            <tr>
                                <td class="py-2 px-4">{{ $loop->iteration }}.</td>
                                <td class="py-2 px-4">{{ $req->requisito }}</td>
                                <td class="py-2 px-4">{{ $req->especificacion }}</td>
                                @if ($req->fecha_carga != null)
                                    <td class="py-2 px-4">{{ date('d-m-Y H:i:s', strtotime($req->fecha_carga)) }}</td>
                                @else
                                    <td>
                                        <span
                                            class="inline-block whitespace-nowrap rounded-[0.27rem] bg-yellow-400 px-[0.65em] pb-[0.25em] pt-[0.35em] text-center text-md align-baseline text-[0.75em] font-bold leading-none text-yellow-800">
                                            Pendiente de adjuntar</span>
                                    </td>
                                @endif
                                @if ($req->valido == 1 && $req->revisado == 1)
                                    <td>
                                        <span
                                            class="inline-block whitespace-nowrap rounded-[0.27rem] bg-success-400 px-[0.65em] pb-[0.25em] pt-[0.35em] text-center text-md align-baseline text-[0.75em] font-bold leading-none text-success-800">
                                            {{ date('d-m-Y H:i:s', strtotime($req->fecha_revision)) }}</span>
                                    </td>
                                @elseif ($req->valido == 0 && $req->revisado == 1)
                                    <td>
                                        <span
                                            class="inline-block whitespace-nowrap rounded-[0.27rem] bg-red-400 px-[0.65em] pb-[0.25em] pt-[0.35em] text-center text-md align-baseline text-[0.75em] font-bold leading-none text-red-800">
                                            {{ date('d-m-Y H:i:s', strtotime($req->fecha_revision)) }}</span>
                                    </td>
                                @else
                                    <td>
                                        <span
                                            class="inline-block whitespace-nowrap rounded-[0.27rem] bg-yellow-400 px-[0.65em] pb-[0.25em] pt-[0.35em] text-center text-md align-baseline text-[0.75em] font-bold leading-none text-yellow-800">
                                            Pendiente de revisar</span>
                                    </td>
                                @endif
                                <td class="py-2 px-4">
                                    @if ($req->fecha_carga)
                                        <div class="relative" data-te-dropdown-position="dropstart">
                                            <button
                                                class="flex items-center mx-auto whitespace-nowrap rounded bg-gray-400 px-2 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-gray-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-gray-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-gray-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] motion-reduce:transition-none dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]"
                                                type="button" id="dropdownMenuButton{{ $req->id }}"
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
                                            @if (Str::startsWith($req->requisito, 'Formulario'))
                                                <ul class="absolute z-[1000] left-0 top-full m-0 hidden h-auto list-none rounded-lg border-none bg-gray-200 bg-clip-padding text-center text-base shadow-lg dark:bg-neutral-700 [&[data-te-dropdown-show]]:block"
                                                    aria-labelledby="dropdownMenuButton{{ $req->id }}"
                                                    data-te-dropdown-menu-ref>
                                                    @can('Ver formulario')
                                                        <li>
                                                            <a href="{{ route('formulario', ['id_candidato' => $req->candidatos_id, 'id_requisito' => $req->id]) }}"
                                                                type="button"
                                                                class="block w-full whitespace-nowrap bg-transparent px-4 py-2 text-sm font-normal text-neutral-700 hover:bg-neutral-100 active:text-neutral-800 active:no-underline disabled:pointer-events-none disabled:bg-transparent disabled:text-neutral-400 dark:text-neutral-200 dark:hover:bg-neutral-600">
                                                                <div class="flex items-end space-x-2">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                        viewBox="0 0 24 24" stroke-width="1.5"
                                                                        stroke="currentColor" class="w-5 h-5">
                                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                                            d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                                                    </svg>
                                                                    <h6 class="text-sm font-normal text-neutral-700">
                                                                        Formulario
                                                                    </h6>
                                                                </div>
                                                            </a>
                                                        </li>
                                                    @endcan
                                                </ul>
                                            @else
                                                <ul class="absolute z-[1000] left-0 top-full m-0 hidden h-auto list-none rounded-lg border-none bg-gray-200 bg-clip-padding text-center text-base shadow-lg dark:bg-neutral-700 [&[data-te-dropdown-show]]:block"
                                                    aria-labelledby="dropdownMenuButton{{ $req->id }}"
                                                    data-te-dropdown-menu-ref>
                                                    @can('Verificar requisitos')
                                                        <li>
                                                            <button type="button"
                                                                wire:click='verificarRequisito({{ $req->id }})'
                                                                class="block w-full whitespace-nowrap bg-transparent px-4 py-2 text-sm font-normal text-neutral-700 hover:bg-neutral-100 active:text-neutral-800 active:no-underline disabled:pointer-events-none disabled:bg-transparent disabled:text-neutral-400 dark:text-neutral-200 dark:hover:bg-neutral-600"
                                                                data-te-dropdown-item-ref>
                                                                <div class="flex items-end space-x-2">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                        viewBox="0 0 24 24" stroke-width="1.5"
                                                                        stroke="currentColor" class="w-5 h-5">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round"
                                                                            d="M4.5 12.75l6 6 9-13.5" />
                                                                    </svg>
                                                                    <h6 class="text-sm font-normal text-neutral-700">
                                                                        Verificar
                                                                    </h6>
                                                                </div>
                                                            </button>
                                                        </li>
                                                    @endcan
                                                </ul>
                                            @endif
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div wire:loading.flex wire:target="notificar"
                    class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50">
                    <div
                        class="animate-spin rounded-full h-32 w-32 border-t-4 border-b-4 border-indigo-50 bg-transparent">
                    </div>
                </div>
                <div wire:loading.flex wire:target="aprobar"
                    class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50">
                    <div
                        class="animate-spin rounded-full h-32 w-32 border-t-4 border-b-4 border-indigo-50 bg-transparent">
                    </div>
                </div>
                <div wire:loading.flex wire:target="rechazarFormulario"
                    class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50">
                    <div
                        class="animate-spin rounded-full h-32 w-32 border-t-4 border-b-4 border-indigo-50 bg-transparent">
                    </div>
                </div>
            </div>
        </div>
    </div>
    @can('Verificar requisitos')
        @if ($modal)
            @include('livewire.requisitos.verificar')
        @endif
    @endcan

    @push('js')
        @if (session()->has('message'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: '¡Operación completada con éxito!',
                    showConfirmButton: false,
                    timer: 2000
                })
            </script>
        @endif
    @endpush
</div>
