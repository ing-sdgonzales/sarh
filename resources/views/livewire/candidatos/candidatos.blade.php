<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Candidatos') }}
        </h2>
    </x-slot>
    <div class="py-12 bg-gray-200 h-screen">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-2">
                @can('Crear candidatos')
                    <button type="button" wire:click="crear()"
                        class="inline-block rounded-lg bg-primary px-6 pb-2 pt-2.5 text-md font-medium leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-primary-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-primary-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-primary-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                    </button>
                @endcan

                @canany(['Crear candidatos', 'Editar candidatos'])
                    @if ($modal)
                        @include('livewire.candidatos.crear')
                    @endif
                @endcanany

                @can('Registrar Entrevista')
                    @if ($entrevista_modal)
                        @include('livewire.candidatos.entrevista')
                    @endif
                @endcan

                @can('Aprobar expedientes')
                    @if ($modal_aprobar_expediente)
                        @include('livewire.etapas.entrega_expediente')
                    @endif
                @endcan

                @can('Crear pruebas técnicas')
                    @if ($modal_prueba_tecnica)
                        @include('livewire.etapas.prueba_tecnica')
                    @endif
                @endcan

                @can('Crear pruebas técnicas')
                    @if ($modal_prueba_psicometrica)
                        @include('livewire.etapas.prueba_psicometrica')
                    @endif
                @endcan

                @can('Crear informes de evaluación')
                    @if ($modal_informe_evaluacion)
                        @include('livewire.etapas.informe_evaluacion')
                    @endif
                @endcan

                @can('Asignar fechas de ingresos')
                    @if ($modal_fecha_ingreso)
                        @include('livewire.etapas.fecha_ingreso')
                    @endif
                @endcan

            </div>
            <div class="bg-white dark:bg-gray-800 shadow-xl sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white rounded-lg text-center">
                        <thead class="bg-gray-100 text-center">
                            <tr>
                                <th class="w-1/12 py-2 px-4">Renglón</th>
                                <th class="w-1/12 py-2 px-4">Foto</th>
                                <th class="w-1/6 py-2 px-4">Nombre</th>
                                <th class="w-1/6 py-2 px-4">Dependencia</th>
                                <th class="w-1/6 py-2 px-4">Servicio</th>
                                <th class="w-1/4 py-2 px-4">Profesión</th>
                                <th class="w-1/4 py-2 px-4">Región</th>
                                <th class="w-1/12 py-2 px-4">Estado</th>
                                <th class="w-1/4 py-2 px-4">Contratación</th>
                                <th class="w-1/4 py-2 px-4">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($candidatos as $candidato)
                                <tr>
                                    <td class="py-2 px-4">{{ $candidato->renglon }}</td>
                                    <td class="py-2 px-4"><img src="{{ asset('storage') . '/' . $candidato->imagen }}"
                                            class="mx-auto max-w-full rounded-lg" style="height: 60px; width: 60px"
                                            alt="imagen" />
                                    </td>
                                    <td class="py-2 px-4">{{ $candidato->nombre }}</td>
                                    <td class="py-2 px-4">{{ $candidato->dependencia }}</td>
                                    <td class="py-2 px-4">{{ $candidato->tipo_servicio }}</td>
                                    <td class="py-2 px-4">{{ $candidato->profesion }}</td>
                                    <td class="py-2 px-4">{{ $candidato->region }}</td>
                                    <td class="py-2 px-4">
                                        @if ($candidato->estado == 0)
                                            <span
                                                class="inline-block whitespace-nowrap rounded-[0.27rem] bg-yellow-400 px-[0.65em] pb-[0.25em] pt-[0.35em] text-center text-md align-baseline text-[0.75em] font-bold leading-none text-yellow-800">Pendiente
                                                de entrevista</span>
                                        @elseif ($candidato->estado == 1)
                                            <span
                                                class="inline-block whitespace-nowrap rounded-[0.27rem] bg-success-400 px-[0.65em] pb-[0.25em] pt-[0.35em] text-center text-md align-baseline text-[0.75em] font-bold leading-none text-succes-800">En
                                                proceso de contratación</span>
                                        @else
                                            <span
                                                class="inline-block whitespace-nowrap rounded-[0.27rem] bg-gray-400 px-[0.65em] pb-[0.25em] pt-[0.35em] text-center text-md align-baseline text-[0.75em] font-bold leading-none text-gray-800">Sin
                                                efectos</span>
                                        @endif
                                    </td>
                                    <td class="py-2 px-4">{{ $candidato->tipo_contratacion }}</td>
                                    <td class="py-2 px-4">
                                        <div class="relative" data-te-dropdown-position="dropstart">
                                            <button
                                                class="flex items-center mx-auto whitespace-nowrap rounded bg-gray-400 px-2 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-gray-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-gray-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-gray-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] motion-reduce:transition-none dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]"
                                                type="button" id="dropdownMenuButton{{ $candidato->id }}"
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
                                                aria-labelledby="dropdownMenuButton{{ $candidato->id }}"
                                                data-te-dropdown-menu-ref>
                                                @can('Editar candidatos')
                                                    <li>
                                                        <button type="button" wire:click='editar({{ $candidato->id }})'
                                                            class="block w-full whitespace-nowrap bg-transparent px-4 py-2 text-sm font-normal text-neutral-700 hover:bg-neutral-100 active:text-neutral-800 active:no-underline disabled:pointer-events-none disabled:bg-transparent disabled:text-neutral-400 dark:text-neutral-200 dark:hover:bg-neutral-600"
                                                            data-te-dropdown-item-ref>
                                                            <div class="flex items-end space-x-2">
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                    viewBox="0 0 24 24" stroke-width="1.5"
                                                                    stroke="currentColor" class="w-5 h-5">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                                </svg>
                                                                <h6 class="text-sm font-normal text-neutral-700">Editar</h6>
                                                            </div>
                                                        </button>
                                                    </li>
                                                @endcan
                                                @can('Registrar entrevista')
                                                    <li>
                                                        <button type="button"
                                                            wire:click='crearEntrevista({{ $candidato->id }})'
                                                            class="block w-full whitespace-nowrap bg-transparent px-4 py-2 text-sm font-normal text-neutral-700 hover:bg-neutral-100 active:text-neutral-800 active:no-underline disabled:pointer-events-none disabled:bg-transparent disabled:text-neutral-400 dark:text-neutral-200 dark:hover:bg-neutral-600"
                                                            data-te-dropdown-item-ref>
                                                            <div class="flex items-end space-x-2">
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                    viewBox="0 0 24 24" stroke-width="1.5"
                                                                    stroke="currentColor" class="w-5 h-5">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 01-.825-.242m9.345-8.334a2.126 2.126 0 00-.476-.095 48.64 48.64 0 00-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0011.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155" />
                                                                </svg>

                                                                <h6 class="text-sm font-normal text-neutral-700">Registrar
                                                                    entrevista</h6>
                                                            </div>
                                                        </button>
                                                    </li>
                                                @endcan
                                                @if ($candidato->estado == 1)
                                                    @can('Ver expediente')
                                                        <li>
                                                            <a type="button"
                                                                href="{{ route('expedientes', ['candidato_id' => $candidato->id]) }}"
                                                                class="block w-full whitespace-nowrap bg-transparent px-4 py-2 text-sm font-normal text-neutral-700 hover:bg-neutral-100 active:text-neutral-800 active:no-underline disabled:pointer-events-none disabled:bg-transparent disabled:text-neutral-400 dark:text-neutral-200 dark:hover:bg-neutral-600"
                                                                data-te-dropdown-item-ref>
                                                                <div class="flex items-end space-x-2">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                        viewBox="0 0 24 24" stroke-width="1.5"
                                                                        stroke="currentColor" class="w-5 h-5">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round"
                                                                            d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
                                                                    </svg>

                                                                    <h6 class="text-sm font-normal text-neutral-700">
                                                                        Expediente
                                                                    </h6>
                                                                </div>
                                                            </a>
                                                        </li>
                                                    @endcan
                                                    @if ($candidato->conteo_etapas == 2)
                                                        @can('Aprobar expedientes')
                                                            <li>
                                                                <button type="button"
                                                                    wire:click='entregaExpediente({{ $candidato->id }}, {{ $candidato->id_puesto }})'
                                                                    class="block w-full whitespace-nowrap bg-transparent px-4 py-2 text-sm font-normal text-neutral-700 hover:bg-neutral-100 active:text-neutral-800 active:no-underline disabled:pointer-events-none disabled:bg-transparent disabled:text-neutral-400 dark:text-neutral-200 dark:hover:bg-neutral-600"
                                                                    data-te-dropdown-item-ref>
                                                                    <div class="flex items-end space-x-2">
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            fill="none" viewBox="0 0 24 24"
                                                                            stroke-width="1.5" stroke="currentColor"
                                                                            class="w-5 h-5">
                                                                            <path stroke-linecap="round"
                                                                                stroke-linejoin="round"
                                                                                d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 01-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 011.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 00-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 01-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 00-3.375-3.375h-1.5a1.125 1.125 0 01-1.125-1.125v-1.5a3.375 3.375 0 00-3.375-3.375H9.75" />
                                                                        </svg>
                                                                        <h6 class="text-sm font-normal text-neutral-700">
                                                                            Aprobar
                                                                            expediente
                                                                        </h6>
                                                                    </div>
                                                                </button>
                                                            </li>
                                                        @endcan
                                                    @endif
                                                    @if ($candidato->conteo_etapas >= 3)
                                                        @can('Crear pruebas técnicas')
                                                            <li>
                                                                <button type="button"
                                                                    wire:click='pruebasTecnicas({{ $candidato->id }}, {{ $candidato->id_puesto }})'
                                                                    class="block w-full whitespace-nowrap bg-transparent px-4 py-2 text-sm font-normal text-neutral-700 hover:bg-neutral-100 active:text-neutral-800 active:no-underline disabled:pointer-events-none disabled:bg-transparent disabled:text-neutral-400 dark:text-neutral-200 dark:hover:bg-neutral-600"
                                                                    data-te-dropdown-item-ref>
                                                                    <div class="flex items-end space-x-2">
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            fill="none" viewBox="0 0 24 24"
                                                                            stroke-width="1.5" stroke="currentColor"
                                                                            class="w-5 h-5">
                                                                            <path stroke-linecap="round"
                                                                                stroke-linejoin="round"
                                                                                d="M6.75 7.5l3 2.25-3 2.25m4.5 0h3m-9 8.25h13.5A2.25 2.25 0 0021 18V6a2.25 2.25 0 00-2.25-2.25H5.25A2.25 2.25 0 003 6v12a2.25 2.25 0 002.25 2.25z" />
                                                                        </svg>
                                                                        <h6 class="text-sm font-normal text-neutral-700">
                                                                            Pruebas
                                                                            técnicas
                                                                        </h6>
                                                                    </div>
                                                                </button>
                                                            </li>
                                                        @endcan
                                                    @endif
                                                    @if ($candidato->conteo_etapas >= 4)
                                                        @can('Crear pruebas psicométricas')
                                                            <li>
                                                                <button type="button"
                                                                    wire:click='pruebasPsicometricas({{ $candidato->id }}, {{ $candidato->id_puesto }})'
                                                                    class="block w-full whitespace-nowrap bg-transparent px-4 py-2 text-sm font-normal text-neutral-700 hover:bg-neutral-100 active:text-neutral-800 active:no-underline disabled:pointer-events-none disabled:bg-transparent disabled:text-neutral-400 dark:text-neutral-200 dark:hover:bg-neutral-600"
                                                                    data-te-dropdown-item-ref>
                                                                    <div class="flex items-end space-x-2">
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            fill="none" viewBox="0 0 24 24"
                                                                            stroke-width="1.5" stroke="currentColor"
                                                                            class="w-5 h-5">
                                                                            <path stroke-linecap="round"
                                                                                stroke-linejoin="round"
                                                                                d="M2.25 7.125C2.25 6.504 2.754 6 3.375 6h6c.621 0 1.125.504 1.125 1.125v3.75c0 .621-.504 1.125-1.125 1.125h-6a1.125 1.125 0 01-1.125-1.125v-3.75zM14.25 8.625c0-.621.504-1.125 1.125-1.125h5.25c.621 0 1.125.504 1.125 1.125v8.25c0 .621-.504 1.125-1.125 1.125h-5.25a1.125 1.125 0 01-1.125-1.125v-8.25zM3.75 16.125c0-.621.504-1.125 1.125-1.125h5.25c.621 0 1.125.504 1.125 1.125v2.25c0 .621-.504 1.125-1.125 1.125h-5.25a1.125 1.125 0 01-1.125-1.125v-2.25z" />
                                                                        </svg>
                                                                        <h6 class="text-sm font-normal text-neutral-700">
                                                                            Pruebas
                                                                            psicométricas
                                                                        </h6>
                                                                    </div>
                                                                </button>
                                                            </li>
                                                        @endcan
                                                    @endif
                                                    @if ($candidato->conteo_etapas >= 5)
                                                        @can('Crear informes de evaluación')
                                                            <li>
                                                                <button type="button"
                                                                    wire:click='informeEvaluacion({{ $candidato->id }}, {{ $candidato->id_puesto }})'
                                                                    class="block w-full whitespace-nowrap bg-transparent px-4 py-2 text-sm font-normal text-neutral-700 hover:bg-neutral-100 active:text-neutral-800 active:no-underline disabled:pointer-events-none disabled:bg-transparent disabled:text-neutral-400 dark:text-neutral-200 dark:hover:bg-neutral-600"
                                                                    data-te-dropdown-item-ref>
                                                                    <div class="flex items-end space-x-2">
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            fill="none" viewBox="0 0 24 24"
                                                                            stroke-width="1.5" stroke="currentColor"
                                                                            class="w-5 h-5">
                                                                            <path stroke-linecap="round"
                                                                                stroke-linejoin="round"
                                                                                d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z" />
                                                                        </svg>

                                                                        <h6 class="text-sm font-normal text-neutral-700">
                                                                            Informe de evaluación
                                                                        </h6>
                                                                    </div>
                                                                </button>
                                                            </li>
                                                        @endcan
                                                    @endif
                                                    @if ($candidato->conteo_etapas >= 6)
                                                        @can('Asignar fechas de ingresos')
                                                            <li>
                                                                <button type="button"
                                                                    wire:click='fechaIngreso({{ $candidato->id }}, {{ $candidato->id_puesto }})'
                                                                    class="block w-full whitespace-nowrap bg-transparent px-4 py-2 text-sm font-normal text-neutral-700 hover:bg-neutral-100 active:text-neutral-800 active:no-underline disabled:pointer-events-none disabled:bg-transparent disabled:text-neutral-400 dark:text-neutral-200 dark:hover:bg-neutral-600"
                                                                    data-te-dropdown-item-ref>
                                                                    <div class="flex items-end space-x-2">
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            fill="none" viewBox="0 0 24 24"
                                                                            stroke-width="1.5" stroke="currentColor"
                                                                            class="w-5 h-5">
                                                                            <path stroke-linecap="round"
                                                                                stroke-linejoin="round"
                                                                                d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                                                                        </svg>

                                                                        <h6 class="text-sm font-normal text-neutral-700">
                                                                            Fecha de ingreso
                                                                        </h6>
                                                                    </div>
                                                                </button>
                                                            </li>
                                                        @endcan
                                                    @endif
                                                @endif
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
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
        {{-- Error en crear nuevo registro --}}
        @if (session()->has('error'))
            <script>
                Swal.fire({
                    icon: 'error',
                    title: '¡Ups!',
                    html: `<?php echo session('error'); ?>`
                })
            </script>
        @endif

        {{-- Validación de campos --}}
        @if ($errors->any())
            <script>
                Swal.fire({
                    icon: 'error',
                    title: '¡Ups!',
                    html: `<small class="text-danger"><?php echo implode('<br>', $errors->all()); ?></small>`
                })
            </script>
        @endif
    @endpush
</div>
