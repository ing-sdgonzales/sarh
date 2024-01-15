<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Historial médico') }}
        </h2>
    </x-slot>
    <div class="py-12 bg-gray-200 h-auto">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="mt-2 grid grid-cols-8 gap-x-6 gap-y-8 mb-2">
                <div class="col-span-8">
                    <div class="relative rounded-md shadow-sm">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <span class="text-gray-500 sm:text-sm"><svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                                </svg>
                            </span>
                        </div>
                        <input wire:model.live="busqueda" type="text" name="search" id="search"
                            style="height: 42px;" autocomplete="off"
                            class="inline-block w-full rounded-lg border-0 py-1.5 pl-10 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset shadow-md focus:ring-indigo-600 sm:text-sm sm:leading-6"
                            placeholder="Buscar">
                    </div>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 shadow-xl sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white rounded-lg text-center">
                        <thead class="bg-gray-100 text-center">
                            <tr>
                                <th class="w-1/12 py-2 px-4">Renglón</th>
                                <th class="w-1/12 py-2 px-4">Foto</th>
                                <th class="w-1/4 py-2 px-4">Nombre</th>
                                <th class="w-1/12 py-2 px-4">Edad</th>
                                <th class="w-1/4 py-2 px-4">Dependencia</th>
                                <th class="w-1/12 py-2 px-4">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($empleados as $empleado)
                                <tr>
                                    <td class="py-2 px-4">{{ $empleado->renglon }}</td>
                                    <td class="py-2 px-4"><img src="{{ asset('storage') . '/' . $empleado->imagen }}"
                                            class="mx-auto max-w-full rounded-lg" style="height: 60px; width: 60px"
                                            alt="imagen" />
                                    </td>
                                    <td class="py-2 px-4">{{ $empleado->nombres }} {{ $empleado->apellidos }}</td>
                                    <td class="py-2 px-4">{{ $empleado->edad }} {{ __('años') }}</td>
                                    <td class="py-2 px-4">{{ $empleado->dependencia }}</td>
                                    <td class="py-2 px-4">
                                        <div class="flex w-full justify-center">
                                            <a type="button"
                                                href="{{ route('consultas', ['id_empleado' => $empleado->id]) }}">
                                                <div class="bg-primary rounded">
                                                    <div class="flex flex-row items-center p-1">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="white"
                                                            class="w-6 h-6">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                                                        </svg>
                                                    </div>
                                                </div>
                                            </a>
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
</div>
