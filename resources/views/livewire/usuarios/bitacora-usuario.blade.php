<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Bitácora de usuario') }}
        </h2>
    </x-slot>
    <div class="py-12 bg-gray-200 h-screen">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="mt-2 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6 mb-2">
                <div class="sm:col-span-2">
                    <div class="mt-2">
                        <select wire:model='usuario' id="usuario" name="usuario" wire:change='getActividadesByUsuario'
                            required
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            <option value="">Seleccionar usuario...</option>
                            @foreach ($usuarios as $usr)
                                <option value="{{ $usr->id }}">
                                    {{ $usr->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <table class="min-w-full bg-white rounded-lg overflow-hidden text-center">
                    <thead class="bg-gray-100 text-center">
                        <tr>
                            <th class="w-1/12 py-2 px-4">No.</th>
                            <th class="w-1/12 py-2 px-4">Usuario</th>
                            <th class="w-1/4 py-2 px-4">Acciones</th>
                            <th class="w-1/12 py-2 px-4">Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($actividades as $actividad)
                            <tr>
                                <td class="py-2 px-4">{{ $loop->iteration }}.</td>
                                <td class="py-2 px-4">{{ $actividad->name }}</td>
                                <td class="py-2 px-4 text-justify">{{ $actividad->description }}</td>
                                <td class="py-2 px-4">{{ date('d-m-Y H:i:s', strtotime($actividad->updated_at)) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-2 w-full">
                {{ $actividades->onEachSide(1)->links('pagination::tailwind') }}
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
