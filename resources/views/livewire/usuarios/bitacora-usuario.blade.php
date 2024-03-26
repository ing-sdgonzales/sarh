<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Bitácora de usuario') }}
        </h2>
    </x-slot>

    <div class="py-12 h-full">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="mt-2 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6 mb-2">
                <div class="sm:col-span-2">
                    <div class="mt-2">
                        <x-select wire:model='usuario' id="usuario" name="usuario" wire:change='getActividadesByUsuario'
                            required style="height: 42px;" class="block w-full">
                            <option value="">Seleccionar usuario...</option>
                            @foreach ($usuarios as $usr)
                                <option value="{{ $usr->id }}">
                                    {{ $usr->name }}
                                </option>
                            @endforeach
                        </x-select>
                    </div>
                </div>
            </div>

            <div {{-- class="overflow-x-auto" --}}>
                <div class="bg-white dark:bg-gray-800 shadow-xl sm:rounded-md">
                    <table
                        class="min-w-full border-2 border-separate border-spacing-0 text-center shadow-lg rounded-md border-solid border-gray-300 dark:border-gray-800">
                        <thead class="bg-gray-300 dark:bg-gray-800 text-center">
                            <tr class="text-gray-800 dark:text-gray-300">
                                <th class="w-1/6 py-2 px-4">Usuario</th>
                                <th class="w-1/4 py-2 px-4">Acciones</th>
                                <th class="w-1/12 py-2 px-4">Fecha</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-600">
                            @foreach ($actividades as $actividad)
                                <tr
                                    class="text-gray-800 dark:text-gray-200 border-b border-gray-300 dark:border-gray-700">
                                    <td
                                        class="py-2 px-4 {{ $loop->last ? 'border-none' : 'border-b border-gray-200 dark:border-gray-700' }}">
                                        {{ $actividad->name }}</td>
                                    <td
                                        class="py-2 px-4 text-justify {{ $loop->last ? 'border-none' : 'border-b border-gray-200 dark:border-gray-700' }}">
                                        {{ $actividad->description }}</td>
                                    <td
                                        class="py-2 px-4 {{ $loop->last ? 'border-none' : 'border-b border-gray-200 dark:border-gray-700' }}">
                                        {{ date('d-m-Y H:i:s', strtotime($actividad->updated_at)) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="mt-2 w-full">
                {{ $actividades->links() }}
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
    @endpush
</div>
