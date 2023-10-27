<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Formulario de solicitud de contratación') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-200">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="mt-2 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6 mb-2">
                <div class="sm:col-span-6">
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="relative p-4">

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