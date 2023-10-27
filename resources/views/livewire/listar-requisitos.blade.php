<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Presentar requisitos') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-200">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="mt-2 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6 mb-2">
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
                            required
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
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
                    <div class="mt-2 w-full text-right">
                        <button type="button" wire:click="guardar()"
                            class="inline-block rounded-lg bg-primary px-6 pb-2 pt-2.5 text-md font-medium leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-primary-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-primary-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-primary-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]">
                            {{ __('Save') }}
                        </button>
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
                            <th class="w-1/12 py-2 px-4">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($requisitos as $req)
                            <tr>
                                <td class="py-2 px-4">{{ $loop->iteration }}.</td>
                                <td class="py-2 px-4">{{ $req->requisito }}</td>
                                <td class="py-2 px-4">{{ $req->especificacion }}</td>
                                <td class="py-2 px-4">
                                    <div>
                                        @if ($req->fecha_carga && $req->fecha_revision == null)
                                            <span
                                                class="inline-block whitespace-nowrap rounded-[0.27rem] bg-yellow-400 px-[0.65em] pb-[0.25em] pt-[0.35em] text-center text-md align-baseline text-[0.75em] font-bold leading-none text-yellow-800">Pendiente
                                                de revision</span>
                                        @elseif ($req->fecha_carga && $req->fecha_revision && $req->valido == 1)
                                            <div class="flex w-full justify-center">
                                                <button wire:click='descargar({{ $req->id_requisito_cargado }})'>
                                                    <div class="bg-green-300 rounded">
                                                        <div class="flex flex-row items-center p-1">
                                                            {{-- <div class="p-1 text-green-800 text-sm">Descargar</div> --}}
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                viewBox="0 0 24 24" stroke-width="1.5" stroke="green"
                                                                class="w-6 h-6">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                                            </svg>
                                                        </div>
                                                    </div>
                                                </button>
                                            </div>
                                        @elseif(Str::startsWith($req->requisito, 'Formulario'))
                                            @if ($req->renglon == '029')
                                                <div class="flex w-full justify-center">
                                                    <button>
                                                        <div class="flex flex-row items-center p-1">
                                                            <div
                                                                class=class="inline-block whitespace-nowrap rounded-[0.27rem] bg-blue-500 px-[0.65em] pb-[0.25em] pt-[0.35em] text-center text-md align-baseline text-[0.75em] font-bold leading-none text-white">
                                                                <a type="button"
                                                                    href="{{ route('presentar_formulario029', ['id_candidato' => 1]) }}">Formulario</a>
                                                            </div>
                                                        </div>
                                                    </button>
                                                </div>
                                            @else
                                                <div class="flex w-full justify-center">
                                                    <a type="button"
                                                        href="{{ route('presentar_formulario', ['id_candidato' => 1, 'id_requisito' => $req->id]) }}">
                                                        <div class="bg-primary rounded">
                                                            <div class="flex flex-row items-center p-1">
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                    viewBox="0 0 24 24" stroke-width="1.5"
                                                                    stroke="white" class="w-6 h-6">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                                                </svg>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            @endif
                                        @elseif($req->revisado == 1 && $req->valido == 0)
                                            <input wire:model='requisito.{{ $req->id }}' accept=".pdf"
                                                class="relative m-0 block w-full min-w-0 flex-auto cursor-pointer rounded border border-solid border-neutral-300 bg-clip-padding px-3 py-[0.32rem] text-xs font-normal text-neutral-700 transition duration-300 ease-in-out file:-mx-3 file:-my-[0.32rem] file:cursor-pointer file:overflow-hidden file:rounded-none file:border-0 file:border-solid file:border-inherit file:bg-neutral-100 file:px-3 file:py-[0.32rem] file:text-neutral-700 file:transition file:duration-150 file:ease-in-out file:[border-inline-end-width:1px] file:[margin-inline-end:0.75rem] hover:file:bg-neutral-200 focus:border-primary focus:text-neutral-700 focus:shadow-te-primary focus:outline-none dark:border-neutral-600 dark:text-neutral-200 dark:file:bg-neutral-700 dark:file:text-neutral-100 dark:focus:border-primary"
                                                id="requisito_{{ $req->id }}" type="file" />
                                        @else
                                            <input wire:model='requisito.{{ $req->id }}' accept=".pdf"
                                                class="relative m-0 block w-full min-w-0 flex-auto cursor-pointer rounded border border-solid border-neutral-300 bg-clip-padding px-3 py-[0.32rem] text-xs font-normal text-neutral-700 transition duration-300 ease-in-out file:-mx-3 file:-my-[0.32rem] file:cursor-pointer file:overflow-hidden file:rounded-none file:border-0 file:border-solid file:border-inherit file:bg-neutral-100 file:px-3 file:py-[0.32rem] file:text-neutral-700 file:transition file:duration-150 file:ease-in-out file:[border-inline-end-width:1px] file:[margin-inline-end:0.75rem] hover:file:bg-neutral-200 focus:border-primary focus:text-neutral-700 focus:shadow-te-primary focus:outline-none dark:border-neutral-600 dark:text-neutral-200 dark:file:bg-neutral-700 dark:file:text-neutral-100 dark:focus:border-primary"
                                                id="requisito_{{ $req->id }}" type="file" />
                                        @endif

                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-2">
                {{ $requisitos->links('pagination::tailwind') }}
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
