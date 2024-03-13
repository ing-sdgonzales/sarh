<div class="min-h-screen flex justify-center items-center dark:bg-gray-900"
    style="background-image: radial-gradient(circle, #0057b8 20%, #002c59 90%);">
    <div class="w-full sm:max-w-3xl bg-gray-200 dark:bg-gray-800 shadow-2xl sm:rounded-lg overflow-hidden border-orange-500 border-2"
        style="height: 400px;">
        <div class="flex justify-center items-center h-full">
            <div class="grid grid-cols-2 gap-6">
                <div class="flex flex-col items-center justify-center p-2">
                    <b class="text-center text-gray-700 dark:text-gray-300">-SARH-</b>
                    <div>
                        {{ $logo }}
                    </div>
                    <b class="text-center text-gray-700 dark:text-gray-300">Sistema de Administración de Recursos
                        Humanos</b>
                </div>

                <div class="flex items-center justify-center p-6">
                    <div class="w-full">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
