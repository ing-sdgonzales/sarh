<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Proceso de contratación') }}
        </h2>
    </x-slot>

    <div class="py-12 h-full">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-2">
                @can('Ver expediente')
                    <a type="button" href="{{ route('expedientes', ['candidato_id' => $id_candidato]) }}">
                        <div
                            class="inline-block rounded-lg bg-primary px-6 pb-2 pt-2.5 text-md font-medium leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-primary-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-primary-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-primary-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]">
                            {{ __('Expediente') }}
                        </div>
                    </a>
                @endcan
            </div>
            <div class="w-full max-w-6xl mx-auto px-4 md:px-6 py-2">
                <div class="flex flex-col justify-center divide-y divide-slate-200 [&>*]:py-2">
                    <div class="w-full max-w-3xl mx-auto">
                        <div
                            class="space-y-8 relative before:absolute before:inset-0 before:ml-5 before:-translate-x-px md:before:mx-auto md:before:translate-x-0 before:h-full before:w-0.5 before:bg-gradient-to-b before:from-transparent before:via-slate-300 before:to-transparent">
                            @foreach ($etapas_array as $key => $etapa)
                                @if ($key > 0)
                                    @if ($etapa['fecha_inicio'] && $etapa['fecha_fin'] == null)
                                        <!-- Item -->
                                        <div
                                            class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active">
                                            <!-- Icon -->
                                            <div
                                                class="flex items-center justify-center w-10 h-10 rounded-full border border-yellow-500 bg-slate-300 group-[.is-active]:bg-yellow-400 text-slate-500 group-[.is-active]:text-emerald-50 shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="w-7 h-7">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                            <!-- Card -->
                                            <div
                                                class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] bg-white dark:bg-gray-600 dark:border-none p-4 rounded-lg border border-slate-200 shadow">
                                                <div class="flex items-center justify-between space-x-2 mb-1">
                                                    <div class="font-bold text-slate-900 dark:text-gray-200">{{ $etapa['etapa'] }}</div>
                                                    <time
                                                        class="font-caveat font-medium text-indigo-500 dark:text-gray-200">{{ date('d-m-Y', strtotime($etapa['fecha_inicio'])) }}</time>
                                                </div>
                                                {{-- <div class="text-slate-500">Pretium lectus quam id leo. Urna et pharetra aliquam
                                        vestibulum morbi blandit cursus risus.</div> --}}
                                            </div>
                                        </div>
                                    @elseif($etapa['fecha_inicio'] && $etapa['fecha_fin'])
                                        <!-- Item -->
                                        <div
                                            class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active">
                                            <!-- Icon -->
                                            <div
                                                class="flex items-center justify-center w-10 h-10 rounded-full border border-green-600 bg-slate-300 group-[.is-active]:bg-emerald-500 text-slate-500 group-[.is-active]:text-emerald-50 shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2">
                                                <svg class="fill-current" xmlns="http://www.w3.org/2000/svg"
                                                    width="12" height="10">
                                                    <path fill-rule="nonzero"
                                                        d="M10.422 1.257 4.655 7.025 2.553 4.923A.916.916 0 0 0 1.257 6.22l2.75 2.75a.916.916 0 0 0 1.296 0l6.415-6.416a.916.916 0 0 0-1.296-1.296Z" />
                                                </svg>
                                            </div>
                                            <!-- Card -->
                                            <div
                                                class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] bg-white dark:bg-gray-600 dark:border-none p-4 rounded-lg border border-slate-200 shadow">
                                                <div class="flex items-center justify-between space-x-2 mb-1">
                                                    <div class="font-bold text-slate-900 dark:text-gray-200">{{ $etapa['etapa'] }}</div>
                                                    <time
                                                        class="font-caveat font-medium text-indigo-500 dark:text-gray-200">{{ date('d-m-Y', strtotime($etapa['fecha_fin'])) }}</time>
                                                </div>
                                                {{-- <div class="text-slate-500">Pretium lectus quam id leo. Urna et pharetra aliquam
                                vestibulum morbi blandit cursus risus.</div> --}}
                                            </div>
                                        </div>
                                    @else
                                        <!-- Item -->
                                        <div
                                            class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active">
                                            <!-- Icon -->
                                            <div
                                                class="flex items-center justify-center w-10 h-10 rounded-full border border-gray-500 bg-slate-300 group-[.is-active]:bg-gray-400 text-slate-500 group-[.is-active]:text-emerald-50 shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2">
                                                {{-- <svg class="fill-current" xmlns="http://www.w3.org/2000/svg"
                                            width="12" height="10">
                                            <path fill-rule="nonzero"
                                                d="M10.422 1.257 4.655 7.025 2.553 4.923A.916.916 0 0 0 1.257 6.22l2.75 2.75a.916.916 0 0 0 1.296 0l6.415-6.416a.916.916 0 0 0-1.296-1.296Z" />
                                        </svg> --}}
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="w-7 h-7">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                            <!-- Card -->
                                            <div
                                                class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] bg-white dark:bg-gray-600 dark:border-none p-4 rounded-lg border border-slate-200 shadow">
                                                <div class="flex items-center justify-between space-x-2 mb-1">
                                                    <div class="font-bold text-slate-900 dark:text-gray-200">{{ $etapa['etapa'] }}</div>
                                                    {{-- <time
                                                        class="font-caveat font-medium text-indigo-500 dark:text-gray-200">{{ $etapa['fecha_inicio'] }}</time> --}}
                                                </div>
                                                {{-- <div class="text-slate-500">Pretium lectus quam id leo. Urna et pharetra aliquam
                                vestibulum morbi blandit cursus risus.</div> --}}
                                            </div>
                                        </div>
                                    @endif
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
