<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Consultas') }}
        </h2>
    </x-slot>

    <div class="relative p-4">
        <div class="space-y-12 h-full">
            <div class="border-b border-gray-900/10 dark:border-b-gray-600 pb-6">
                <div class="mt-2 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                    <div class="sm:col-span-3">
                        <x-label for=seccion value="{{ __('División') }}" />
                        <div class="mt-2">
                            <x-input wire:model='seccion' type="text" name="seccion" id="seccion" required
                                class="block w-full" disabled readonly />
                        </div>
                        <div>
                            <span class="text-red-600 text-sm">
                                @error('seccion')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                    </div>

                    <div class="sm:col-span-3">
                        <x-label for=direccion value="{{ __('Dirección o Unidad') }}" />
                        <div class="mt-2">
                            <x-input wire:model='direccion' type="text" name="direccion" id="direccion" required
                                class="block w-full" disabled readonly />
                        </div>
                        <div>
                            <span class="text-red-600 text-sm">
                                @error('direccion')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                    </div>
                    <div class="sm:col-span-full">
                        <div class="text-xl">
                            <h1 class="p-2 mt-8 font-semibold leading-7 text-gray-900 dark:text-gray-400">Registro
                                de personal
                            </h1>
                        </div>
                        <div class="bg-white dark:bg-gray-800 overflow-x-hidden shadow-xl sm:rounded-lg">
                            <div>
                                <table class="min-w-full rounded-lg overflow-x-hidden text-center">
                                    <thead class="bg-gray-300 dark:bg-gray-800 text-center">
                                        <tr class="text-gray-800 dark:text-gray-300">
                                            <th class="w-1/12 py-2 px-4">No.</th>
                                            <th class="w-1/4 py-2 px-4">Nombre</th>
                                            <th class="w-1/6 py-2 px-4">Reporte</th>
                                            <th class="w-1/6 py-2 px-4">Departamento</th>
                                            <th class="w-1/12 py-2 px-4">Grupo</th>
                                            <th class="w-1/6 py-2 px-4">Observación</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-gray-600">
                                        @foreach ($personal as $emp)
                                            <tr
                                                class="text-gray-800 dark:text-gray-200 border-b border-gray-300 dark:border-gray-700">
                                                <td class="py-2 px-4">{{ $loop->iteration . '.' }}</td>
                                                <td class="py-2 px-4">{{ $emp->nombre }}</td>
                                                <td class="py-2 px-4">{{ $emp->reporte }}</td>
                                                <td class="py-2 px-4">{{ $emp->departamento }}</td>
                                                <td class="py-2 px-4">{{ $emp->grupo }}</td>
                                                <td class="py-2 px-4">{{ $emp->observacion }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="mt-2">
                            {{ $personal->links() }}
                        </div>
                    </div>

                    <div class="sm:col-span-full">
                        <div class="text-xl">
                            <h1 class="p-2 mt-8 font-semibold leading-7 text-gray-900 dark:text-gray-400">Registro
                                de contratistas
                            </h1>
                        </div>
                        <div class="bg-white dark:bg-gray-800 overflow-x-hidden shadow-xl sm:rounded-lg">
                            <div>
                                <table class="min-w-full rounded-lg overflow-x-hidden text-center">
                                    <thead class="bg-gray-300 dark:bg-gray-800 text-center">
                                        <tr class="text-gray-800 dark:text-gray-300">
                                            <th class="w-1/12 py-2 px-4">No.</th>
                                            <th class="w-1/4 py-2 px-4">Nombre</th>
                                            <th class="w-1/6 py-2 px-4">Reporte</th>
                                            <th class="w-1/6 py-2 px-4">Departamento</th>
                                            <th class="w-1/12 py-2 px-4">Grupo</th>
                                            <th class="w-1/6 py-2 px-4">Observación</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-gray-600">
                                        @foreach ($contratistas as $emp)
                                            <tr
                                                class="text-gray-800 dark:text-gray-200 border-b border-gray-300 dark:border-gray-700">
                                                <td class="py-2 px-4">{{ $loop->iteration . '.' }}</td>
                                                <td class="py-2 px-4">{{ $emp->nombre }}</td>
                                                <td class="py-2 px-4">{{ $emp->reporte }}</td>
                                                <td class="py-2 px-4">{{ $emp->departamento }}</td>
                                                <td class="py-2 px-4">{{ $emp->grupo }}</td>
                                                <td class="py-2 px-4">{{ $emp->observacion }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="mt-2">
                            {{ $contratistas->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
