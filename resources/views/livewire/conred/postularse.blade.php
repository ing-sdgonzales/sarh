<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Puestos laborales') }}
        </h2>
    </x-slot>

    <div class="py-12 h-full">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-10">
            <div class="bg-white dark:bg-gray-800 overflow-x-hidden shadow-xl sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full rounded-lg overflow-x-hidden text-center">
                        <thead class="bg-gray-300 dark:bg-gray-800 text-center">
                            <tr class="text-gray-800 dark:text-gray-300">
                                <th class="w-1/4 py-2 px-4">Puesto</th>
                                <th class="w-1/12 py-2 px-4">Renglón</th>
                                <th class="w-1/12 py-2 px-4">Postularse</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-600">
                            @foreach ($vacantes as $vacante)
                                <tr
                                    class="text-gray-800 dark:text-gray-200 border-b border-gray-300 dark:border-gray-700">
                                    <td class="py-2 px-4">{{ $vacante->puesto }}</td>
                                    <td class="py-2 px-4">{{ $vacante->renglon }}</td>
                                    <td class="py-2 px-4">
                                        <div class="flex w-full justify-center">
                                            <a type="button"
                                                href="{{ route('postularse.formulario.index', ['id_puesto' => $vacante->id_puesto]) }}">
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
