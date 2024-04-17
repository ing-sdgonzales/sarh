<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 h-full">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                {{-- <x-welcome /> --}}
                <livewire:dashboard.contratistas-regionales position="a1" />
            </div>
        </div>
    </div>
    {{-- @push('js')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            var puestos_renglon = @json($puestos_renglon)

            // Configurar el gráfico con los datos obtenidos de la base de datos
            var labels = Object.keys(puestos_renglon);
            var values = Object.values(puestos_renglon);

            var pprc_ctx = document.getElementById('puestos_por_renglon_chart').getContext('2d');
            var pprc = new Chart(pprc_ctx, {
                type: 'pie', // Cambiar el tipo de gráfico a pie
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Cantidad de puestos por renglón',
                        data: values, // Ejemplo de datos
                        backgroundColor: [
                            'rgba(0, 123, 255, 0.5)', // Azul
                            'rgba(108, 117, 125, 0.5)', // Gris
                            'rgba(40, 167, 69, 0.5)', // Verde
                            'rgba(220, 53, 69, 0.5)', // Rojo
                        ],
                        borderColor: [
                            'rgba(0, 123, 255, 1)',
                            'rgba(108, 117, 125, 1)',
                            'rgba(40, 167, 69, 1)',
                            'rgba(220, 53, 69, 1)',
                        ],
                        hoverOffset: 40,
                        borderWidth: 1
                    }]
                },
                options: {
                    plugins: {
                        legend: {
                            labels: {
                                font: {
                                    size: 14
                                },
                                color: '#0000000'
                            }
                        }
                    },
                    layout: {
                        padding: 20
                    }
                }
            });
        </script>
    @endpush --}}
</x-app-layout>
