<div>
    <div class="flex">
        <!-- Barra lateral -->
        <div class="w-1/6 bg-gray-100 dark:bg-gray-800 vh-100">
            <div class="flex h-screen flex-col justify-between bg-white dark:bg-gray-800">
                <div class="px-4 py-6">
                    <ul class="mt-6 space-y-1">
                        <div class="mt-2 mb-2">
                            <li>
                                <x-button wire:click="mostrarFormulario('datos-personales')"
                                    class="block w-full text-left text-md" :autofocus="$formulario === 'datos-personales' ? true : false">
                                    {{ __('Datos personales') }}
                                </x-button>
                            </li>
                        </div>
                        <div class="mt-2 mb-2">
                            <li>
                                <x-button wire:click="mostrarFormulario('datos-laborales')"
                                    class="block w-full text-left text-md" :autofocus="$formulario === 'datos-laborales' ? true : false">
                                    {{ __('Datos académicos') }}
                                </x-button>
                            </li>
                        </div>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Contenido principal -->
        <div class="w-5/6 p-8">
            @if ($formulario == 'datos-laborales')
                @include('livewire.conred.formulario.datos-laborales')
            @else
                @include('livewire.conred.formulario.datos-personales')
            @endif
        </div>
    </div>
    <div wire:loading.flex wire:target="guardarDatosPersonales"
        class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50">
        <div class="animate-spin rounded-full h-32 w-32 border-t-4 border-b-4 border-[#FF921F] bg-transparent">
        </div>
    </div>
    <div wire:loading.flex wire:target="guardarDatosPersonalesAfterCaptcha"
        class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50">
        <div class="animate-spin rounded-full h-32 w-32 border-t-4 border-b-4 border-[#FF921F] bg-transparent">
        </div>
    </div>
    <div wire:loading.flex wire:target="guardarDatosLaborales"
        class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50">
        <div class="animate-spin rounded-full h-32 w-32 border-t-4 border-b-4 border-[#FF921F] bg-transparent">
        </div>
    </div>
    <div wire:loading.flex wire:target="guardarDatosLaboralesAfterCaptcha"
        class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50">
        <div class="animate-spin rounded-full h-32 w-32 border-t-4 border-b-4 border-[#FF921F] bg-transparent">
        </div>
    </div>
    <div wire:loading.flex wire:target="completarFormulario"
        class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50">
        <div class="animate-spin rounded-full h-32 w-32 border-t-4 border-b-4 border-orange-500 bg-transparent">
        </div>
    </div>
    @push('js')
        <script src="https://www.google.com/recaptcha/api.js?render={{ env('RECAPTCHAV3_SITEKEY') }}"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Livewire.on('captchaCallback', data => {
                    grecaptcha.ready(function() {
                        grecaptcha.execute("{{ env('RECAPTCHAV3_SITEKEY') }}", {
                                action: 'submit'
                            })
                            .then(function(token) {
                                @this.call('guardarDatosPersonalesAfterCaptcha', token)
                            });
                    });
                });

                Livewire.on('captchaCallbackDL', data => {
                    grecaptcha.ready(function() {
                        grecaptcha.execute("{{ env('RECAPTCHAV3_SITEKEY') }}", {
                                action: 'submit'
                            })
                            .then(function(token) {
                                console.log('captchaset');
                                @this.call('guardarDatosLaboralesAfterCaptcha', token)
                            });
                    });
                });
            });
        </script>
        @if (session()->has('message'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: '¡Hecho!',
                    showConfirmButton: false,
                    timer: 2000
                })
            </script>
        @endif
        {{-- Error en crear nuevo registro --}}
        @if (session()->has('errorValidate'))
            <script>
                Swal.fire({
                    icon: 'error',
                    title: '¡Ups!',
                    showConfirmButton: true,
                    html: `<small class="text-danger">{{ session('errorValidate') }}</small>`,
                    confirmButtonColor: '#1F2937'
                })
            </script>
        @endif
        @if (session()->has('error'))
            <script>
                Swal.fire({
                    icon: 'error',
                    title: '¡Ups!',
                    showConfirmButton: true,
                    text: `<?php echo session('error'); ?>`,
                    confirmButtonColor: '#1F2937'
                })
            </script>
        @endif
    @endpush
</div>
